<?php
require_once __DIR__ . '/../../config/database.php';

if (!isset($_GET['id'])) {
    die('ID de producto no proporcionado.');
}

$id = (int) $_GET['id'];
$pdo = require __DIR__ . '/../../config/database.php';

$stmt = $pdo->prepare("DELETE FROM productos WHERE id_producto = ?");
$stmt->execute([$id]);

header("Location: index.php?view=productos");
exit;
