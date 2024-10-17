<?php
    // Include the database connection
    include('db.php');

    // Get form data
    $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT);
    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $country_id = filter_input(INPUT_POST, 'country_id', FILTER_VALIDATE_INT);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    // Update customer in the database
    $query = 'UPDATE customers
    SET first_name = :first_name, last_name = :last_name,
              country_id = :country_id, phone = :phone, email = :email
    WHERE customer_id = :customer_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':first_name', $first_name);
    $statement->bindValue(':last_name', $last_name);
    $statement->bindValue(':country_id', $country_id);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':customer_id', $customer_id);
    $statement->execute();
    $statement->closeCursor();

    // Redirect to customer list or a confirmation page
    header("Location: customer_list.php");
?>
