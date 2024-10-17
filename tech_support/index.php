<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportsPro Tecnical Support</title>
    <link rel="stylesheet" href="css/style.css">
</head>
</html>

<?php   
    require("db.php");
    $querycCustomers = 'SELECT * FROM customers';
    $statement1 = $db->prepare($querycCustomers);
    $statement1->execute();
    $products = $statement1->fetchAll();
    $statement1->closeCursor();
?>
<?php include 'view/header.php'; ?>
<main>
    <nav>
        
    <h2>Administrators</h2>
    <ul>
        <li><a href="product_manager">Manage Products</a></li>
        <li><a href="under_construction.php">Manage Technicians</a></li>
        <li><a href="add_update_customer.php">Manage Customers</a></li>
        <li><a href="under_construction.php">Create Incident</a></li>
        <li><a href="under_construction.php">Assign Incident</a></li>
        <li><a href="under_construction.php">Display Incidents</a></li>
    </ul>

    <h2>Technicians</h2>    
    <ul>
        <li><a href="under_construction.php">Update Incident</a></li>
    </ul>

    <h2>Customers</h2>
    <ul>
        <li><a href="register_product.php">Register Product</a></li>
    </ul>
    
    </nav>
</section>
<?php include 'view/footer.php'; ?>