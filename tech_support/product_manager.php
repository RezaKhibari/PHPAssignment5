<?php
    require("db.php");
    $query = 'SELECT * FROM products';
    $statement = $db->prepare($query);
    $statement->execute();
    $products = $statement->fetchAll();
    $statement->closeCursor();
?>

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'under_construction';
    }
}

if ($action == 'under_construction') {
    include('../under_construction.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Manager</title>
</head>
<body>
    <h1>Product List</h1>
    <table border="1">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Version</th>
            <th>Release Date</th>
            <th>Action</th>
        </tr>
        <?php foreach ($products as $product) : ?>
        <tr>
            <td><?php echo $product['product_code']; ?></td>
            <td><?php echo $product['product_name']; ?></td>
            <td><?php echo $product['version']; ?></td>
            <td><?php echo $product['release_date']; ?></td>
            <td>
                <form action="delete_product.php" method="post">
                    <input type="hidden" name="product_code" value="<?php echo $product['product_code']; ?>">
                    <input type="submit" value="Delete">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="add_product.php">Add Product</a> | 
    <a href="home.php">Home</a>
</body>
</html>