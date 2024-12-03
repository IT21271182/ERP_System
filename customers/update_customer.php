<?php
include('../includes/db.php');

// Fetch districts from the database for the dropdown
$districtQuery = "SELECT id, district FROM district";
$districtResult = $conn->query($districtQuery);
$districts = [];

if ($districtResult->num_rows > 0) {
    while ($row = $districtResult->fetch_assoc()) {
        $districts[] = $row;
    }
}

if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Fetch customer details
    $sql = "SELECT * FROM customer WHERE id = $customer_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
    } else {
        echo "Customer not found.";
        exit;
    }
}

// Handle update action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $contact_no = $_POST['contact_no'];
    $district_id = $_POST['district']; // Use district_id

    // Update query
    $updateSql = "UPDATE customer SET 
                    title = '$title', 
                    first_name = '$first_name', 
                    middle_name = '$middle_name', 
                    last_name = '$last_name', 
                    contact_no = '$contact_no', 
                    district = '$district_id'  -- Update district with ID
                  WHERE id = $customer_id";

    if ($conn->query($updateSql) === TRUE) {
        echo "Customer updated successfully.";
        header("Location: view_customers.php"); // Redirect to the customer list
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>

    <!-- Link to the external styles.css file -->
    <link href="../asserts/css/styles.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validateForm() {
            var contactNo = document.forms["updateForm"]["contact_no"].value;
            var contactPattern = /^[0-9]{10}$/;
            if (!contactPattern.test(contactNo)) {
                alert("Please enter a valid 10-digit contact number.");
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
        <h2>Update Customer</h2>
        <form name="updateForm" method="POST" onsubmit="return validateForm()">

            <!-- Title and Name Row -->
            <div class="form-row">
                <!-- Title Dropdown -->
                <div class="form-group col-md-6">
                    <label for="title">Title:</label>
                    <select name="title" class="form-control" required>
                        <option value="Mr." <?php echo ($customer['title'] == 'Mr.') ? 'selected' : ''; ?>>Mr.</option>
                        <option value="Mrs." <?php echo ($customer['title'] == 'Mrs.') ? 'selected' : ''; ?>>Mrs.</option>
                        <option value="Miss" <?php echo ($customer['title'] == 'Miss') ? 'selected' : ''; ?>>Miss</option>
                    </select>
                </div>

                <!-- First Name -->
                <div class="form-group col-md-6">
                    <label for="first_name">First Name:</label>
                    <input type="text" class="form-control" name="first_name" value="<?php echo $customer['first_name']; ?>" required>
                </div>
            </div>

            <!-- Middle Name and Last Name Row -->
            <div class="form-row">
                <!-- Middle Name -->
                <div class="form-group col-md-6">
                    <label for="middle_name">Middle Name:</label>
                    <input type="text" class="form-control" name="middle_name" value="<?php echo $customer['middle_name']; ?>">
                </div>

                <!-- Last Name -->
                <div class="form-group col-md-6">
                    <label for="last_name">Last Name:</label>
                    <input type="text" class="form-control" name="last_name" value="<?php echo $customer['last_name']; ?>" required>
                </div>
            </div>

            <!-- Contact Number -->
            <div class="form-group">
                <label for="contact_no">Contact Number:</label>
                <input type="text" class="form-control" name="contact_no" value="<?php echo $customer['contact_no']; ?>" required>
            </div>

            <!-- District Dropdown -->
            <div class="form-group">
                <label for="district">District:</label>
                <select name="district" class="form-control" required>
                    <option value="">Select District</option>
                    <?php
                    foreach ($districts as $district) {
                        echo "<option value='{$district['id']}' " . ($customer['district'] == $district['id'] ? "selected" : "") . ">{$district['district']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">Update Customer</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
