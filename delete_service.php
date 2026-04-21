<?php
session_start();
require_once 'classes/Service.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

$service = new Service();
$service->delete($id);

// Redirect back to dashboard
header('Location: dashboard.php');
exit;
?>
