<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    $sql = "SELECT 
                inv.invoice_no AS Invoice_Number,
                inv.date AS Invoice_Date,
                cust.first_name AS Customer_Name,
                dist.district AS Customer_District,
                inv.item_count AS Item_Count,
                inv.amount AS Invoice_Amount
            FROM 
                invoice inv
            JOIN 
                customer cust ON inv.customer = cust.id
            JOIN 
                district dist ON cust.district = dist.id
            WHERE 
                inv.date BETWEEN ? AND ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Error: " . $conn->error); // Debugging for SQL errors
    }

    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        die("Execution Error: " . $stmt->error); // Debugging for execution errors
    }
    $invoices = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container mt-4">
        <h2 class="text-center">Report - Invoice</h2>

        <!-- Form for date range input -->
        <form method="POST" action="" class="mb-4">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>

        <?php if (!empty($invoices)): ?>
            <!-- Table for displaying the invoice data -->
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Invoice Number</th>
                        <th>Invoice Date</th>
                        <th>Customer Name</th>
                        <th>Customer District</th>
                        <th>Item Count</th>
                        <th>Invoice Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoices as $invoice): ?>
                        <tr>
                            <td><?= $invoice['Invoice_Number'] ?></td>
                            <td><?= $invoice['Invoice_Date'] ?></td>
                            <td><?= $invoice['Customer_Name'] ?></td>
                            <td><?= $invoice['Customer_District'] ?></td>
                            <td><?= $invoice['Item_Count'] ?></td>
                            <td><?= $invoice['Invoice_Amount'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
