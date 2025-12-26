<?php
// session_start();
require_once __DIR__ . '/../config/Database.php';

/**
 * Admin Login
 */
function adminLogin(mysqli $conn, string $email, string $password)
{
    $sql = "SELECT * FROM admins WHERE email = ? LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) !== 1) {
        mysqli_stmt_close($stmt);
        return false;
    }

    $admin = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        return $admin;
    }

    return false;
}

/**
 * Admin Register
 */
function adminRegister(mysqli $conn, string $email, string $name, string $password): bool
{
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO admins (name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $passwordHash);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

/**
 * Get posts with pending comments count
 */
// function getAcceptedPostsWithCommentsCount(mysqli $conn): array
// {
//     $sql = "
//         SELECT 
//             p.title AS title,
//             p.cover_img AS cover_img,
//             p.id AS id,
//             COUNT(c.id) AS comments_count
//         FROM posts p
//         INNER JOIN comments c 
//             ON c.post_id = p.id
//         WHERE p.status = 'accepted'
//         GROUP BY p.id
//         HAVING COUNT(c.id) >= 1
//         ORDER BY comments_count DESC
//     ";

//     $stmt = mysqli_prepare($conn, $sql);
//     mysqli_stmt_execute($stmt);

//     $result = mysqli_stmt_get_result($stmt);

//     $posts = [];
//     while ($row = mysqli_fetch_assoc($result)) {
//         $posts[] = $row;
//     }

//     mysqli_stmt_close($stmt);
//     return $posts;
// }


/**
 * Get post with all comments
 */
function getAcceptedPostsWithPendingCommentsCount(mysqli $conn): array
{
    $sql = "
        SELECT 
            p.id AS id,
            p.title AS title,
            p.cover_img AS cover_img,
            u.username AS author,
            COUNT(c.id) AS pending_comments_count
        FROM posts p
        INNER JOIN users u 
            ON u.id = p.user_id
        INNER JOIN comments c 
            ON c.post_id = p.id
            AND c.status = 'pending'
        WHERE p.status = 'accepted'
        GROUP BY p.id, u.username
        HAVING COUNT(c.id) >= 1
        ORDER BY pending_comments_count DESC
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $posts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }

    mysqli_stmt_close($stmt);
    return $posts;
}



function deleteComment(mysqli $conn, int $commentId): bool
{
    $sql = "UPDATE comments SET status = 'rejected' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $commentId);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}
function approveComment(mysqli $conn, int $commentId): bool
{
    $sql = "UPDATE comments SET status = 'accepted' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $commentId);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

function acceptOrRejectPost(mysqli $conn, int $postId, string $action): bool
{
    $status = ($action === 'accept') ? 'accepted' : 'rejected';

    $sql = "UPDATE posts SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $postId);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

function getPostByIdForAdmin(mysqli $conn, int $id): ?array
{
    $sql = "
        SELECT 
            p.*,
            c.name AS cat_name,
            u.username
        FROM posts p
        JOIN users u ON u.id = p.user_id
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.id = ? 
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

function getUsers($conn, $is_active = null) {
    $sql = "SELECT id, username, email, avatar, is_active, created_at FROM users";

    if ($is_active !== null) {
        $sql .= " WHERE is_active = ?";
    }

    $stmt = mysqli_prepare($conn, $sql);

    if ($is_active !== null) {
        mysqli_stmt_bind_param($stmt, "s", $is_active);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    mysqli_stmt_close($stmt);
    return $users;
}

function userAction(mysqli $conn, int $userId, string $action): bool {
    if ($action ==="delete") {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userId);

        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }
    $status = ($action === 'activate') ? 'active' : 'inactive';

    $sql = "UPDATE users SET is_active = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $userId);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}
