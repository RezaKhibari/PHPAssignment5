<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportsPro Tecnical Support</title>
    <link rel="stylesheet" href="css/add_update.css">
</head>
</html>

<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>
</head>
<body>
    <h2>Add Customer</h2>
    <form action="process_add_customer.php" method="POST">
        <label>First Name:</label>
        <input type="text" name="firstName" required><br>

        <label>Last Name:</label>
        <input type="text" name="lastName" required><br>

        <label>Address:</label>
        <input type="text" name="address"><br>

        <label>City:</label>
        <input type="text" name="city"><br>

        <label>State:</label>
        <input type="text" name="state"><br>

        <label>Postal Code:</label>
        <input type="text" name="postalCode"><br>

        <label>Country Code:</label>
        <input type="text" name="countryCode" value="US"><br>

        <label>Phone:</label>
        <input type="text" name="phone"><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Add Customer">
    </form>
    <a href="customer_manager.php">Back to Customer Manager</a>
</body>
</html>