<?php
include('../includes/db.php');

// Fetch customers from the database
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);

// Handle delete action
if (isset($_GET['delete'])) {
    $customer_id = $_GET['delete'];
    $deleteSql = "DELETE FROM customer WHERE id = $customer_id";
    if ($conn->query($deleteSql) === TRUE) {
        echo "Customer deleted successfully.";
        header("Location: view_customers.php"); // Redirect to refresh the list
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
    <title>View Customers</title>
</head>
<body>
    <h2>Customer List</h2>

    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Contact No</th>
                    <th>District</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['middle_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['contact_no']; ?></td>
                        <td><?php echo $row['district']; ?></td>
                        <td>
                            <!-- Update Button -->
                            <form action="update_customer.php" method="GET" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit">Update</button>
                            </form>
                            |
                            <!-- Delete Button -->
                            <a href="view_customers.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No customers found.</p>
    <?php endif; ?>
</body>
</html>
