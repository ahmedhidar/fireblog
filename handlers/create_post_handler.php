<?php
session_start();

include_once __DIR__ . '/../includes/models/Post.php';
include_once __DIR__ . '/../includes/config/Database.php';
$conn = connect();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../articles/create_post.php');
    exit;
}
$title = trim(htmlspecialchars($_POST['title'] ?? ''));
$content = trim(htmlspecialchars($_POST['content'] ?? ''));
$category_id = (int) ($_POST['category_id'] ?? 0);
if (empty($title) || empty($content) || $category_id <= 0) {
    $_SESSION['error_message'] = "All fields are required and must be valid.";
    header('Location: ../articles/create_post.php');
    exit;
}

$coverImagePath = null;
if(!isset($_FILES['cover_img'])) {
    $_SESSION['error_message'] = "Cover image is required.";
    header('Location: ../articles/create_post.php');
    exit;
}
$cover_img = $_FILES['cover_img'] ?? null;
if ($cover_img && $cover_img['error'] === UPLOAD_ERR_OK) {
    $info = getimagesize($cover_img['tmp_name']);
    if ($info === false) {
        $_SESSION['error_message'] = "Uploaded file is not a valid image.";
        header('Location: ../articles/create_post.php');
        exit;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $cover_img['tmp_name']);
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($mimeType, $allowedMimeTypes)) {
        $_SESSION['error_message'] = "Only JPG, PNG, and GIF images are allowed.";
        header('Location: ../articles/create_post.php');
        exit;
    }
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExt = pathinfo($cover_img['name'], PATHINFO_EXTENSION);
    if (in_array(strtolower($fileExt), $allowedExt)) {
        $uploadDir = __DIR__ . '/../uploads/covers/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $newFileName = uniqid('cover_', true) . '.' . $fileExt;
        $destination = $uploadDir . $newFileName;
        if (move_uploaded_file($cover_img['tmp_name'], $destination)) {
            $coverImagePath = 'uploads/covers/' . $newFileName;
        }
    }
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    $_SESSION['error_message'] = "You must be logged in to create a post.";
    header('Location: ../articles/create_post.php');
    exit;
}
if($_POST['action'] === 'edit' && !empty($_POST['post_id'])) {
    $post_id = (int)$_POST['post_id'];
    if(editPost($conn, $post_id, $title, $content, $category_id,  $coverImagePath !== null ? $coverImagePath : $_POST['img_path'])) {
        $_SESSION['success_message'] = "Post updated successfully.";
        header('Location: ../articles/post.php?id=' . $post_id);
        exit;
    } else {
        $_SESSION['error_message'] = "Failed to update post. Please try again.";
        header('Location: ../articles/create_post.php?id=' . $post_id . '&action=edit');
        exit;
    }
}
elseif($_POST['action']=='create'&&createPost($conn, $user_id, $title, $content, $category_id, $coverImagePath)){
 {
    $_SESSION['success_message'] = "Post created successfully and is pending approval.";
    header('Location: ../index.php');
    exit;
}} else {
    $_SESSION['error_message'] = "Failed to create post. Please try again.";
    header('Location: ../articles/create_post.php');
    exit;
}
