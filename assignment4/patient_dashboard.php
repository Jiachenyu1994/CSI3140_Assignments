<?php
session_start();
if (!isset($_SESSION['patient'])) {
    header('Location: index.html');
    exit;
}
$patient_name = $_SESSION['patient'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/patient_dashboard.js"></script>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($patient_name); ?></h1>
    <button onclick="window.location.href='php/signout.php'">Sign Out</button>
    <h2>Your Wait Time</h2>
    <p id="wait-time">Loading...</p>
</body>
</html>
