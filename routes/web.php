<?php
if (isset($_GET['view']) && $_GET['view'] == 'productos') {
    require_once 'app/controllers/ProductoController.php';
    $controller = new ProductoController();
    $controller->index();
} else {
    include BASE_PATH . '/app/views/dashboard.php';

}
