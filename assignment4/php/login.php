<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Admin login
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            if (!$pdo) {
                throw new Exception('Database connection failed.');
            }

            $stmt = $pdo->prepare('SELECT * FROM Admins WHERE username = :username');
            $stmt->execute(['username' => $username]);
            $admin = $stmt->fetch();

            if ($admin) {
                if ($password === $admin['password']) {
                    $_SESSION['admin'] = $username;
                    $response['success'] = true;
                    $response['message'] = 'Login successful';
                    $response['redirect'] = '../admin_dashboard.php';
                } else {
                    $response['message'] = 'Invalid password';
                }
            } else {
                $response['message'] = 'User not found';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
        } catch (Exception $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
        }
    } elseif (isset($_POST['name']) && isset($_POST['unique_code'])) {
        // Patient login
        $name = $_POST['name'];
        $unique_code = $_POST['unique_code'];

        try {
            if (!$pdo) {
                throw new Exception('Database connection failed.');
            }

            $stmt = $pdo->prepare('SELECT * FROM Patients WHERE name = :name AND unique_code = :unique_code');
            $stmt->execute(['name' => $name, 'unique_code' => $unique_code]);
            $patient = $stmt->fetch();

            if ($patient) {
                $_SESSION['patient'] = $name;
                $response['success'] = true;
                $response['message'] = 'Login successful';
                $response['redirect'] = '../patient_dashboard.php';
            } else {
                $response['message'] = 'Patient not found';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
        } catch (Exception $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'Invalid request parameters';
    }
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
