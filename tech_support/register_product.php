<?php
    session_start();
    require_once 'db.php';  // Include your database connection

    // If the user is not logged in, redirect to the login page
    if (!isset($_SESSION['customer'])) {
        header("Location: login.php");
        exit;
    }

    // Fetch list of available products from the products table
    $query = "SELECT productCode, name, version, releaseDate FROM products";
    $statement = $db->prepare($query);
    $statement->execute();
    $products = $statement->fetchAll();
    $statement->closeCursor();

    // If the user registers a product
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productCode = filter_input(INPUT_POST, 'productCode', FILTER_SANITIZE_STRING);

        if ($productCode) {
            // Insert the registration into the registrations table
            $customerID = 1234;  // Example customer ID; in a real application, fetch from session
            $registrationDate = date('Y-m-d');

            $query = "INSERT INTO registrations (customerID, productCode, registrationDate) 
                      VALUES (:customerID, :productCode, :registrationDate)";
            $statement = $db->prepare($query);
            $statement->bindValue(':customerID', $customerID);
            $statement->bindValue(':productCode', $productCode);
            $statement->bindValue(':registrationDate', $registrationDate);
            $statement->execute();
            $statement->closeCursor();

            // Show a success message
            $success_message = "Product registered successfully!";
        } else {
            $error_message = "Please select a product to register.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Product</title>
</head>
<body>
    <h1>Register Product</h1>
    
    <!-- Display success or error message -->
    <?php if (isset($success_message)) : ?>
        <p><?php echo htmlspecialchars($success_message); ?></p>
    <?php endif; ?>
    
    <?php if (isset($error_message)) : ?>
        <p><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <p>Customer: <?php echo htmlspecialchars($_SESSION['customer']['username']); ?></p>
    
    <!-- Product Registration Form -->
    <form action="" method="post">
        <label>Product:</label>
        <select name="productCode">
            <option value="">Select a product</option>
            <?php foreach ($products as $product) : ?>
                <option value="<?php echo htmlspecialchars($product['productCode']); ?>">
                    <?php echo htmlspecialchars($product['name']) . " (v" . htmlspecialchars($product['version']) . ", Released on " . htmlspecialchars($product['releaseDate']) . ")"; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <input type="submit" value="Register Product">
    </form>

    <p>You are logged in as <?php echo htmlspecialchars($_SESSION['customer']['username']); ?></p>
    
    <!-- Logout button -->
    <form action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form>
</body>
</html>