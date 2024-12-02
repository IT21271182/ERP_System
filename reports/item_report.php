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
</head>
<body>
    <h2>Item Report</h2>

    <table border="1">
        <thead>
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
</body>
</html>
