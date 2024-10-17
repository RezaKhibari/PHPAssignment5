<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportsPro Tecnical Support</title>
    <link rel="stylesheet" href="css/add_update.css">
</head>
</html>

<?php
    // Include the database connection
    require_once('db.php');

    // Initialize variables
    $customerID = null;
    $firstName = '';
    $lastName = '';
    $address = '';
    $city = '';
    $state = '';
    $postalCode = '';
    $countryCode = 'US'; // Default to United States
    $phone = '';
    $email = '';
    $password = '';
    $buttonText = 'Add Customer'; // Default to adding a customer

    // If a customerID is provided, it's an update operation
    if (isset($_GET['customerID']) && filter_input(INPUT_GET, 'customerID', FILTER_VALIDATE_INT)) {
        $customerID = filter_input(INPUT_GET, 'customerID', FILTER_VALIDATE_INT);

        // Fetch customer data
        $query = "SELECT * FROM customers WHERE customerID = :customerID";
        $statement = $db->prepare($query);
        $statement->bindValue(':customerID', $customerID);
        $statement->execute();
        $customer = $statement->fetch();
        $statement->closeCursor();

        // Prepopulate form fields with customer data if customer exists
        if ($customer) {
            $firstName = $customer['firstName'];
            $lastName = $customer['lastName'];
            $address = $customer['address'];
            $city = $customer['city'];
            $state = $customer['state'];
            $postalCode = $customer['postalCode'];
            $countryCode = $customer['countryCode'];
            $phone = $customer['phone'];
            $email = $customer['email'];
            $password = $customer['password']; // Note: Store hashed passwords in production
            $buttonText = 'Update Customer'; // Change button text to Update
        }
    }

    // If the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get data from the form
        $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
        $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
        $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
        $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
        $postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_STRING);
        $countryCode = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        // Validate required fields (you can add more validation as needed)
        if ($firstName && $lastName && $email && $phone) {
            // If customerID exists, update the customer, otherwise add a new one
            if ($customerID) {
                // Update customer query
                $query = "UPDATE customers 
                          SET firstName = :firstName, lastName = :lastName, address = :address, 
                              city = :city, state = :state, postalCode = :postalCode, 
                              countryCode = :countryCode, phone = :phone, email = :email, password = :password
                          WHERE customerID = :customerID";
            } else {
                // Insert new customer query
                $query = "INSERT INTO customers (firstName, lastName, address, city, state, postalCode, countryCode, phone, email, password)
                          VALUES (:firstName, :lastName, :address, :city, :state, :postalCode, :countryCode, :phone, :email, :password)";
            }

            // Prepare and execute the query
            $statement = $db->prepare($query);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':lastName', $lastName);
            $statement->bindValue(':address', $address);
            $statement->bindValue(':city', $city);
            $statement->bindValue(':state', $state);
            $statement->bindValue(':postalCode', $postalCode);
            $statement->bindValue(':countryCode', $countryCode);
            $statement->bindValue(':phone', $phone);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT)); // Hash the password
            if ($customerID) {
                $statement->bindValue(':customerID', $customerID);
            }
            $statement->execute();
            $statement->closeCursor();

            // Redirect to the customer list or confirmation page after saving
            header('Location: customer_manager.php');
            exit;
        } else {
            echo 'Please fill in all required fields.';
        }
    }
?>

<!-- HTML Form for Add/Update Customer -->
<form action="" method="POST">
    <label>First Name:</label>
    <input type="text" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>"><br>

    <label>Last Name:</label>
    <input type="text" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>"><br>

    <label>Address:</label>
    <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>"><br>

    <label>City:</label>
    <input type="text" name="city" value="<?php echo htmlspecialchars($city); ?>"><br>

    <label>State:</label>
    <input type="text" name="state" value="<?php echo htmlspecialchars($state); ?>"><br>

    <label>Postal Code:</label>
    <input type="text" name="postalCode" value="<?php echo htmlspecialchars($postalCode); ?>"><br>

    <label>Country:</label>
    <select name="country">
        <option value="US" <?php if ($countryCode == 'US') echo 'selected'; ?>>United States</option>
        <option value="CA" <?php if ($countryCode == 'CA') echo 'selected'; ?>>Canada</option>
        <option value="UK" <?php if ($countryCode == 'UK') echo 'selected'; ?>>United Kingdom</option>
        <!-- Add more countries as needed -->
    </select><br>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>"><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><br>

    <label>Password:</label>
    <input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>"><br>

    <input type="submit" value="<?php echo $buttonText; ?>">
</form>

<a href="index.php">Back to Main Screen</a>