<!DOCTYPE html>
<html>

<head>
    <title>ERP System</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .navbar {
        background-color: #007bff;
    }

    .navbar .navbar-brand,
    .navbar .nav-link {
        color: #fff !important;
    }

    .dropdown-menu {
        background-color: #007bff;
    }

    .dropdown-menu .dropdown-item {
        color: #fff !important;
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #0056b3;
    }

    /* Custom spacing between navbar items */
    .navbar-nav .nav-item {
        margin-right: 20px;
    }

    .navbar-nav .nav-item:last-child {
        margin-right: 50px;
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../erp-system/index.php">ERP System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="../../erp-system/index.php">Home</a>
                    </li>

                    <!-- Dropdown Menu 1 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="dropdownMenu1" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Customers
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a class="dropdown-item" href="../../erp-system/customers/view_customers.php">View
                                    Customers</a></li>
                            <li><a class="dropdown-item" href="../../erp-system/customers/register_customer.php">Add New
                                    Customer</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Menu 2 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="dropdownMenu1" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Items
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a class="dropdown-item" href="../../erp-system/items/view_items.php">View Items</a>
                            </li>
                            <li><a class="dropdown-item" href="../../erp-system/items/add_item.php">Add New Items</a>
                            </li>
                        </ul>
                    </li>


                    <!-- Dropdown Menu 3 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="dropdownMenu2" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Reports
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li><a class="dropdown-item" href="../../erp-system/reports/invoice_report.php">Invoices</a>
                            </li>
                            <li><a class="dropdown-item" href="../../erp-system/reports/invoice_item_report.php">Invoice
                                    Item</a></li>
                            <li><a class="dropdown-item" href="../../erp-system/reports/item_report.php">Items</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Include Bootstrap JS and its dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>