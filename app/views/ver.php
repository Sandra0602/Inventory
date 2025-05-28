<?php
require_once __DIR__ . '/../../config/database.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de producto no proporcionado']);
    exit;
}

$id = (int) $_GET['id'];
$pdo = require __DIR__ . '/../../config/database.php';

$stmt = $pdo->prepare("SELECT p.*, c.nombre AS categoria FROM productos p LEFT JOIN categoria c ON p.id_categoria = c.id_categoria WHERE p.id_producto = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    http_response_code(404);
    echo json_encode(['error' => 'Producto no encontrado']);
    exit;
}

header('Content-Type: application/json');
echo json_encode($producto);
