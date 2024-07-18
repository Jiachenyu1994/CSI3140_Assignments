<?php
$host = 'localhost';
$db = 'emergency_waitlist';
$user = 'postgres';  // change your assigned postgreSQL username as needed

$password = 'carl';  // change you assgined postgreSQL password as needed

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$db;";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;  // Ensure the script exits if the connection fails
}
?>
