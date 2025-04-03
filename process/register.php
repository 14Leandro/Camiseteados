<?php
session_start();
require '../config/database.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = ucfirst(strtolower(trim($_POST['nombre'])));
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = 'usuario'; // Por defecto, todos los usuarios son "usuario"

    // Verificar si el correo ya está registrado
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: ../index.php?error_register=El correo ya está registrado");
        exit();
    }

    // Insertar usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $email, $password, $rol);

    if ($stmt->execute()) {
        // Obtener el ID del usuario recién registrado
        $user_id = $stmt->insert_id;

        // Iniciar sesión automáticamente
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $nombre;
        $_SESSION['user_role'] = $rol;

        header("Location: ../index.php?success_register=Registro exitoso");
        exit();
    } else {
        header("Location: ../index.php?error_register=Error al registrar");
        exit();
    }
}
?>
