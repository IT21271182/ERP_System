<?php
include '../includes/db.php';

$sql = "SELECT 
            itm.item_name AS Item_Name,
            icat.category AS Item_Category,
            isub.sub_category AS Item_Sub_Category,
            SUM(itm.quantity) AS Total_Quantity
        FROM 
            item itm
        JOIN 
            item_category icat ON itm.item_category = icat.id
        JOIN 
            item_subcategory isub ON itm.item_subcategory = isub.id
        GROUP BY 
            itm.item_name, icat.category, isub.sub_category";
$result = $conn->query($sql);
$items = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container">
        <h2 class="text-center mt-4">Report - Item Details</h2>

        <!-- Table to display items report -->
        <table class="table table-bordered table-striped mt-4 ">
            <thead class="thead-dark">
                <tr>
                    <th>Item Name</th>
                    <th>Item Category</th>
                    <th>Item Sub-Category</th>
                    <th>Total Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= $item['Item_Name'] ?></td>
                        <td><?= $item['Item_Category'] ?></td>
                        <td><?= $item['Item_Sub_Category'] ?></td>
                        <td><?= $item['Total_Quantity'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
