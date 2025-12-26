<?php
$servername = "localhost";
$username   = "root";
$password   = "1122";
$dbname     = "blog";

function connect( string $servername = "localhost",
    string $username   = "root",
    string $password   = "1122",
    string $dbname     = "blog" ): mysqli
{
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    return $conn;
}
