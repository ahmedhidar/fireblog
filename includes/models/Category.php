<?php
require_once __DIR__ . '/../config/Database.php';


function getAllCategories(mysqli $conn): array
{
    $sql = "SELECT id, name FROM categories ORDER BY name";

    $result = mysqli_query($conn, $sql);

    $categories = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    }

    return $categories;
}
