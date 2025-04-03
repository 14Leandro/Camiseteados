<?php
session_start();
require_once '../config/database.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php?error=Acceso denegado");
    exit();
}

// Obtener el ID del producto
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: productos.php?error=Producto no encontrado");
    exit();
}

$id = intval($_GET['id']);

// Obtener el producto de la base de datos
$sql = "SELECT * FROM productos WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header("Location: productos.php?error=Producto no encontrado");
    exit();
}

$producto = $result->fetch_assoc();

// Obtener todas las categorías
$sqlCategorias = "SELECT * FROM categorias";
$resultCategorias = $conn->query($sqlCategorias);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/admin.css">
    
</head>
<body>
    <?php include("../includes/navbar.php"); ?>

    <div class="container mt-5">
        <h2>Editar Producto</h2>
        <form action="../process/editar_producto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $producto['id'] ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" value="<?= $producto['nombre'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" name="descripcion" required><?= $producto['descripcion'] ?></textarea>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" class="form-control" name="precio" value="<?= $producto['precio'] ?>" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" class="form-control" name="stock" value="<?= $producto['stock'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría:</label>
                <select class="form-control" name="categoria_id" required>
                    <?php while ($categoria = $resultCategorias->fetch_assoc()): ?>
                        <option value="<?= $categoria['id'] ?>" <?= ($producto['categoria_id'] == $categoria['id']) ? 'selected' : '' ?>>
                            <?= $categoria['nombre'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen actual:</label><br>
                <img src="../img/camisetas/<?= $producto['imagen'] ?>" width="100">
                <input type="file" class="form-control mt-2" name="imagen">
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="productos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

</body>
</html>
