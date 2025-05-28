<?php
require_once __DIR__ . '/../../config/database.php';

class Producto {
    public static function obtenerProductos() {
        $pdo = require __DIR__ . '/../../config/database.php';

        $sql = "SELECT p.*, c.nombre AS categoria
                FROM productos p
                LEFT JOIN categoria c ON p.id_categoria = c.id_categoria
                ORDER BY p.id_producto";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


       // Obtener un producto por ID
    public static function obtenerProductoPorId($id) {
    $pdo = require __DIR__ . '/../../config/database.php';
    $stmt = $pdo->prepare("SELECT p.*, c.nombre AS categoria FROM productos p LEFT JOIN categoria c ON p.id_categoria = c.id_categoria WHERE p.id_producto = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Actualizar un producto
    function editarProducto($pdo, $id_producto, $nombre, $descripcion, $creferencia, $precio_compra, 
    $precio_venta, $stock_actual, $stock_minimo, $id_categoria, $activo) {
    $sql = "UPDATE productos 
            SET nombre = :nombre,
                descripcion = :descripcion,
                creferencia = :creferencia,
                precio_compra = :precio_compra,
                precio_venta = :precio_venta,
                stock_actual = :stock_actual,
                stock_minimo = :stock_minimo,
                id_categoria = :id_categoria,
                activo = :activo
            WHERE id_producto = :id_producto";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        ':creferencia' => $creferencia,
        ':precio_compra' => $precio_compra,
        ':precio_venta' => $precio_venta,
        ':stock_actual' => $stock_actual,
        ':stock_minimo' => $stock_minimo,
        ':id_categoria' => $id_categoria,
        ':activo' => $activo,
        ':id_producto' => $id_producto
    ]);
}

    public static function actualizarProducto($id, $data) {
    $pdo = require __DIR__ . '/../../config/database.php';

    // Obtener el stock anterior antes de actualizar
    $stmtOld = $pdo->prepare("SELECT stock_actual FROM productos WHERE id_producto = ?");
    $stmtOld->execute([$id]);
    $stockAntiguo = $stmtOld->fetchColumn();

    // Ejecutar el UPDATE
    $stmt = $pdo->prepare("UPDATE productos SET creferencia = ?, nombre = ?, descripcion = ?, precio_compra = ?, precio_venta = ?, stock_actual = ?, stock_minimo = ? WHERE id_producto = ?");
    $success = $stmt->execute([
        $data['creferencia'],
        $data['nombre'],
        $data['descripcion'],
        $data['precio_compra'],
        $data['precio_venta'],
        $data['stock_actual'],
        $data['stock_minimo'],
        $id
    ]);

    if (!$success) {
        return false;
    }

    // Calcular diferencia para registrar movimiento
    $diferencia = $data['stock_actual'] - $stockAntiguo;

    if ($diferencia != 0) {
        $tipo = $diferencia > 0 ? 'Entrada' : 'Salida';
        $notas = $tipo === 'Entrada' ? 'Compra mayoritaria' : 'Venta a clientes';

        $stmtMov = $pdo->prepare("INSERT INTO movimiento_stock (id_producto, tipo_movimiento, cantidad, notas) VALUES (?, ?, ?, ?)");
        $stmtMov->execute([$id, $tipo, $diferencia, $notas]);
    }

    return true;
}

    // Eliminar un producto
     public static function eliminarProducto($id) {
        $pdo = require __DIR__ . '/../../config/database.php';

        $stmt = $pdo->prepare("DELETE FROM productos WHERE id_producto = ?");
        return $stmt->execute([$id]);
    }

    public static function crearProducto($data) {
    $pdo = require __DIR__ . '/../../config/database.php';

    $stmt = $pdo->prepare("INSERT INTO productos 
        (creferencia, nombre, descripcion, id_categoria, precio_compra, precio_venta, stock_actual, stock_minimo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    return $stmt->execute([
        $data['creferencia'],
        $data['nombre'],
        $data['descripcion'],
        $data['id_categoria'],
        $data['precio_compra'],
        $data['precio_venta'],
        $data['stock_actual'],
        $data['stock_minimo']
    ]);
}

    public static function obtenerProductosPaginados($offset, $limite) {
    $pdo = require __DIR__ . '/../../config/database.php';
    $stmt = $pdo->prepare("SELECT p.*, c.nombre AS nombre_categoria 
                           FROM productos p 
                           LEFT JOIN categoria c ON p.id_categoria = c.id_categoria 
                           LIMIT :limite OFFSET :offset");
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public static function contarProductos() {
        $pdo = require __DIR__ . '/../../config/database.php';
        $stmt = $pdo->query("SELECT COUNT(*) FROM productos");
        return $stmt->fetchColumn();
    }


}



