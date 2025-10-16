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
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Validate input
    if (empty($username) || empty($password)) {
        header('Location: ../login.html?error=empty_fields');
        exit;
    }

    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        // Set remember me cookie if checked
        if ($remember) {
            setcookie('remember_user', $user['id'], time() + (86400 * 30), '/'); // 30 days
        }

        header('Location: ../dashboard.html');
        exit;
    } else {
        // Login failed
        header('Location: ../login.html?error=invalid_credentials');
        exit;
    }
} else {
    header('Location: ../login.html');
    exit;
}
?>
