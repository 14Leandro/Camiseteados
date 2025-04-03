<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $stock = intval($_POST['stock']);

    $sql = "UPDATE productos SET stock = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $stock, $id);

    if ($stmt->execute()) {
        echo "Stock actualizado correctamente.";
    } else {
        echo "Error al actualizar el stock.";
    }
}
?>
