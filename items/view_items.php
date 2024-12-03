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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Items</title>
    <!-- Link to the external styles.css file -->
    <link href="path/to/styles.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container">
        <h2 class="text-center mt-4">Items List</h2>

        <!-- Add Item Button (Aligned to the Right) -->
        <div class="d-flex justify-content-end mb-3">
            <a href="add_item.php" class="btn btn-success">Add New Item</a>
        </div>

        <!-- Search Form -->
        <div class="row justify-content-center mb-3">
            <div class="col-md-8">
                <form method="GET" action="" class="form-inline">
                    <input type="text" name="search" class="form-control w-75" placeholder="Search by name, code, or category" value="<?= htmlspecialchars($searchQuery); ?>">
                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                    <a href="view_items.php" class="btn btn-secondary ml-2">Clear</a>
                </form>
            </div>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
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
                </thead>
                <tbody>
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
                                <a href="update_item.php?id=<?= $row['id']; ?>" class="btn btn-info btn-sm">Update</a>
                                <a href="?delete_id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">No items found.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
