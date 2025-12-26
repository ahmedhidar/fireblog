<?php
require_once __DIR__ . '/../../../includes/models/Admin.php';
require_once __DIR__ . '/../../../includes/config/Database.php';
require_once __DIR__ . '/../../../includes/functions/helper.php';

$id = $_GET['id'] ?? 0;
$post_id = $_GET['post_id'] ?? 0;
$conn = connect();
if(!isAdmin()) {
    $_SESSION['error_message'] = "Unauthorized access.";
    redirect('../../../index.php');
}
deleteComment($conn, (int)$id);
redirect('./pending_comments.php?post_id=' . $post_id);