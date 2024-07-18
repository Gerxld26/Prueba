<?php
include 'db.php';

// Definir los datos del nuevo usuario
$username = 'admin';
$password = 'password123';
$is_admin = true;

// Hash de la contraseña
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Preparar e insertar el nuevo usuario
$query = $db->prepare('INSERT INTO users (username, password, is_admin) VALUES (?, ?, ?)');
$query->execute([$username, $hashed_password, $is_admin]);

echo "Usuario agregado exitosamente.";
?>
