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
</head>
<body>
<div class="container mt-5">
    <h2>Register Customer</h2>
    <form name="customerForm" method="POST" onsubmit="return validateForm()">
        <!-- Title Dropdown -->
        <label for="title">Title:</label>
        <select name="title" class="form-control">
            <option value="">Select Title</option>
            <option value="Mr." <?php if ($title == "Mr.") echo "selected"; ?>>Mr.</option>
            <option value="Ms." <?php if ($title == "Ms.") echo "selected"; ?>>Ms.</option>
            <option value="Dr." <?php if ($title == "Dr.") echo "selected"; ?>>Dr.</option>
        </select>
        <span style="color: red;"><?php echo $titleErr; ?></span><br><br>

        <!-- First Name -->
        <label for="first_name">First Name:</label>
        <input type="text" class="form-control" name="first_name" value="<?php echo $first_name; ?>">
        <span style="color: red;"><?php echo $firstNameErr; ?></span><br><br>

         <!-- Middle Name -->
         <label for="middle_name">Middle Name:</label>
        <input type="text" class="form-control" name="middle_name" value="<?php echo $middle_name; ?>">
        <span style="color: red;"><?php echo $lastNameErr; ?></span><br><br>

        <!-- Last Name -->
        <label for="last_name">Last Name:</label>
        <input type="text" class="form-control" name="last_name" value="<?php echo $last_name; ?>">
        <span style="color: red;"><?php echo $lastNameErr; ?></span><br><br>

        <!-- Contact Number -->
        <label for="contact_no">Contact Number:</label>
        <input type="text" class="form-control" name="contact_no" value="<?php echo $contact_no; ?>">
        <span style="color: red;"><?php echo $contactNoErr; ?></span><br><br>

        <!-- District Dropdown -->
        <label for="district">District:</label>
        <select name="district" class="form-control">
            <option value="">Select District</option>
            <?php
            foreach ($districts as $districtName) {
                echo "<option value='$districtName' " . ($district == $districtName ? "selected" : "") . ">$districtName</option>";
            }
            ?>
        </select>
        <span style="color: red;"><?php echo $districtErr; ?></span><br><br>

        <input type="submit" value="Register">
    </form>
        </div>
</body>
</html>
