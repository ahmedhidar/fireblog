<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../functions/helper.php';

$conn = connect(); 


function getPosts(mysqli $conn, string $status = 'accepted'): array
{
    $sql = "
        SELECT 
            p.*,
            c.name AS cat_name,
            u.username as author
        FROM posts p
        JOIN users u ON u.id = p.user_id
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.status = ?
        AND u.is_active = 'active'
        ORDER BY p.created_at DESC
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $status);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $posts = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }
    }

    mysqli_stmt_close($stmt);

    return $posts;
}

function getPostById(mysqli $conn, int $id): ?array
{
    $sql = "
        SELECT 
            p.*,
            c.name AS cat_name,
            u.username
        FROM posts p
        JOIN users u ON u.id = p.user_id
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.id = ? AND p.status = 'accepted'
        LIMIT 1
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $post = mysqli_fetch_assoc($result);
    } else {
        $post = null;
    }

    mysqli_stmt_close($stmt);

    return $post;
}


function getPendingComments(mysqli $conn, int $postId): array
{
    $sql = "
        SELECT 
            c.*,
            u.username
        FROM comments c
        JOIN users u ON u.id = c.user_id
        WHERE c.post_id = ? AND c.status = 'pending'
        ORDER BY c.created_at DESC
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $postId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $comments = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $comments[] = $row;
        }
    }

    mysqli_stmt_close($stmt);

    return $comments;
}

function createPost(
    mysqli $conn,
    int $userId,
    string $title,
    string $content,
    ?int $categoryId = null,
    ?string $coverImagePath = null
): bool
{
    $slug = generate_slug($title);
    $sql = "
        INSERT INTO posts (user_id, title, slug, content, category_id, cover_img)
        VALUES (?, ?, ?, ?, ?, ?)
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssis", $userId, $title,$slug, $content, $categoryId, $coverImagePath);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_affected_rows($stmt) > 0;

    mysqli_stmt_close($stmt);

    return $result;
}

function editPost(
    mysqli $conn,
    int $postId,
    string $title,
    string $content,
    ?int $categoryId = null,
    ?string $coverImagePath = null
): bool
{
    $sql = "
        UPDATE posts
        SET title = ?, content = ?, category_id = ?, cover_img = ?
        WHERE id = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssisi", $title, $content, $categoryId, $coverImagePath, $postId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_affected_rows($stmt) > 0;

    mysqli_stmt_close($stmt);

    return $result;
}