<?php
require 'config/dbcon.php';

$users = [
    ['username' => 'administrator', 'password' => 'Administrator@trackr', 'role' => 'admin'],
    ['username' => 'staff_user', 'password' => 'Administrator@trackr', 'role' => 'staff'],
    ['username' => 'staff_user1', 'password' => 'Administrator@trackr1', 'role' => 'staff'],

];

foreach ($users as $user) {
    $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);

    // Check if user exists
    $check_sql = "SELECT * FROM users WHERE username = ?";
    $check_stmt = $con->prepare($check_sql);
    $check_stmt->bind_param("s", $user['username']);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, update
        $sql = "UPDATE users SET password = ?, role = ? WHERE username = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sss", $hashed_password, $user['role'], $user['username']);
    } else {
        // User doesn't exist, insert
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sss", $user['username'], $hashed_password, $user['role']);
    }

    if ($stmt->execute()) {
        echo "User {$user['username']} processed successfully<br>";
    } else {
        echo "Error processing user {$user['username']}: " . $stmt->error . "<br>";
    }

    $check_stmt->close();
    $stmt->close();
}

$con->close();
