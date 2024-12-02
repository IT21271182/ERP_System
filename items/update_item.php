<?php
include '../includes/db.php';

// Fetch item details
$id = $_GET['id'];
$item = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM item WHERE id=$id"));

// Fetch categories and subcategories
$categories = mysqli_query($conn, "SELECT id, category FROM item_category");
$subcategories = mysqli_query($conn, "SELECT id, sub_category FROM item_subcategory");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_code = $_POST['item_code'];
    $item_name = $_POST['item_name'];
    $item_category = $_POST['item_category'];
    $item_subcategory = $_POST['item_subcategory'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    $sql = "UPDATE item SET 
            item_code='$item_code',
            item_name='$item_name',
            item_category='$item_category',
            item_subcategory='$item_subcategory',
            quantity='$quantity',
            unit_price='$unit_price'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: view_items.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Update Item</h2>
<form method="POST" action="">
    <label>Item Code:</label>
    <input type="text" name="item_code" value="<?= $item['item_code']; ?>"><br><br>
    <label>Item Name:</label>
    <input type="text" name="item_name" value="<?= $item['item_name']; ?>"><br><br>
    <label>Item Category:</label>
    <select name="item_category">
        <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
            <option value="<?= $category['id']; ?>" <?= $category['id'] == $item['item_category'] ? 'selected' : ''; ?>>
                <?= $category['category']; ?>
            </option>
        <?php } ?>
    </select><br><br>
    <label>Item Subcategory:</label>
    <select name="item_subcategory">
        <?php while ($subcategory = mysqli_fetch_assoc($subcategories)) { ?>
            <option value="<?= $subcategory['id']; ?>" <?= $subcategory['id'] == $item['item_subcategory'] ? 'selected' : ''; ?>>
                <?= $subcategory['sub_category']; ?>
            </option>
        <?php } ?>
    </select><br><br>
    <label>Quantity:</label>
    <input type="text" name="quantity" value="<?= $item['quantity']; ?>"><br><br>
    <label>Unit Price:</label>
    <input type="text" name="unit_price" value="<?= $item['unit_price']; ?>"><br><br>
    <button type="submit">Update Item</button>
</form>
