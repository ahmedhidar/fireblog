<?php
session_start();
include_once __DIR__ . '/../includes/functions/helper.php';
include_once __DIR__ . '/../includes/models/User.php';
include_once __DIR__ . '/../includes/config/Database.php';
$conn = connect();

if($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    redirect('../auth/login.php');
}
$email = trim(htmlspecialchars($_POST['email']) ?? '');
$password = trim(htmlspecialchars($_POST['password']) ?? '');

IF(empty($email)||!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error_message'] = "Invalid email address.";
    redirect('../auth/login.php');
}
if(empty($password)) {
    $_SESSION['error_message'] = "Password cannot be empty.";
    redirect('../auth/login.php');
}
$loggedInUser = loginUser($conn, $email , $password);
if($loggedInUser) {
    $_SESSION['user_id'] = $loggedInUser['id'];
    $_SESSION['username'] = $loggedInUser['username'];
    $_SESSION['success_message']= "Login successful! , " . $loggedInUser['username'] . ".";
    redirect('../index.php');}else{
    $_SESSION['error_message']= "invalid credentialsss.";
    redirect('../auth/login.php');}