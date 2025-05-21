<?php include 'layout.php'; ?>


<div class="dashboard">
  <div class="sidebar">
    <ul>
      <li><a href="#">Inicio</a></li>
      <li><a href="index.php?view=productos">Productos</a></li>   
    </ul>
  </div>

  <div class="content">
    <div class="cards">
      <div class="card">
        <h2>$10,234</h2>
        <p>Ingresos generados</p>
        <div class="indicator green">▲ 23%</div>
      </div>
      <div class="card">
        <h2>938</h2>
        <p>Productos vendidos</p>
        <div class="indicator purple">▲ 34%</div>
      </div>
      <div class="card notification">
        <p><strong>Notificaciones</strong></p>
        <div class="alert">El producto X está por agotarse</div>
      </div>
    </div>

    <div class="chart">
      <canvas id="ventasChart"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/actividad/public/js/script.js"></script>

