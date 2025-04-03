<?php
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $categoria_id = intval($_POST['categoria_id']);

    // Verificar si hay una nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagenNombre = time() . "_" . basename($_FILES['imagen']['name']);
        $imagenRuta = "../img/camisetas/" . $imagenNombre;

        // Subir la imagen
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $imagenRuta)) {
            // Actualizar con nueva imagen
            $sql = "UPDATE productos SET 
                        nombre = '$nombre', 
                        descripcion = '$descripcion', 
                        precio = $precio, 
                        stock = $stock, 
                        categoria_id = $categoria_id, 
                        imagen = '$imagenNombre' 
                    WHERE id = $id";
        } else {
            echo "Error al subir la imagen.";
            exit();
        }
    } else {
        // Actualizar sin cambiar imagen
        $sql = "UPDATE productos SET 
                    nombre = '$nombre', 
                    descripcion = '$descripcion', 
                    precio = $precio, 
                    stock = $stock, 
                    categoria_id = $categoria_id 
                WHERE id = $id";
    }

    if ($conn->query($sql)) {
        header("Location: ../admin/productos.php?success=Producto actualizado");
    } else {
        echo "Error al actualizar el producto.";
    }
}
?>
