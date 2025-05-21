<?php
require_once 'app/models/Producto.php';

class ProductoController {
    public function index() {
        $productos = Producto::obtenerTodos();
        include 'app/views/productos.php';
    }
}
