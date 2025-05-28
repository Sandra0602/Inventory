<?php
class DashboardController {
    public function index() {
        $pdo = require __DIR__ . '/../../config/database.php';
        // Total ingresos: suma de ABS(cantidad) * precio_venta para movimientos tipo salida
        $stmtIngresos = $pdo->prepare("
            SELECT 
                SUM(ABS(ms.cantidad) * p.precio_venta) AS totalIngresos, 
                SUM(ABS(ms.cantidad)) AS productosVendidos
            FROM movimiento_stock ms
            JOIN productos p ON ms.id_producto = p.id_producto
            WHERE ms.tipo_movimiento = 'salida'
        ");
        $stmtIngresos->execute();
        $datos = $stmtIngresos->fetch(PDO::FETCH_ASSOC);

        $totalIngresos = $datos['totalIngresos'] ?? 0;
        $productosVendidos = $datos['productosVendidos'] ?? 0;

         // Obtener productos con stock bajo o igual al stock mínimo
        $stmtAlertas = $pdo->prepare("
            SELECT nombre, stock_actual, stock_minimo FROM productos
            WHERE stock_actual <= stock_minimo
        ");
        $stmtAlertas->execute();
        $productosBajoStock = $stmtAlertas->fetchAll(PDO::FETCH_ASSOC);

        // Datos de ventas por mes y semana
        $stmtVentas = $pdo->query("
            SELECT 
                MONTH(ms.fecha) AS mes,
                FLOOR((DAY(ms.fecha) - 1) / 7) + 1 AS semana,
                SUM(ABS(ms.cantidad) * p.precio_venta) AS ingreso
            FROM movimiento_stock ms
            JOIN productos p ON ms.id_producto = p.id_producto
            WHERE ms.tipo_movimiento = 'salida'
            GROUP BY mes, semana
        ");

        $ventas = [];
        while ($fila = $stmtVentas->fetch(PDO::FETCH_ASSOC)) {
            $mes = (int)$fila['mes'];
            $semana = (int)$fila['semana'];
            $ingreso = (float)$fila['ingreso'];

            if (!isset($ventas[$mes])) {
                $ventas[$mes] = [0, 0, 0, 0]; // 4 semanas
            }

            // Asegurarse de no superar 4 semanas
            if ($semana >= 1 && $semana <= 4) {
                $ventas[$mes][$semana - 1] += $ingreso;
            }
        }


        // Pasar los datos a la vista
        include __DIR__ . '/../views/dashboard.php';
    }
}
