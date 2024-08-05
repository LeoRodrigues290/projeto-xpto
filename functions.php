<?php
require 'db.php';

function registerUser($nome, $email, $senha, $cargo) {
    global $conn;
    $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, cargo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $email, $hashedPassword, $cargo);
    return $stmt->execute();
}

function authenticateUser($email, $senha) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($senha, $user['senha'])) {
        return $user;
    }
    return false;
}


?>