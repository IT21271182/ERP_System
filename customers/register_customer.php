<?php
include('../includes/db.php');

// Initialize error variables
$titleErr = $firstNameErr = $lastNameErr = $contactNoErr = $districtErr = "";
$title = $first_name = $middle_name = $last_name = $contact_no = $district = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $contact_no = $_POST['contact_no'];
    $district = $_POST['district'];

    // Basic validation
    if (empty($title)) { $titleErr = "Title is required."; }
    if (empty($first_name)) { $firstNameErr = "First name is required."; }
    if (empty($last_name)) { $lastNameErr = "Last name is required."; }
    if (empty($contact_no)) { $contactNoErr = "Contact number is required."; }
    if (!preg_match("/^[0-9]{10}$/", $contact_no)) { $contactNoErr = "Invalid contact number."; }
    if (empty($district)) { $districtErr = "District is required."; }

    // Insert into database if no errors
    if (empty($titleErr) && empty($firstNameErr) && empty($lastNameErr) && empty($contactNoErr) && empty($districtErr)) {
        $sql = "INSERT INTO customer (title, first_name, middle_name, last_name, contact_no, district) 
                VALUES ('$title', '$first_name', '$middle_name', '$last_name', '$contact_no', '$district')";
        if ($conn->query($sql) === TRUE) {
            echo "Customer registered successfully.";
            header("Location: view_customers.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Fetch districts from the database
$districtQuery = "SELECT district FROM district";
$districtResult = $conn->query($districtQuery);
$districts = [];

if ($districtResult->num_rows > 0) {
    while ($row = $districtResult->fetch_assoc()) {
        $districts[] = $row['district'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Customer</title>

    <!-- Link to the external styles.css file -->
    <link href="../asserts/css/styles.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script>
    function validateForm() {
        var contactNo = document.forms["customerForm"]["contact_no"].value;
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
        max-width: 600px; /* Reduced max-width */
        background-color: #ffffff;
        padding: 25px; /* Reduced padding */
        border-radius: 10px; /* Reduced border-radius */
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        margin-top: 40px;
        border-top: 3px solid #007bff;
    }

    h2 {
        text-align: center;
        color: #6c63ff;
        margin-bottom: 20px; /* Reduced margin */
        font-size: 1.8rem; /* Reduced font-size */
        font-weight: bold;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 6px; /* Reduced padding */
        margin-bottom: 1px;
    }

    .form-group {
        margin-bottom: 1rem; /* Reduced margin */
    }

    label {
        font-weight: 600;
        color: #495057;
    }

    .error-message {
        color: red;
        font-size: 0.9rem;
    }

    .btn-submit {
        background-color: #007bff;
        color: white;
        border-radius: 8px; /* Reduced border-radius */
        padding: 10px 15px; /* Reduced padding */
        width: 100%;
        cursor: pointer;
        font-size: 1rem; /* Reduced font-size */
    }

    .btn-submit:hover {
        background-color: #5a54e5;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px; /* Reduced gap */
    }

    .form-row .form-group {
        flex: 1;
        min-width: calc(50% - 5px); /* Adjusted min-width */
    }

    @media (max-width: 767px) {
        .form-row .form-group {
            min-width: 100%;
        }

        .container {
            padding: 15px; /* Reduced padding for smaller screens */
        }
    }

    /* Customizing Bootstrap Dropdown */
    .custom-select {
        border-radius: 8px; /* Reduced border-radius */
        border: 1px solid #ccc;
        padding: 8px; /* Reduced padding */
    }
    </style>
</head>

<body>
    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h2>Register Customer</h2>
        <form name="customerForm" method="POST" onsubmit="return validateForm()">

            <div class="form-row">
                <!-- Title Dropdown -->
                <div class="form-group col-md-6">
                    <label for="title">Title:</label>
                    <select name="title" class="form-control">
                        <option value="">Select Title</option>
                        <option value="Mr." <?php if ($title == "Mr.") echo "selected"; ?>>Mr.</option>
                        <option value="Ms." <?php if ($title == "Ms.") echo "selected"; ?>>Ms.</option>
                        <option value="Dr." <?php if ($title == "Dr.") echo "selected"; ?>>Dr.</option>
                    </select>
                    <div class="error-message"><?php echo $titleErr; ?></div>
                </div>

                <!-- First Name -->
                <div class="form-group col-md-6">
                    <label for="first_name">First Name:</label>
                    <input type="text" class="form-control" name="first_name" value="<?php echo $first_name; ?>">
                    <div class="error-message"><?php echo $firstNameErr; ?></div>
                </div>
            </div>

            <!-- Name Inputs (Middle and Last Name on the same row) -->
            <div class="form-row">
                <!-- Middle Name -->
                <div class="form-group col-md-6">
                    <label for="middle_name">Middle Name:</label>
                    <input type="text" class="form-control" name="middle_name" value="<?php echo $middle_name; ?>">
                </div>

                <!-- Last Name -->
                <div class="form-group col-md-6">
                    <label for="last_name">Last Name:</label>
                    <input type="text" class="form-control" name="last_name" value="<?php echo $last_name; ?>">
                    <div class="error-message"><?php echo $lastNameErr; ?></div>
                </div>
            </div>

            <!-- Contact Number -->
            <div class="form-group">
                <label for="contact_no">Contact Number:</label>
                <input type="text" class="form-control" name="contact_no" value="<?php echo $contact_no; ?>">
                <div class="error-message"><?php echo $contactNoErr; ?></div>
            </div>

            <!-- District Dropdown -->
            <div class="form-group">
                <label for="district">District:</label>
                <select name="district" class="form-control">
                    <option value="">Select District</option>
                    <?php
                        foreach ($districts as $districtName) {
                            echo "<option value='$districtName' " . ($district == $districtName ? "selected" : "") . ">$districtName</option>";
                        }
                    ?>
                </select>
                <div class="error-message"><?php echo $districtErr; ?></div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">Register</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
