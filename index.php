<?php include('includes/header.php'); ?>
<style>
html,
body {
    height: 100%;
    margin: 0;
    overflow: hidden;
}

.section {
    border-radius: 15px;
    padding: 30px;
    background-color: rgba(0, 123, 255, 0.1);
}

.btn {
    border-radius: 50px;
}

.fullscreen-bg {
    height: 100%;
    background-image: url('asserts/images/ERP2.jpg');
    background-size: cover;
    background-position: center;
    position: relative;
}

.overlay {
    background-color: rgba(0, 0, 0, 0.6);
    height: 100%;
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 0;
}

.content-wrapper {
    position: relative;
    z-index: 1;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
    text-align: center;
}

.section {
    margin-bottom: 20px;
}

.btn {
    margin-bottom: 10px;
}

.row {
    display: flex;
    justify-content: center;
    width: 100%;
}

.customer-col {
    width: 35%; /* Customers section width */
    margin-right: 2%;
}

.item-col {
    width: 30%; /* Items section width */
    margin-right: 2%;
}

.report-col {
    width: 35%; /* Reports section width */
}
</style>

<div class="container-fluid p-0" style="height: 100%; overflow: hidden;">
    <div class="fullscreen-bg">
        <div class="overlay"></div>

        <!-- Main Content -->
        <div class="content-wrapper">
            <h1 class="mb-4">Welcome to ERP System</h1>

            <!-- Section 1 (Customer & Item Management) -->
            <div class="row mb-2 mt-2">
                <!-- Section 1.1 - Customers -->
                <div class="customer-col">
                    <div class="section">
                        <h3 class="mb-3">Customers</h3>
                        <a href="customers/view_customers.php" class="btn btn-primary btn-lg me-3 mb-3">View Customers</a>
                        <a href="customers/register_customer.php" class="btn btn-primary btn-lg me-3 mb-3">Register Customer</a>
                    </div>
                </div>

                <!-- Section 1.2 - Items -->
                <div class="item-col">
                    <div class="section">
                        <h3 class="mb-3">Items</h3>
                        <a href="items/view_items.php" class="btn btn-primary btn-lg me-3 mb-3">View All Items</a>
                        <a href="items/add_item.php" class="btn btn-primary btn-lg me-3 mb-3">Add New Item</a>
                    </div>
                </div>

                <!-- Section 2 (Reports) -->
                <div class="report-col">
                    <div class="section">
                        <h3 class="mb-3">Reports</h3>
                        <a href="reports/invoice_report.php" class="btn btn-primary btn-lg me-3 mb-3">Invoices</a>
                        <a href="reports/invoice_item_report.php" class="btn btn-primary btn-lg me-3 mb-3">Invoice Items</a>
                        <a href="reports/item_report.php" class="btn btn-primary btn-lg mb-3">Items</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
