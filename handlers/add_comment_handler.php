<?php
session_start();
include_once __DIR__ . '/../includes/config/Database.php';
include_once __DIR__ . '/../includes/functions/helper.php';
include_once __DIR__ . '/../includes/models/Comment.php';
$conn = connect();
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../articles/post.php?id=' . ($_POST['post_id'] ?? ''));
}
$post_id = trim(htmlspecialchars($_POST['post_id']) ?? '');
$user_id = $_SESSION['user_id'] ?? null;
if(!$user_id) {
    $_SESSION['error_message'] = "You must be logged in to add a comment.";
    redirect('../articles/post.php?id=' . $post_id);
}
$parent_id = isset($_POST['parent_id']) && $_POST['parent_id'] !== ''
? (int) $_POST['parent_id']
: null;

$content = trim(htmlspecialchars($_POST['content']) ?? '');
if(empty($content)) {
    $_SESSION['error_message'] = "Comment content cannot be empty.";
    redirect('../articles/post.php?id=' . $post_id);
}
addComment($conn, $post_id, $user_id, $content, $parent_id ?? null);
redirect('../articles/post.php?id=' . $post_id);



