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
</head>
<body>
    <h2>Update Customer</h2>
    <form method="POST" action="">
        <label for="title">Title:</label>
        <select name="title" id="title" required>
            <option value="Mr." <?php echo ($customer['title'] == 'Mr.') ? 'selected' : ''; ?>>Mr.</option>
            <option value="Mrs." <?php echo ($customer['title'] == 'Mrs.') ? 'selected' : ''; ?>>Mrs.</option>
            <option value="Miss" <?php echo ($customer['title'] == 'Miss') ? 'selected' : ''; ?>>Miss</option>
        </select>
        <br><br>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $customer['first_name']; ?>" required>
        <br><br>
        <label for="middle_name">Middle Name:</label>
        <input type="text" id="middle_name" name="middle_name" value="<?php echo $customer['middle_name']; ?>">
        <br><br>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $customer['last_name']; ?>" required>
        <br><br>
        <label for="contact_no">Contact No:</label>
        <input type="text" id="contact_no" name="contact_no" value="<?php echo $customer['contact_no']; ?>" required>
        <br><br>
        <label for="district">District:</label>
        <select name="district" id="district" required>
            <option value="">Select District</option>
            <?php
            // Populate district dropdown
            foreach ($districts as $district) {
                echo "<option value='{$district['id']}' " . ($customer['district'] == $district['id'] ? "selected" : "") . ">{$district['district']}</option>";
            }
            ?>
        </select>
        <br><br>
        <button type="submit">Update Customer</button>
    </form>
</body>
</html>
