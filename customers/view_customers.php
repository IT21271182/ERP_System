<?php
include('../includes/db.php');

// Handle search
$searchQuery = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    // Join the customer table with the district table to get the district name
    $sql = "SELECT customer.*, district.district AS district_name
            FROM customer
            LEFT JOIN district ON customer.district = district.id
            WHERE customer.first_name LIKE '%$searchQuery%' 
            OR customer.last_name LIKE '%$searchQuery%' 
            OR customer.contact_no LIKE '%$searchQuery%' 
            OR district.district LIKE '%$searchQuery%'";
} else {
    // Default query to fetch all customers and join with the district table
    $sql = "SELECT customer.*, district.district AS district_name
            FROM customer
            LEFT JOIN district ON customer.district = district.id";
}

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

    <!-- Search Form -->
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search by name, contact, or district" value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit">Search</button>
        <a href="view_customers.php">Clear</a> <!-- Clear the search -->
    </form>

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
                        <td><?php echo $row['district_name']; ?></td> <!-- Display the district name -->
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
