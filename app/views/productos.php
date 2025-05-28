<?php
require_once __DIR__ . '/../../config/database.php';
include 'layout.php';
require_once __DIR__ . '/../models/Producto.php';
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
    <h1>Productos</h1>
    
    <div class="actions">
      <button class="btn btn-create">➕ Añadir</button>
      <div class="search">
        <input type="text" placeholder="Buscar..." id="searchInput">
        <button onclick="filterProducts()">Filtrar</button>
      </div>
    </div>
    
    <table id="productsTable">
      <thead>
        <tr>
          <th>Código</th>
          <th>Nombre</th>
          <th>Categoría</th>
          <th>Stock</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($productos as $producto): ?>
        <tr>
          <td><?= htmlspecialchars($producto['creferencia']) ?></td>
          <td><?= htmlspecialchars($producto['nombre']) ?></td>
          <td><?= htmlspecialchars($producto['nombre_categoria']) ?></td>
          <td class="<?= $producto['stock_actual'] <= $producto['stock_minimo'] ? 'low-stock' : '' ?>">
            <?= $producto['stock_actual'] ?>
            <?php if($producto['stock_actual'] <= $producto['stock_minimo']): ?>
              <span class="stock-alert">⚠️</span>
            <?php endif; ?>
          </td>
          <td class="actions">
                <button class="btn-view" data-id="<?= $producto['id_producto'] ?>">👁️ Ver</button>
                <button class="btn-edit" data-id="<?= $producto['id_producto'] ?>">✏️ Editar</button>
                <button class="btn-delete" data-id="<?= $producto['id_producto'] ?>">🗑️ Eliminar</button>

           </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <!-- Paginado-->
    <div class="pagination" style="display: flex; margin-top: 5px;">
        <span>Página</span>
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="index.php?view=productos&pagina=<?= $i ?>" class="<?= $paginaActual == $i ? 'active' : '' ?>">
            <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
  </div>
</div>
<!-- Modal para Ver Producto -->
<div id="productModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span id="closeModal" style="float:right; cursor:pointer; font-size:40px;">&times;</span>
    <h2>Detalle del Producto</h2>
    <table id="modalTable">
      
    </table>
  </div>
</div>

<!-- Modal para Editar Producto -->
<div id="editModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span id="closeEditModal" style="float:right; cursor:pointer; font-size:40px;">&times;</span>
    <h2>Editar Producto</h2>
    <form id="editProductForm">
      <table id="editModalTable">
        <tr>
          <td><label for="edit_creferencia">Código:</label></td>
          <td><input type="text" id="edit_creferencia" name="creferencia" required></td>
        </tr>
        <tr>
          <td><label for="edit_nombre">Nombre:</label></td>
          <td><input type="text" id="edit_nombre" name="nombre" required></td>
        </tr>
        <tr>
          <td><label for="edit_descripcion">Descripción:</label></td>
          <td><textarea id="edit_descripcion" name="descripcion"></textarea></td>
        </tr>
        <tr>
          <td><label for="edit_precio_compra">Precio Compra:</label></td>
          <td><input type="number" step="0.01" id="edit_precio_compra" name="precio_compra" required></td>
        </tr>
        <tr>
          <td><label for="edit_precio_venta">Precio Venta:</label></td>
          <td><input type="number" step="0.01" id="edit_precio_venta" name="precio_venta" required></td>
        </tr>
        <tr>
          <td><label for="edit_stock_actual">Stock Actual:</label></td>
          <td><input type="number" id="edit_stock_actual" name="stock_actual" required></td>
        </tr>
        <tr>
          <td><label for="edit_stock_minimo">Stock Mínimo:</label></td>
          <td><input type="number" id="edit_stock_minimo" name="stock_minimo" required></td>
        </tr>
        <tr>
          <td colspan="2" style="text-align:center;">
            <button type="submit" class="btn">💾 Guardar Cambios</button>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<!-- Modal para Eliminar Producto -->
<div id="deleteModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span id="closeDeleteModal" style="float:right; cursor:pointer; font-size:40px;">&times;</span>
    <h2>Eliminar Producto</h2>
    <p>¿Estás seguro de eliminar este producto?</p>
    <div class="modal-actions" style="text-align: right;">
      <button id="confirmDeleteBtn" style="background-color: #dc3545;">Eliminar</button>
      <button id="cancelDeleteBtn">Cancelar</button>
    </div>
  </div>
</div>
<!-- Modal para Añadir Producto -->
<div id="createModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span id="closeCreateModal" style="float:right; cursor:pointer; font-size:40px;">&times;</span>
    <h2>Crear Producto</h2>
    <form id="createForm">
      <table>
        <tr>
          <th><label for="creferencia">Código</label></th>
          <td><input type="text" id="creferencia" name="creferencia" required></td>
        </tr>
        <tr>
          <th><label for="nombre">Nombre</label></th>
          <td><input type="text" id="nombre" name="nombre" required></td>
        </tr>
        <tr>
          <th><label for="descripcion">Descripción</label></th>
          <td><textarea id="descripcion" name="descripcion" required></textarea></td>
        </tr>
        <tr>
          <th><label for="id_categoria">Categoría</label></th>
          <td>
            <select id="id_categoria" name="id_categoria" required>
              
            </select>
          </td>
        </tr>
        <tr>
          <th><label for="precio_compra">Precio Compra</label></th>
          <td><input type="number" step="0.01" id="precio_compra" name="precio_compra" required></td>
        </tr>
        <tr>
          <th><label for="precio_venta">Precio Venta</label></th>
          <td><input type="number" step="0.01" id="precio_venta" name="precio_venta" required></td>
        </tr>
        <tr>
          <th><label for="stock_actual">Stock Actual</label></th>
          <td><input type="number" id="stock_actual" name="stock_actual" required></td>
        </tr>
        <tr>
          <th><label for="stock_minimo">Stock Mínimo</label></th>
          <td><input type="number" id="stock_minimo" name="stock_minimo" required></td>
        </tr>
      </table>
      <button type="submit" class="btn">💾 Guardar</button>
    </form>
  </div>
</div>

    <script src="/Inventory/public/js/modalVer.js"></script>
    <script src="/Inventory/public/js/modalEditar.js"></script>
    <script src="/Inventory/public/js/modalDelete.js"></script>
    <script src="/Inventory/public/js/modalCrear.js"></script>
    <script src="/Inventory/public/js/buscarProd.js"></script>

