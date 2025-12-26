<?php

require_once __DIR__ . '/../config/Database.php';

function createUser(mysqli $conn, string $username, string $email , string $avatarPath, string $password): bool
{
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, avatar, password) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $avatarPath, $passwordHash);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

 function loginUser(mysqli $conn, string $email, string $password)
{
    $sql = "SELECT * FROM users WHERE email = ? AND is_active = 'active' LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) !== 1) {
        mysqli_stmt_close($stmt);
        return false;
    }

    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}

