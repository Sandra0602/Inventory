<?php
require_once __DIR__ . '/../../config/database.php';

$pdo = require __DIR__ . '/../../config/database.php';;

if (!isset($_GET['id'])) {
    die('ID de producto no proporcionado.');
}

$id = (int) $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio_compra = $_POST['precio_compra'];
    $precio_venta = $_POST['precio_venta'];
    $stock_actual = $_POST['stock_actual'];
    $stock_minimo = $_POST['stock_minimo'];

    $stmt = $pdo->prepare("UPDATE productos SET nombre=?, descripcion=?, precio_compra=?, precio_venta=?, stock_actual=?, stock_minimo=? WHERE id_producto=?");
    $stmt->execute([$nombre, $descripcion, $precio_compra, $precio_venta, $stock_actual, $stock_minimo, $id]);

    header("Location: index.php?view=productos");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM productos WHERE id_producto = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    die('Producto no encontrado.');
}
?>

<a href="index.php?view=productos">Cancelar</a>
