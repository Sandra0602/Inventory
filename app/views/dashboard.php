<?php include 'layout.php'; ?>

<div class="dashboard">
  <div class="sidebar">
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="index.php?view=productos">Productos</a></li>
      <li><a href="index.php?view=movimientos">Movimientos</a></li>      
    </ul>
  </div>

  <div class="content">
    <div class="cards">
      <div class="card">
        <h2>$<?= number_format($totalIngresos, 2) ?></h2>
        <p>Ingresos generados</p>
        <div class="indicator green">▲ 23%</div>
      </div>
      <div class="card">
        <h2><?= $productosVendidos ?></h2>
        <p>Productos vendidos</p>
        <div class="indicator purple">▲ 34%</div>
      </div>
      <div class="card notification">
        <p><strong>Notificaciones</strong></p>
        <div class="alert">
          <?php if (empty($productosBajoStock)):?>
            <small>No hay productos con stock bajo.</small>
          <?php else: ?>
            <?php foreach ($productosBajoStock as $producto): ?>
              <small>
                ⚠️ El producto <strong><?= htmlspecialchars($producto['nombre']) ?></strong> está por agotarse. Stock actual: <?= $producto['stock_actual'] ?>, mínimo: <?= $producto['stock_minimo'] ?>.
              </small>
              <?php endforeach; ?>
            <?php endif; ?>
        </div>
      </div>
    </div>

<div class="chart">
  <div style="margin-bottom: 0px;">
    <label for="mesSelect"><strong>Mes:</strong></label>
    <select id="mesSelect">
      <option value="1">Enero</option>
      <option value="2">Febrero</option>
      <option value="3">Marzo</option>
      <option value="4">Abril</option>
      <option value="5">Mayo</option>
      <option value="6">Junio</option>
      <option value="7">Julio</option>
      <option value="8">Agosto</option>
      <option value="9">Septiembre</option>
      <option value="10">Octubre</option>
      <option value="11">Noviembre</option>
      <option value="12">Diciembre</option>
    </select>
  </div>

  <canvas id="ventasChart"></canvas>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ventasPorMes = <?= json_encode($ventas); ?>;
</script>
<script src="/Inventory/public/js/script.js"></script>
