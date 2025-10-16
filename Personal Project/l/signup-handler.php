<?php
session_start();

// Database configuration
$db_host = 'localhost';
$db_name = 'code_gallery';
$db_user = 'root';
$db_pass = '';

// Create connection
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        header('Location: ../signup.html?error=empty_fields');
        exit;
    }

    if ($password !== $confirm_password) {
        header('Location: ../signup.html?error=password_mismatch');
        exit;
    }

    if (strlen($password) < 8) {
        header('Location: ../signup.html?error=password_short');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../signup.html?error=invalid_email');
        exit;
    }

    // Check if username exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        header('Location: ../signup.html?error=username_exists');
        exit;
    }

    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        header('Location: ../signup.html?error=email_exists');
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$username, $email, $hashed_password]);

        // Registration successful
        header('Location: ../login.html?success=registered');
        exit;
    } catch(PDOException $e) {
        header('Location: ../signup.html?error=registration_failed');
        exit;
    }
} else {
    header('Location: ../signup.html');
    exit;
}
?>
