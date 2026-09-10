<?php
// auth/functions.php
require __DIR__ . '/database/config.php';
require __DIR__ . '/validation.php';

function emailExists($email) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    return $stmt->fetch() !== false;
}

function registerUser($full_name, $email, $password) {
    $pdo = getConnection();
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (full_name, email, password) VALUES (:full_name, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':full_name', $full_name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $hashed);

    return $stmt->execute();
}

function findUserByEmail($email) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT id, full_name, password, role FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>