<?php
require_once __DIR__ . '/../../config/database.php';
class Movimiento {
    public static function obtenerTodos() {
        $pdo = require __DIR__ . '/../../config/database.php';

        $stmt = $pdo->query("SELECT m.*, p.nombre AS nombre_producto FROM movimiento_stock m
                             JOIN productos p ON m.id_producto = p.id_producto
                             ORDER BY m.fecha DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
