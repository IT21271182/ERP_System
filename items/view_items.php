<?php
include '../includes/db.php';

$result = mysqli_query($conn, "SELECT * FROM item");

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM item WHERE id=$delete_id");
    header("Location: view_items.php");
}
?>

<h2>Items List</h2>
<a href="add_item.php" class="button">Add new Item</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Item Code</th>
        <th>Category</th>
        <th>Subcategory</th>
        <th>Name</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['item_code']; ?></td>
            <td><?= $row['item_category']; ?></td>
            <td><?= $row['item_subcategory']; ?></td>
            <td><?= $row['item_name']; ?></td>
            <td><?= $row['quantity']; ?></td>
            <td><?= $row['unit_price']; ?></td>
            <td>
                <a href="update_item.php?id=<?= $row['id']; ?>">Update</a>
                <a href="?delete_id=<?= $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>
