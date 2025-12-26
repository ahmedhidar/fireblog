<?php

include_once __DIR__ .'/../../../includes/models/Admin.php';
include_once __DIR__ .'/../../../includes/models/Post.php';

$post_id = intval($_GET['post_id'] ?? 0);
$action = $_GET['action'] ?? '';

$conn = connect();

acceptOrRejectPost($conn, $post_id, $action);
header('Location: posts.php?status=success');

?>