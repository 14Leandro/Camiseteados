<?php
session_start();
require_once '../config/database.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php?error=Acceso denegado");
    exit();
}

// Obtener categorías de la base de datos
$sql_categorias = "SELECT id, nombre FROM categorias";
$result_categorias = $conn->query($sql_categorias);


// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria_id = $_POST['categoria'];
    
    // Manejo de imagen
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];
    $ruta_destino = "../img/camisetas/" . $imagen_nombre;
    move_uploaded_file($imagen_tmp, $ruta_destino);

    // Insertar producto en la base de datos
    $sql_insert = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("ssdiss", $nombre, $descripcion, $precio, $stock, $categoria_id, $imagen_nombre);
    
    if ($stmt->execute()) {
        $mensaje = "Producto agregado correctamente.";
    } else {
        $error = "Error al agregar el producto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto | Admin</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php include("../includes/navbar.php") ?>
    <div class="container mt-4">

        <h2 class="mb-4">Agregar Nuevo Producto</h2>
        
        <?php if (isset($mensaje)) echo "<div class='alert alert-success'>$mensaje</div>"; ?>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-light">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="precio" class="form-label">Precio ($)</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="stock" class="form-label">Stock Disponible</label>
                    <input type="number" class="form-control" id="stock" name="stock" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="categoria" class="form-label">Categoría</label>
                    <select class="form-select" id="categoria" name="categoria" required>
                        <option value="">Seleccionar</option>
                        <?php while ($row = $result_categorias->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['nombre'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Producto</label>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Agregar Producto</button>
        </form>
    </div>
</body>
</html>
