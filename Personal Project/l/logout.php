<?php
session_start();

// Destroy session
session_unset();
session_destroy();

// Remove remember me cookie
if (isset($_COOKIE['remember_user'])) {
    setcookie('remember_user', '', time() - 3600, '/');
}

// Redirect to login page
header('Location: ../login.html?success=logged_out');
exit;
?>
