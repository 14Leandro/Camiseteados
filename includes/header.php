<?php
session_start(); // Iniciar sesión para manejar el login
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camiseteados</title>
    <link rel="stylesheet" href="css/styles.css?v=<?= time(); ?>"> <!-- Cache Bypass -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<header class="navbar navbar-expand-lg navbar-dark bg-dark py-3 shadow">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <span class="fs-3 fw-bold text-uppercase text-light">Camiseteados</span>
        </a>

        <!-- Botón de menú para móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú de navegación -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link text-light" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="pages/tienda.php">Tienda</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="pages/novedades.php">Novedades</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="pages/contacto.php">Contacto</a></li>
            </ul>
        </div>

        <!-- Buscador -->
        <form class="d-flex me-3" action="pages/buscar.php" method="GET">
            <input class="form-control me-2" type="search" placeholder="Buscar camisetas..." name="q">
            <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
        </form>

        <!-- Carrito de compras -->
        <a href="pages/carrito.php" class="btn btn-light position-relative me-3">
            <i class="fas fa-shopping-cart"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">0</span>
        </a>

        <!-- Botones de usuario -->
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="d-flex align-items-center">
                    <span class="text-light fw-bold me-3">
                        <i class="fa-solid fa-user-circle"></i> <?= htmlspecialchars($_SESSION['user_name']); ?>
                    </span>
                    <a href="process/logout.php" class="btn btn-danger px-4">
                        <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
                    </a>
                </div>
            <?php else: ?>
                <button class="btn btn-outline-light px-4 me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="fa-solid fa-right-to-bracket"></i> Login
                </button>
                <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#registerModal">
                    <i class="fa-solid fa-user-plus"></i> Registrarse
                </button>
            <?php endif; ?>
        </div>
    </div>
</header>


<!-- Modal de Login -->
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Iniciar Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if (isset($_GET['error_login'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error_login']); ?></div>
                <?php endif; ?>
                <form action="process/login.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Registro -->
<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Cuenta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if (isset($_GET['error_register'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error_register']); ?></div>
                <?php endif; ?>
                <?php if (isset($_GET['success_register'])): ?>
                    <div class="alert alert-success">Registro exitoso. Ahora puedes iniciar sesión.</div>
                <?php endif; ?>
                <form action="process/register.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
