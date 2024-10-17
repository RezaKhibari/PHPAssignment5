<?php
include 'db.php';

if (isset($_POST['lastName'])) {
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);

    $query = "SELECT * FROM customers WHERE lastName LIKE :lastName";
    $statement = $db->prepare($query);
    $statement->bindValue(':lastName', '%' . $lastName . '%');
    $statement->execute();
    $customers = $statement->fetchAll();
    $statement->closeCursor();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Search</title>
</head>
<body>
    <h2>Customer Search Results</h2>
    <?php if (!empty($customers)) : ?>
        <ul>
            <?php foreach ($customers as $customer) : ?>
                <li><?php echo htmlspecialchars($customer['firstName']) . ' ' . htmlspecialchars($customer['lastName']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>No customers found with that last name.</p>
    <?php endif; ?>
    <a href="customer_manager.php">Back to Customer Manager</a>
</body>
</html>