<?php
require_once __DIR__ . '/../config/Database.php';
function getCommentsByPostId(
    mysqli $conn,
    int $postId,
    string $status = 'accepted'
): array
{
    $sql = "
        SELECT 
            c.*,
            u.username
        FROM comments c
        JOIN users u ON u.id = c.user_id
        WHERE c.post_id = ? AND c.status = ?
        ORDER BY c.created_at ASC
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $postId, $status);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $comments = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $comments;
}


function addComment(
    mysqli $conn,
    int $postId,
    int $userId,
    string $content,
    ?int $parentId = null
): bool
{
    if ($parentId === null) {
        $sql = "
            INSERT INTO comments (post_id, user_id, content)
            VALUES (?, ?, ?)
        ";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $postId, $userId, $content);
    } else {
        $sql = "
            INSERT INTO comments (post_id, user_id, content, parent_id)
            VALUES (?, ?, ?, ?)
        ";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iisi", $postId, $userId, $content, $parentId);
    }

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}
