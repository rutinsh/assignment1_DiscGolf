<?php
session_start();

// Destroy session
session_destroy();

// Delete cookies
setcookie('username', '', time() - 3600, '/');
setcookie('last_visit', '', time() - 3600, '/');

// Redirect to home
header('Location: index.php');
exit;
?>
