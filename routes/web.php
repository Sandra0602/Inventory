<?php

if (isset($_GET['view'])) {
    switch ($_GET['view']) {
        case 'productos':
            require_once BASE_PATH . '/app/controllers/ProductoController.php';
            $controller = new ProductoController();

            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'ver':
                        $controller->ver($_GET['id']);
                        break;
                    case 'editar':
                        $controller->editar($_GET['id']);
                        break;
                    case 'actualizar':
                        $controller->actualizar($_GET['id']);
                        break;
                    case 'eliminar':
                        $controller->eliminar();
                        break;
                    case 'guardar':
                        $controller->guardar();
                        break;
                    case 'categorias':
                        $controller->categorias();
                        break;
                    default:
                        $controller->index();
                        break;
                }
            } else {
                $controller->index();
            }
            break;

        case 'movimientos':
            require_once BASE_PATH . '/app/controllers/MovimientoController.php';
            $controller = new MovimientoController();

            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    default:
                        $controller->index();
                        break;
                }
            } else {
                $controller->index();
            }
            break;

        case 'dashboard':
            require_once BASE_PATH . '/app/controllers/DashboardController.php';
            $controller = new DashboardController();
            $controller->index();
            break;

        default:
            // Vista por defecto, dashboard
            require_once BASE_PATH . '/app/controllers/DashboardController.php';
            $controller = new DashboardController();
            $controller->index();
            break;
    }
} else {
    // Si no hay parámetro 'view', cargar dashboard
    require_once BASE_PATH . '/app/controllers/DashboardController.php';
    $controller = new DashboardController();
    $controller->index();
}
