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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Item</title>

    <!-- Link to the external styles.css file -->
    <link href="../asserts/css/styles.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
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
        <h2>Update Item</h2>
        <form method="POST" action="">

            <!-- Item Code -->
            <div class="form-group">
                <label for="item_code">Item Code:</label>
                <input type="text" class="form-control" name="item_code" value="<?= $item['item_code']; ?>" required>
            </div>

            <!-- Item Name -->
            <div class="form-group">
                <label for="item_name">Item Name:</label>
                <input type="text" class="form-control" name="item_name" value="<?= $item['item_name']; ?>" required>
            </div>

            <!-- Item Category and Subcategory Row -->
            <div class="form-row">
                <!-- Item Category -->
                <div class="form-group col-md-6">
                    <label for="item_category">Item Category:</label>
                    <select name="item_category" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
                        <option value="<?= $category['id']; ?>" <?= $category['id'] == $item['item_category'] ? 'selected' : ''; ?>>
                            <?= $category['category']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Item Subcategory -->
                <div class="form-group col-md-6">
                    <label for="item_subcategory">Item Subcategory:</label>
                    <select name="item_subcategory" class="form-control" required>
                        <option value="">Select Subcategory</option>
                        <?php while ($subcategory = mysqli_fetch_assoc($subcategories)) { ?>
                        <option value="<?= $subcategory['id']; ?>" <?= $subcategory['id'] == $item['item_subcategory'] ? 'selected' : ''; ?>>
                            <?= $subcategory['sub_category']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <!-- Quantity and Unit Price row -->
            <div class="form-row">
                <!-- Quantity -->
                <div class="form-group col-md-6">
                    <label for="quantity">Quantity:</label>
                    <input type="text" class="form-control" name="quantity" value="<?= $item['quantity']; ?>" required>
                </div>

                <!-- Unit Price -->
                <div class="form-group col-md-6">
                    <label for="unit_price">Unit Price:</label>
                    <input type="text" class="form-control" name="unit_price" value="<?= $item['unit_price']; ?>" required>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">Update Item</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
