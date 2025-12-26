<?php
session_start();
include_once __DIR__ . '/../includes/config/Database.php';
include_once __DIR__ . '/../includes/functions/helper.php';
include_once __DIR__ . '/../includes/models/User.php';
$conn = connect();



if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../auth/register.php');
}
$username = trim(htmlspecialchars($_POST['username']) ?? '');
$email = trim(htmlspecialchars($_POST['email']) ?? '');
$password = trim(htmlspecialchars($_POST['password']) ?? '');

if(empty($username)||!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
    $_SESSION['error_message'] = "Invalid username. It should be 3-20 characters long and can contain letters, numbers, and underscores.";
    redirect('../auth/register.php');
}

if(empty($email)||!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error_message'] = "Invalid email address.";
    redirect('../auth/register.php');
}
if(empty($password)||strlen($password)<6) {
    $_SESSION['error_message'] = "Password must be at least 6 characters long.";
    redirect('../auth/register.php');
}
$avatar = $_FILES['avatar'] ?? null;
if ($avatar && $avatar['error'] === UPLOAD_ERR_OK) {
    
$info = getimagesize($avatar['tmp_name']);
    if ($info === false) {
        $_SESSION['error_message'] = "Uploaded file is not a valid image.";
        header('Location: ../auth/register.php');
        exit;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $avatar['tmp_name']);
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($mimeType, $allowedMimeTypes)) {
        $_SESSION['error_message'] = "Only JPG, PNG, and GIF images are allowed.";
        header('Location: ../auth/register.php');
        exit;
    }
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

    $ext = strtolower(pathinfo($avatar['name'], PATHINFO_EXTENSION));

if (in_array(strtolower($ext), $allowedExt)) {
        $uploadDir = __DIR__ . "/../uploads/avatars/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
}
    $avatarName = uniqid('avatar_', true) . '.' . $ext;

    
    $avatarPath = "uploads/avatars/" . $avatarName;

    
    move_uploaded_file(
        $_FILES['avatar']['tmp_name'],
        $uploadDir . $avatarName
    );
}


if(createUser($conn, $username, $email , $avatarPath?? null, $password)) {
    $_SESSION['success_message']= "Registration successful! You can now log in.";
    redirect('../auth/login.php');
}else{
    $_SESSION['error_message']= "Registration failed. Please try again.";
    redirect('../auth/register.php');
}




