<?php
session_start();
require '../config/database.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitización y validación básica
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    // Verificar si los datos son válidos
    if (!$nombre || !$email || !$password) {
        header("Location: ../index.php?error_register=Datos inválidos");
        exit();
    }

    $nombre = ucfirst(strtolower(trim($nombre))); // Formato adecuado al nombre
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $rol = 'usuario'; // Rol por defecto

    // Verificar si el correo ya está registrado
    if ($stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?")) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            header("Location: ../index.php?error_register=El correo ya está registrado");
            exit();
        }
        $stmt->close();
    } else {
        header("Location: ../index.php?error_register=Error en la consulta");
        exit();
    }

    // Insertar usuario
    if ($stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)")) {
        $stmt->bind_param("ssss", $nombre, $email, $passwordHash, $rol);

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
        $stmt->close();
    } else {
        header("Location: ../index.php?error_register=Error al preparar la consulta");
        exit();
    }
}
?>
