<?php
header('Content-Type: application/json');
$dataFile = 'data/users.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($password !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
        exit;
    }

    if (file_exists($dataFile)) {
        $users = json_decode(file_get_contents($dataFile), true);
    } else {
        $users = [];
    }

    foreach ($users as $user) {
        if ($user['email'] === $email) {
            echo json_encode(['success' => false, 'message' => 'Email already registered']);
            exit;
        }
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $users[] = ['username' => $username, 'email' => $email, 'password' => $hashedPassword];

    file_put_contents($dataFile, json_encode($users));
    echo json_encode(['success' => true, 'message' => 'Registration successful']);
}
?>
