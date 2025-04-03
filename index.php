<?php
include 'config/database.php'; // Conexión a la base de datos

if (isset($_GET['error'])) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
}
if (isset($_GET['success'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
}

// Consultar productos
$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camiseteados - Tienda Online</title>
    <link rel="stylesheet" href="css/styles.css?v=<?= time(); ?>"> <!-- Cache Bypass -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<?php include 'includes/header.php'; ?> <!-- Incluir el header -->

<div class="container mt-4">
    <h2 class="text-center mb-4">Camisetas Disponibles</h2>
    <div class="row">
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?= $fila['imagen']; ?>" class="card-img-top" alt="<?= $fila['nombre']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $fila['nombre']; ?></h5>
                        <p class="card-text"><?= $fila['descripcion']; ?></p>
                        <p class="text-primary"><strong>$<?= number_format($fila['precio'], 2, ',', '.'); ?></strong></p>
                        <p class="text-muted"><small><?= $fila['liga']; ?> - <?= $fila['categoria']; ?></small></p>
                        <a href="pages/producto.php?id=<?= $fila['id']; ?>" class="btn btn-primary">Ver detalles</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?> <!-- Incluir el footer -->

</body>
</html>

