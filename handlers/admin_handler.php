<?php
session_start();
require_once __DIR__ . '/../includes/models/Admin.php';
include_once __DIR__ . '/../includes/config/Database.php';
$conn = connect();

// $adminModel = new Admin();
// $registEmail = 'admin@admin.com';
// $registPassword = password_hash('admin123', PASSWORD_BCRYPT);
// $adminModel->register('Admin', $registEmail, $registPassword);

// $registName = 'Admin';
// $registEmail = 'admin@admin.com';
// $adminModel = new Admin();
// $registPassword = password_hash('admin123', PASSWORD_BCRYPT);
// $adminModel->register($registEmail, $registName, $registPassword);



$email    = trim(htmlspecialchars($_POST['email'] ?? ''));
$password = trim(htmlspecialchars($_POST['password'] ?? ''));


if(empty($email) || empty($password)) {
    $_SESSION['error_message'] = 'Please fill in all fields.';
    header('Location: ../admin/build/pages/sign-in.php?error=emptyfields');
    exit();
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error_message'] = 'Invalid email format.';
    header('Location: ../admin/build/pages/sign-in.php?error=invalidemail');
    exit();
}


if(!$admin = adminLogin($conn, $email, $password)) {
    header('Location: ../admin/build/pages/sign-in.php?error=invalidcredentials');
    $_SESSION['error_message'] = 'Invalid email or password.';
    exit();
}else {
    header('Location: ../admin/build/pages/dashboard.php?login=success');
    $_SESSION['success_message'] = 'Login successful. Welcome back!';
    exit();
}

