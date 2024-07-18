<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/register.js"></script>
    <script src="js/admin_dashboard.js"></script>
</head>
<body>
    <h1>Welcome, Admin</h1>
    <button onclick="window.location.href='php/signout.php'">Sign Out</button>
    <h2>Register Patient</h2>
    <form id="registerForm" action="php/register_patient.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="unique_code">3-Letter Code:</label>
        <input type="text" id="unique_code" name="unique_code" required>
        <br>
        <label for="severity">Severity:</label>
        <input type="number" id="severity" name="severity" required>
        <br>
        <label for="wait_time">Initial Wait Time (minutes):</label>
        <input type="number" id="wait_time" name="wait_time" required>
        <br>
        <button type="submit">Register</button>
    </form>

    <h2>Patient List</h2>
    <table id="patientTable" border="1">
        <thead>
            <tr>
                <th>Patient ID</th>
                <th>Name</th>
                <th>Severity</th>
                <th>Wait Time (minutes)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Patient data will be inserted here -->
        </tbody>
    </table>
</body>
</html>
