<?php
header('Content-Type: application/json');
$dataFile = 'data/users.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!file_exists($dataFile)) {
        echo json_encode(['success' => false, 'message' => 'No users registered']);
        exit;
    }

    $users = json_decode(file_get_contents($dataFile), true);

    foreach ($users as $user) {
        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            echo json_encode(['success' => true, 'message' => 'Login successful']);
            exit;
        }
    }

    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
}
?>
