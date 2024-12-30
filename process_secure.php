<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $dsn = "mysql:host=localhost;dbname=secure_app";
    $username_db = "root";
    $password_db = "";
    
    try {
        $pdo = new PDO($dsn, $username_db, $password_db);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }

    // Sanitize inputs
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_ARGON2ID);

    // Store user data securely
    try {
        $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
        $stmt->execute(['username' => $username, 'password' => $hashed_password]);
        echo "User registered successfully!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
