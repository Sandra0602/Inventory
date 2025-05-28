<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController {
    public function index() {
       
    try {
        $productosPorPagina = 10;

        // Obtener la página actual desde la URL, por defecto 1
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $offset = ($paginaActual - 1) * $productosPorPagina;

        // Conexión a la base de datos
        $pdo = require __DIR__ . '/../../config/database.php';

        // Obtener productos paginados con su categoría
        $stmt = $pdo->prepare("
            SELECT p.*, c.nombre AS nombre_categoria
            FROM productos p
            LEFT JOIN categoria c ON p.id_categoria = c.id_categoria
            LIMIT :limite OFFSET :offset
        ");
        $stmt->bindValue(':limite', $productosPorPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        $totalProductos = $pdo->query("SELECT COUNT(*) FROM productos")->fetchColumn();
        $totalPaginas = ceil($totalProductos / $productosPorPagina);

    
        include __DIR__ . '/../views/productos.php';

    } catch (Exception $e) {
        error_log("Error al cargar productos: " . $e->getMessage());
        echo "Ocurrió un error al cargar los productos.";
    }
}

    public function ver($id) {
    $producto = Producto::obtenerProductoPorId($id);
    if (!$producto) {
        http_response_code(404);
        echo json_encode(['error' => 'Producto no encontrado']);
        return;
    }

    header('Content-Type: application/json');
    echo json_encode($producto);
    }


    public function editar($id) {
    $producto = Producto::obtenerProductoPorId($id);
    header('Content-Type: application/json');
    echo json_encode($producto);
}

public function actualizar($id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'creferencia' => $_POST['creferencia'],
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'precio_compra' => $_POST['precio_compra'],
            'precio_venta' => $_POST['precio_venta'],
            'stock_actual' => $_POST['stock_actual'],
            'stock_minimo' => $_POST['stock_minimo'],
        ];

        $resultado = Producto::actualizarProducto($id, $data);
        if ($resultado) {
            echo 'OK';
        } else {
            http_response_code(500);
            echo 'Error al actualizar';
        }
    }
}

    public function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
                return;
            }

            $id = (int) $_GET['id'];

            require_once __DIR__ . '/../models/Producto.php';

            $resultado = Producto::eliminarProducto($id);

            if ($resultado) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se pudo eliminar']);
            }
        } else {
            // Método no permitido
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        }
    }

    public function crear() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $datos = [
            'creferencia' => $_POST['creferencia'] ?? '',
            'nombre' => $_POST['nombre'] ?? '',
            'descripcion' => $_POST['descripcion'] ?? '',
            'id_categoria' => $_POST['id_categoria'] ?? 0,
            'precio_compra' => $_POST['precio_compra'] ?? 0,
            'precio_venta' => $_POST['precio_venta'] ?? 0,
            'stock_actual' => $_POST['stock_actual'] ?? 0,
            'stock_minimo' => $_POST['stock_minimo'] ?? 0,
        ];

        require_once __DIR__ . '/../models/Producto.php';
        $resultado = Producto::crearProducto($datos);

        if ($resultado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo crear el producto']);
        }
    } else {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    }

    }

    public function categorias() {
    $pdo = require __DIR__ . '/../../config/database.php';
    $stmt = $pdo->query("SELECT id_categoria, nombre FROM categoria");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($categorias);
    }

    public function guardar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;

        require_once __DIR__ . '/../models/Producto.php';
        $resultado = Producto::crearProducto($data);

        if ($resultado) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al guardar el producto']);
        }
        exit;
    }
    }

}