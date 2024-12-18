<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    $sql = "SELECT 
                inv.invoice_no AS Invoice_Number,
                inv.date AS Invoice_Date,
                cust.first_name AS Customer_Name,
                itm.item_name AS Item_Name,
                itm.item_code AS Item_Code,
                icat.category AS Item_Category,
                invm.unit_price AS Item_Unit_Price
            FROM 
                invoice inv
            JOIN 
                customer cust ON inv.customer = cust.id
            JOIN 
                invoice_master invm ON inv.invoice_no = invm.invoice_no
            JOIN 
                item itm ON invm.item_id = itm.id
            JOIN 
                item_category icat ON itm.item_category = icat.id
            WHERE 
                inv.date BETWEEN ? AND ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Error: " . $conn->error); // Log SQL error
    }

    $stmt->bind_param("ss", $startDate, $endDate);
    if (!$stmt->execute()) {
        die("Execution Error: " . $stmt->error); // Log execution error
    }

    $result = $stmt->get_result();
    $invoiceItems = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Item Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container mt-4">
        <h2 class="text-center">Report - Invoice Items </h2>

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

        <?php if (!empty($invoiceItems)): ?>
            <!-- Table for displaying the invoice item data -->
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Invoice Number</th>
                        <th>Invoice Date</th>
                        <th>Customer Name</th>
                        <th>Item Name</th>
                        <th>Item Code</th>
                        <th>Item Category</th>
                        <th>Item Unit Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoiceItems as $item): ?>
                        <tr>
                            <td><?= $item['Invoice_Number'] ?></td>
                            <td><?= $item['Invoice_Date'] ?></td>
                            <td><?= $item['Customer_Name'] ?></td>
                            <td><?= $item['Item_Name'] ?></td>
                            <td><?= $item['Item_Code'] ?></td>
                            <td><?= $item['Item_Category'] ?></td>
                            <td><?= $item['Item_Unit_Price'] ?></td>
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
