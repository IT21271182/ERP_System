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
</head>
<body>
    <h2>Invoice Report</h2>
    <form method="POST" action="">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>
        <button type="submit">Search</button>
    </form>

    <?php if (!empty($invoices)): ?>
        <table border="1">
            <thead>
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
</body>
</html>
