<?php
include('db.php');

// Sanitize input
$product_code = filter_input(INPUT_POST, 'product_code', FILTER_SANITIZE_STRING);
$product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
$version = filter_input(INPUT_POST, 'version', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$release_date = filter_input(INPUT_POST, 'release_date', FILTER_SANITIZE_STRING);

// Validate input
if (!$product_code || !$product_name || !$version || !$release_date) {
    // Redirect to the error page
    header('Location: error.php?error=missing_fields');
    exit();
}

// Insert into the database
$query = 'INSERT INTO products (product_code, product_name, version, release_date)
          VALUES (:product_code, :product_name, :version, :release_date)';
$statement = $db->prepare($query);
$statement->bindValue(':product_code', $product_code);
$statement->bindValue(':product_name', $product_name);
$statement->bindValue(':version', $version);
$statement->bindValue(':release_date', $release_date);
$statement->execute();
$statement->closeCursor();

// Redirect back to the product list
header('Location: index.php');
exit();
?>
