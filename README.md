# ERP System Project (PHP & MySQL)

## Project Overview
This ERP system is designed using PHP and MySQL to manage customers, items, and generate reports. The project incorporates form validation and a user-friendly interface created with Bootstrap, CSS, and JavaScript. 

### Features
1. **Customer Management**
   - Register and store customer details.
   - View a list of registered customers.
   - Update and delete customers.
   - Search customers

2. **Item Management**
   - Register and store item details.
   - View a list of registered items.
   - Update and delete items.
   - Search items    

3. **Reporting**
   - Invoice Report
     - Filter by a date range.
     - Display: Invoice Number, Date, Customer Name, Customer District, Item Count, Invoice Amount.
   - Invoice Item Report
     - Filter by a date range.
     - Display: Invoice Number, Invoiced Date, Customer Name, Item Name (with Item Code), Item Category, Item Unit Price.
   - Item Report
     - Display: Item Name (no repetition), Item Category, Item Subcategory, Item Quantity.

---

## Assumptions
1. **User Authentication**: Assumes basic access control is already implemented.
2. **Database Structure**: The provided SQL dump file contains the required schema and initial data for all tables.
3. **Server Configuration**: Assumes a local development environment with PHP 7.4+ and MySQL installed.
4. **Validation**: Input validation is done both client-side (JavaScript) and server-side (PHP).

---

## Setup Instructions
Follow these steps to set up the project on your local environment:

### Prerequisites
- A web server (e.g., XAMPP, WAMP, or MAMP).
- PHP 7.4 or higher.
- MySQL 5.7 or higher.
- A text editor or IDE (e.g., VS Code, PHPStorm).

### Steps

1. **Clone the Repository**:
   ```bash
   git clone <repository_url>
   cd erp-system
   ```
2.**Import the Database:**

- Open your MySQL database manager (e.g., phpMyAdmin).
- Create a new database named erp_system.
- Import the SQL dump file provided (db.sql) into the erp_system database.

3.**Update Configuration:**

- Navigate to includes/db.php.
- Update the database credentials
   ```bash
   $servername = "localhost";
   $username = "root";
   $password = ""; // Update if using a custom password
   $dbname = "erp_system";
   ```

4. **Start the Server:**

- Launch your server (e.g., start XAMPP or WAMP).
- Place the project folder in the `htdocs` directory (for XAMPP) or equivalent for your setup.

5. **Access the Application:**

- Open a browser
- Navigate to : [http://localhost/erp-system](http://localhost/erp-system).

6. **Verify Functionality:**

- Test customer and item forms for proper validation and functionality.
Generate reports by selecting date ranges.

