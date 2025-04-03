<?php
session_start();
require_once '../config/database.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php?error=Acceso denegado");
    exit();
}

// Obtener productos de la base de datos
$sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.stock, 
               COALESCE(c.nombre, 'Sin Categoría') AS categoria, p.imagen 
        FROM productos p
        LEFT JOIN categorias c ON p.categoria_id = c.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos | Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/admin.css">
    
</head>
<body>
    <?php include("../includes/navbar.php"); ?>

    <div class="d-flex">

        <!-- Contenido principal -->
        <div class="container-fluid mt-4 p-4">
            <h2 class="mb-4">Gestión de Productos</h2>
            <a href="agregar_producto.php" class="btn btn-success mb-3">Agregar Producto</a>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($producto = $result->fetch_assoc()): ?>
                        <tr>
                            <td><img src="../img/camisetas/<?= $producto['imagen'] ?>" width="50"></td>
                            <td><?= htmlspecialchars($producto['nombre']) ?></td>
                            <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                            <td>$<?= number_format($producto['precio'], 2) ?></td>
                            <td><?= $producto['stock'] ?></td>
                            <td>
                                <a href="editar_producto.php?id=<?= $producto['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="eliminar_producto.php?id=<?= $producto['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap
