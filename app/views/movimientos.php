<?php
require_once __DIR__ . '/../../config/database.php';
include 'layout.php';
require_once __DIR__ . '/../models/movimiento.php';
?>

<div class="dashboard">
  <div class="sidebar">
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="index.php?view=productos">Productos</a></li>
      <li><a href="index.php?view=movimientos">Movimientos</a></li> 
    </ul>
  </div>

  <div class="content">
    <h1>Movimientos de Inventario</h1>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Notas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movimientos as $mov): ?>
                <tr>
                    <td><?= htmlspecialchars($mov['nombre_producto']) ?></td>
                    <td><?= $mov['tipo_movimiento'] ?></td>
                    <td><?= $mov['cantidad'] ?></td>
                    <td><?= $mov['fecha'] ?></td>
                    <td><?= htmlspecialchars($mov['notas']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
  <span>Página:</span>
    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <a href="?view=movimientos&pagina=<?= $i ?>" class="<?= $paginaActual == $i ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
    </div>

<style>
  .pagination a {
    margin: 0 5px;
    text-decoration: none;
    color: #333;
    padding: 5px 10px;
    border: 1px solid #ccc;
  }
  .pagination a.active {
    background-color: #007BFF;
    color: white;
  }
</style>
   </div>
</div>