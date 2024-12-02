<?php include('includes/header.php'); ?>
<div class="container mt-5">
    <h1>Welcome to ERP System</h1>

    <div class="button-container">
        <a href="customers/view_customers.php" class="button">Customer Management System</a>
        <a href="customers/register_customer.php" class="button">Register a Customer</a>
        <a href="items/view_items.php" class="button">Item Management</a>
    </div>

    <div class="button-container">
        <a href="reports/invoice_report.php" class="button">a. Invoice report</a>
        <a href="reports/invoice_item_report.php" class="button">b. Invoice item report</a>
        <a href="reports/item_report.php" class="button">c. Item report</a>
    </div>

</div>
<?php include('includes/footer.php'); ?>
