<?php
session_start();

include_once __DIR__ .'/../../../includes/models/Admin.php';
include_once __DIR__ .'/../../../includes/functions/helper.php';

$conn = connect();

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('sign-in.php');
}

$id = (int)($_POST['id'] ?? 0);
$action = $_GET['action'] ?? '';
$actions = ['activate', 'deactivate', 'delete'];

if($id <= 0) {
    $_SESSION['error_message'] = "Invalid user ID.";
    redirect('users.php');
}

if(in_array($action, $actions)) {
    if(userAction($conn, $id, $action)) {
        $_SESSION['success_message'] = "User {$action}d successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to $action user.";
    }
} else {
    $_SESSION['error_message'] = "Invalid action.";
}

redirect('users.php');
