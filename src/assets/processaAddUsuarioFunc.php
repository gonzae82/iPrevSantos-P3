<?php
include_once 'db.php';

function cadastrarUsuario($mysqli, $nome, $email, $senha, $cargo) {
    $hashed_password = password_hash($senha, PASSWORD_DEFAULT);

    $SQL = "INSERT INTO usuarios (nome, email, senha, cargo) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($SQL);

    if (!$stmt) {
        return ['success' => false, 'error' => $mysqli->error];
    }

    $stmt->bind_param("ssss", $nome, $email, $hashed_password, $cargo);
    $executado = $stmt->execute();

    return [
        'success' => $executado,
        'error' => $executado ? null : $stmt->error
    ];
}