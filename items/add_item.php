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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>

    <!-- Link to the external styles.css file -->
    <link href="../asserts/css/styles.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script>
    function validateForm() {
        var quantity = document.forms["addItemForm"]["quantity"].value;
        var unitPrice = document.forms["addItemForm"]["unit_price"].value;
        if (isNaN(quantity) || isNaN(unitPrice)) {
            alert("Please enter valid numeric values for quantity and unit price.");
            return false;
        }
        return true;
    }
    </script>

    <style>
    body {
        background-color: #f9f9f9;
        color: #333;
        font-family: 'Arial', sans-serif;
    }

    .container {
        max-width: 600px;
        background-color: #ffffff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        margin-top: 40px;
        border-top: 3px solid #007bff;
    }

    h2 {
        text-align: center;
        color: #6c63ff;
        margin-bottom: 20px;
        font-size: 1.8rem;
        font-weight: bold;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 6px;
        margin-bottom: 1px;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    label {
        font-weight: 600;
        color: #495057;
    }

    .btn-submit {
        background-color: #007bff;
        color: white;
        border-radius: 8px;
        padding: 10px 15px;
        width: 100%;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-submit:hover {
        background-color: #5a54e5;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .form-row .form-group {
        flex: 1;
        min-width: calc(50% - 5px);
    }

    @media (max-width: 767px) {
        .form-row .form-group {
            min-width: 100%;
        }

        .container {
            padding: 15px;
        }
    }

    .custom-select {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 8px;
    }
    </style>
</head>

<body>
    <?php include('../includes/header.php'); ?>

    <div class="container">
        <h2>Add Item</h2>
        <form name="addItemForm" method="POST" onsubmit="return validateForm()">

            <!-- Item Code -->
            <div class="form-group">
                <label for="item_code">Item Code:</label>
                <input type="text" class="form-control" name="item_code" required>
            </div>

            <!-- Item Name -->
            <div class="form-group">
                <label for="item_name">Item Name:</label>
                <input type="text" class="form-control" name="item_name" required>
            </div>

            <!-- Item Category and Subcategory Row -->
            <div class="form-row">
                <!-- Item Category -->
                <div class="form-group col-md-6">
                    <label for="item_category">Item Category:</label>
                    <select name="item_category" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
                        <option value="<?= $category['id']; ?>"><?= $category['category']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Item Subcategory -->
                <div class="form-group col-md-6">
                    <label for="item_subcategory">Item Subcategory:</label>
                    <select name="item_subcategory" class="form-control" required>
                        <option value="">Select Subcategory</option>
                        <?php while ($subcategory = mysqli_fetch_assoc($subcategories)) { ?>
                        <option value="<?= $subcategory['id']; ?>"><?= $subcategory['sub_category']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <!-- Quantity and Unit Price row -->
            <div class="form-row">
                <!-- Quantity -->
                <div class="form-group col-md-6">
                    <label for="quantity">Quantity:</label>
                    <input type="text" class="form-control" name="quantity" required>
                </div>


                <!-- Unit Price -->
                <div class="form-group col-md-6">
                    <label for="unit_price">Unit Price:</label>
                    <input type="text" class="form-control" name="unit_price" required>
                </div>
            </div>

    <!-- Submit Button -->
    <button type="submit" class="btn-submit">Add Item</button>
    </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>