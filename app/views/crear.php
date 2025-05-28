<?php include 'layout.php'; ?>

<div class="content">
  <h1>Agregar Producto</h1>
  <form action="" method="POST" class="form">
    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Descripción:</label>
    <textarea name="descripcion"></textarea>

    <label>Código de referencia:</label>
    <input type="text" name="creferencia" required>

    <label>Precio de compra:</label>
    <input type="number" name="precio_compra" step="0.01" required>

    <label>Precio de venta:</label>
    <input type="number" name="precio_venta" step="0.01" required>

    <label>Stock actual:</label>
    <input type="number" name="stock_actual" required>

    <label>Stock mínimo:</label>
    <input type="number" name="stock_minimo" required>

    <label>Categoría:</label>
    <select name="id_categoria" required>
      <?php foreach ($categorias as $cat): ?>
        <option value="<?= $cat['id_categoria'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
      <?php endforeach; ?>
    </select>

    <label>
      <input type="checkbox" name="activo" checked> Activo
    </label>

    <button type="submit" class="btn">Guardar</button>
    <a href="index.php?view=productos" class="btn cancel">Cancelar</a>
  </form>
</div>
