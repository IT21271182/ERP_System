<?php
include '../includes/db.php';

// Handle search
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $sql = "SELECT item.id, item.item_code, item.item_name, item.quantity, item.unit_price, 
                   item_category.category AS item_category, item_subcategory.sub_category AS item_subcategory
            FROM item
            JOIN item_category ON item.item_category = item_category.id
            JOIN item_subcategory ON item.item_subcategory = item_subcategory.id
            WHERE item.item_name LIKE '%$searchQuery%' 
            OR item.item_code LIKE '%$searchQuery%' 
            OR item_category.category LIKE '%$searchQuery%' 
            OR item_subcategory.sub_category LIKE '%$searchQuery%'";
} else {
    $sql = "SELECT item.id, item.item_code, item.item_name, item.quantity, item.unit_price, 
                   item_category.category AS item_category, item_subcategory.sub_category AS item_subcategory
            FROM item
            JOIN item_category ON item.item_category = item_category.id
            JOIN item_subcategory ON item.item_subcategory = item_subcategory.id";
}
$result = mysqli_query($conn, $sql);

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM item WHERE id=$delete_id");
    header("Location: view_items.php");
}
?>

<h2>Items List</h2>

<!-- Add Item Button -->
<a href="add_item.php" class="button">Add new Item</a>

<!-- Search Form -->
<form method="GET" action="">
    <input type="text" name="search" placeholder="Search by name, code, or category" value="<?= htmlspecialchars($searchQuery); ?>">
    <button type="submit">Search</button>
    <a href="view_items.php">Clear</a> <!-- Clear search -->
</form>

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
    <?php if (mysqli_num_rows($result) > 0): ?>
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
    <?php else: ?>
        <tr>
            <td colspan="8">No items found.</td>
        </tr>
    <?php endif; ?>
</table>
