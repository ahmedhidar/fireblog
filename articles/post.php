<?php
require_once __DIR__ . '/../includes/functions/helper.php';
require_once __DIR__ . '/../includes/config/Database.php';
$conn = connect();
/**
 * Render comments recursively using TREE structure
 */
require_once __DIR__ . '/../includes/layout/header.php';
require_once __DIR__ . '/../includes/models/Post.php';
require_once __DIR__ . '/../includes/models/Admin.php';
require_once __DIR__ . '/../includes/models/Comment.php';
require_once __DIR__ . '/../includes/functions/helper.php';


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "Invalid post ID.";
    redirect('index.php');
}
if(isAdmin()) {
    $post = getPostByIdForAdmin($conn, (int)$_GET['id']);
} else
$post = getPostById($conn, (int)$_GET['id']);

$comments = getCommentsByPostId($conn, $post['id']);


if (!$post) {
    $_SESSION['error_message'] = "Post not found or not accepted.";
    redirect('index.php');
}
if(!$comments) {
    $comments = [];
}
include __DIR__ . '/post_view.php';
include __DIR__ . '/comments_view.php';

?>


<?php include __DIR__ . '/../includes/layout/footer.php'; ?>