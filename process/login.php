<?php
require '../config/database.php'; // Conexión a la base de datos
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        header("Location: ../index.php?error=Campos vacíos");
        exit();
    }

    // Buscar el usuario en la base de datos
    $stmt = $conn->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) { // Verifica si el usuario existe antes de hacer fetch()
        $stmt->bind_result($id, $nombre, $password_hash, $rol);
        $stmt->fetch();

        if (password_verify($password, $password_hash)) {
            // Credenciales correctas, iniciar sesión
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $nombre;
            $_SESSION['user_role'] = $rol;

            if ($rol === 'admin') {
                header("Location: ../admin/index.php");
            } else {
                header("Location: ../index.php");
            }
            exit();
        }
    }

    // Si llega aquí, credenciales incorrectas
    header("Location: ../index.php?error=Credenciales incorrectas");
    exit();

    $stmt->close();
}
$conn->close();
?>
