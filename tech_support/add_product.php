<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <h1>Add Product</h1>
    <form action="add_product_action.php" method="post">
        <label>Code:</label>
        <input type="text" name="product_code" required><br>

        <label>Name:</label>
        <input type="text" name="product_name" required><br>

        <label>Version:</label>
        <input type="text" name="version" required><br>

        <label>Release Date:</label>
        <input type="date" name="release_date" required><br>

        <input type="submit" value="Add Product">
    </form>

    <a href="index.php">View Product List</a>
</body>
</html>

