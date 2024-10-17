<?php
    // Include the database connection
    require_once('db.php');

    // Check if a customer ID is provided in the URL
    $customerID = filter_input(INPUT_GET, 'customerID', FILTER_VALIDATE_INT);
    $customerID = 1010;
    if (!$customerID) {
        echo "Invalid customer ID.";
        exit;
    }

    // Fetch the customer
    $query = "SELECT * FROM customers WHERE customerID = :customerID";
    $statement = $db->prepare($query);
    $statement->bindValue(':customerID', $customerID);
    $statement->execute();
    $customer = $statement->fetch();
    $statement->closeCursor();

    // Check if customer data was fetched
    if (!$customer) {
        echo "Customer not found.";
        exit;
    }

    // Fetch the list of countries
    $query = "SELECT countryCode, countryName FROM countries";
    $statement = $db->prepare($query);
    $statement->execute();
    $countries = $statement->fetchAll();
    $statement->closeCursor();

    // If form is submitted, update the customer's country
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the submitted data
        $new_countryCode = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);  // Changed to string
        $new_phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $new_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        // Update customer in the database
        if ($new_countryCode && $new_phone && $new_email) {
            $query = "UPDATE customers
                      SET countryCode = :countryCode, phone = :phone, email = :email
                      WHERE customerID = :customerID";
            $statement = $db->prepare($query);
            $statement->bindValue(':customerID', $customerID);
            $statement->bindValue(':countryCode', $new_countryCode); // Country code is a string now
            $statement->bindValue(':phone', $new_phone);
            $statement->bindValue(':email', $new_email);
            $statement->execute();
            $statement->closeCursor();

            // Display success message
            echo "Customer updated successfully!";

            // Refresh the customer data after update
            $query = "SELECT * FROM customers WHERE customerID = :customerID";
            $statement = $db->prepare($query);
            $statement->bindValue(':customerID', $customerID);
            $statement->execute();
            $customer = $statement->fetch();
            $statement->closeCursor();
        } else {
            echo "Please fill in all fields.";
        }
    }
?>

<!-- HTML Form for Updating Customer Information -->
<form action="" method="POST">
    <label>First Name:</label>
    <input type="text" name="firstName" value="<?php echo htmlspecialchars($customer['firstName']); ?>" disabled><br>

    <label>Last Name:</label>
    <input type="text" name="lastName" value="<?php echo htmlspecialchars($customer['lastName']); ?>" disabled><br>

    <!-- Country Drop-Down List -->
    <label>Country:</label>
    <select name="country">
        <?php foreach ($countries as $country) : ?>
            <option value="<?php echo $country['countryCode']; ?>" 
                <?php if ($country['countryCode'] == $customer['countryCode']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($country['countryName']); ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>"><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>"><br>

    <input type="submit" value="Update Customer">
</form>

<a href="index.php">Back to Main Screen</a>
