<?php
include('db.php');

$product_code = filter_input(INPUT_POST, 'product_code', FILTER_SANITIZE_STRING);

if ($product_code != false) {
    $query = 'DELETE FROM products WHERE product_code = :product_code';
    $statement = $db->prepare($query);
    $statement->bindValue(':product_code', $product_code);
    $statement->execute();
    $statement->closeCursor();
}

header('Location: index.php');
?>
