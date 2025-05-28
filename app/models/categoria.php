<?php
class Categoria {
    private static $pdo;

    public static function init($conexion) {
        self::$pdo = $conexion;
    }

    public static function obtenerTodos() {
        $stmt = self::$pdo->query("SELECT * FROM categorias");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerPorId($id) {
        $stmt = self::$pdo->prepare("SELECT * FROM categorias WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}