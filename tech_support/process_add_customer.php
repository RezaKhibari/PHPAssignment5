<?php
include 'db.php';

$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
$state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
$postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_STRING);
$countryCode = filter_input(INPUT_POST, 'countryCode', FILTER_SANITIZE_STRING);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = password_hash(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);

if ($firstName && $lastName && $email && $password) {
    $query = "INSERT INTO customers (firstName, lastName, address, city, state, postalCode, countryCode, phone, email, password)
              VALUES (:firstName, :lastName, :address, :city, :state, :postalCode, :countryCode, :phone, :email, :password)";
    
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
    $statement->bindValue(':password', $password);
    $statement->execute();
    $statement->closeCursor();

    // Redirect after successful insertion
    header('Location: customer_manager.php');
    exit;
} else {
    echo "Please fill in all required fields.";
}
?>