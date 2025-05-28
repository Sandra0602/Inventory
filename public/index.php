<?php
// Ruta absoluta al proyecto
define('BASE_PATH', dirname(__DIR__));


require_once BASE_PATH . '/routes/web.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../app/models/Producto.php';
