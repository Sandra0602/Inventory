document.querySelectorAll('.btn-view').forEach(button => {
  button.addEventListener('click', () => {
    const id = button.getAttribute('data-id');

    fetch(`index.php?view=productos&action=ver&id=${id}`)
      .then(response => response.json())
      .then(data => {
        const table = document.getElementById('modalTable');
        table.innerHTML = `
          <tr><th>Código</th><td>${data.creferencia}</td></tr>
          <tr><th>Nombre</th><td>${data.nombre}</td></tr>
          <tr><th>Descripción</th><td>${data.descripcion}</td></tr>
          <tr><th>Categoría</th><td>${data.categoria}</td></tr>
          <tr><th>Precio Compra</th><td>$${parseFloat(data.precio_compra).toFixed(2)}</td></tr>
          <tr><th>Precio Venta</th><td>$${parseFloat(data.precio_venta).toFixed(2)}</td></tr>
          <tr><th>Stock Actual</th><td>${data.stock_actual}</td></tr>
          <tr><th>Stock Mínimo</th><td>${data.stock_minimo}</td></tr>
        `;
        document.getElementById('productModal').style.display = 'flex';
      });
  });
});

document.getElementById('closeModal').addEventListener('click', () => {
  document.getElementById('productModal').style.display = 'none';
});

