<?php
    session_start();
    require_once 'db.php';  // Include your database connection

    // If the user is already logged in, skip the login page
    if (isset($_SESSION['customer'])) {
        header("Location: register_product.php");
        exit;
    }

    // Handle login
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        // Fetch the user from the administrators table
        $query = "SELECT * FROM administrators WHERE username = :username";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $admin = $statement->fetch();
        $statement->closeCursor();

        // Verify password
        if ($admin && password_verify($password, $admin['password'])) {
            // Store customer data in session
            $_SESSION['customer'] = [
                'username' => $admin['username']
            ];
            header("Location: register_product.php");
            exit;
        } else {
            $error_message = "Invalid username or password.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error_message)) : ?>
        <p><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
    <form action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form>
</body>
</html>