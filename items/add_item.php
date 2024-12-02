<?php
include '../includes/db.php';

// Fetch categories and subcategories
$categories = mysqli_query($conn, "SELECT id, category FROM item_category");
$subcategories = mysqli_query($conn, "SELECT id, sub_category FROM item_subcategory");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_code = $_POST['item_code'];
    $item_name = $_POST['item_name'];
    $item_category = $_POST['item_category'];
    $item_subcategory = $_POST['item_subcategory'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    // Validation
    $errors = [];
    if (empty($item_code)) $errors[] = "Item code is required.";
    if (empty($item_name)) $errors[] = "Item name is required.";
    if (empty($item_category)) $errors[] = "Item category is required.";
    if (empty($item_subcategory)) $errors[] = "Item subcategory is required.";
    if (empty($quantity) || !is_numeric($quantity)) $errors[] = "Valid quantity is required.";
    if (empty($unit_price) || !is_numeric($unit_price)) $errors[] = "Valid unit price is required.";

    if (empty($errors)) {
        // Insert data
        $sql = "INSERT INTO item (item_code, item_category, item_subcategory, item_name, quantity, unit_price)
                VALUES ('$item_code', '$item_category', '$item_subcategory', '$item_name', '$quantity', '$unit_price')";
        if (mysqli_query($conn, $sql)) {
            echo "Item added successfully.";
            header("Location: view_items.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>

<h2>Add Item</h2>
<form method="POST" action="">
    <label>Item Code:</label>
    <input type="text" name="item_code"><br><br>
    <label>Item Name:</label>
    <input type="text" name="item_name"><br><br>
    <label>Item Category:</label>
    <select name="item_category">
        <option value="">Select Category</option>
        <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
            <option value="<?= $category['id']; ?>"><?= $category['category']; ?></option>
        <?php } ?>
    </select><br><br>
    <label>Item Subcategory:</label>
    <select name="item_subcategory">
        <option value="">Select Subcategory</option>
        <?php while ($subcategory = mysqli_fetch_assoc($subcategories)) { ?>
            <option value="<?= $subcategory['id']; ?>"><?= $subcategory['sub_category']; ?></option>
        <?php } ?>
    </select><br><br>
    <label>Quantity:</label>
    <input type="text" name="quantity"><br><br>
    <label>Unit Price:</label>
    <input type="text" name="unit_price"><br><br>
    <button type="submit">Add Item</button>
</form>
