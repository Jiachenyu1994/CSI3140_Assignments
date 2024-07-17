<?php
$host = 'localhost';
$db = 'emergency_waitlist';
$user = 'postgres';  // or your newly created user
$password = 'carl';  // ensure this is the correct password

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$db;";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;  // Ensure the script exits if the connection fails
}
?>
