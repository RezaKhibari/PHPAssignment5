<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>SportsPro Technical Support</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: 0 auto; }
        h1 { text-align: center; }
        form { margin-top: 20px; }
        label { margin-right: 10px; }
        input[type="text"], input[type="submit"] { padding: 5px; }
        input[type="submit"] { background-color: #007BFF; color: white; border: none; }
        .footer { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>SportsPro Technical Support</h1>
        <p>Sports management software for the sports enthusiast</p>

        <a href="home.php">Home</a>

        <h2>Customer Search</h2>
        <form action="search_customer.php" method="POST">
            <label>Last Name:</label>
            <input type="text" name="lastName">
            <input type="submit" value="Search">
        </form>

        <h2>Add a new customer</h2>
        <form action="add_customer.php" method="POST">
            <input type="submit" value="Add Customer">
        </form>
    </div>

    <div class="footer">
        <p>© 2022 SportsPro, Inc.</p>
    </div>
</body>
</html>