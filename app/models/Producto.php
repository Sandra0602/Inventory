<?php
require_once 'config/database.php';

class Producto {
    public static function obtenerTodos() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM productos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Agregar, editar, eliminar productos aquí...
}
