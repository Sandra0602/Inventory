<?php
class MovimientoController {
    public function index() {
        $pdo = require __DIR__ . '/../../config/database.php';

        // Obtener número total de movimientos
        $stmtTotal = $pdo->query("SELECT COUNT(*) FROM movimiento_stock");
        $totalMovimientos = $stmtTotal->fetchColumn();

        $porPagina = 14; // Movimientos por página
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($paginaActual < 1) $paginaActual = 1;

        $offset = ($paginaActual - 1) * $porPagina;

        // Obtener movimientos paginados con información del producto
        $stmt = $pdo->prepare("
            SELECT ms.*, p.nombre AS nombre_producto 
            FROM movimiento_stock ms 
            JOIN productos p ON ms.id_producto = p.id_producto
            ORDER BY ms.fecha DESC 
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalPaginas = ceil($totalMovimientos / $porPagina);

        include __DIR__ . '/../views/movimientos.php';
    }
}
