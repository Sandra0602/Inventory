document.querySelectorAll('.btn-edit').forEach(button => {
  button.addEventListener('click', () => {
    const id = button.getAttribute('data-id');

    fetch(`index.php?view=productos&action=editar&id=${id}`)
      .then(response => response.json())
      .then(data => {
        document.getElementById('edit_creferencia').value = data.creferencia;
        document.getElementById('edit_nombre').value = data.nombre;
        document.getElementById('edit_descripcion').value = data.descripcion;
        document.getElementById('edit_precio_compra').value = data.precio_compra;
        document.getElementById('edit_precio_venta').value = data.precio_venta;
        document.getElementById('edit_stock_actual').value = data.stock_actual;
        document.getElementById('edit_stock_minimo').value = data.stock_minimo;
        document.getElementById('editProductForm').setAttribute('data-id', id);

        document.getElementById('editModal').style.display = 'flex';
      });
  });
});

document.getElementById('closeEditModal').addEventListener('click', () => {
  document.getElementById('editModal').style.display = 'none';
});

// Envío del formulario de edición
document.getElementById('editProductForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const id = this.getAttribute('data-id');
  const formData = new FormData(this);

  fetch(`index.php?view=productos&action=actualizar&id=${id}`, {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(result => {
    alert('Producto actualizado correctamente');
    document.getElementById('editModal').style.display = 'none';
    location.reload();
  })
  .catch(() => {
    alert('Error al actualizar el producto');
  });
});