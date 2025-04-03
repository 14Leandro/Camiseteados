<?php
session_start();
require_once '../config/database.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php?error=Acceso denegado");
    exit();
}

// Obtener estadísticas
$sql_products = "SELECT COUNT(*) AS total FROM productos";
$sql_sales = "SELECT COUNT(*) AS total FROM ventas";
$sql_users = "SELECT COUNT(*) AS total FROM usuarios";

$products_count = $conn->query($sql_products)->fetch_assoc()['total'];
$sales_count = $conn->query($sql_sales)->fetch_assoc()['total'];
$users_count = $conn->query($sql_users)->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Camiseteados</title>
    <link rel="stylesheet" href="css/admin.css?v=<?= time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="admin-container">

<?php include("../includes/navbar.php") ?>

    <!-- Contenido Principal -->
    <main class="dashboard">
        <h1>Dashboard</h1>

        <div class="stats">
            <div class="card bg-primary">
                <h3>Productos</h3>
                <p>Total: <?php echo $products_count; ?></p>
            </div>
            <div class="card bg-success">
                <h3>Ventas</h3>
                <p>Total: <?php echo $sales_count; ?></p>
            </div>
            <div class="card bg-warning">
                <h3>Usuarios</h3>
                <p>Total: <?php echo $users_count; ?></p>
            </div>
        </div>

        <canvas id="salesChart"></canvas>
    </main>
</div>

<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            datasets: [{
                label: 'Ventas Mensuales',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(54, 162, 235, 0.5)'
            }]
        },
    });
</script>

</body>
</html>
