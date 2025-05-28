document.querySelectorAll('.btn-delete').forEach(button => {
  button.addEventListener('click', () => {
    const id = button.getAttribute('data-id');
    // Guardar id en el botón de confirmación para usar luego
    document.getElementById('confirmDeleteBtn').setAttribute('data-id', id);

    // Mostrar modal eliminar
    document.getElementById('deleteModal').style.display = 'flex';
  });
});

// Cerrar modal
document.getElementById('closeDeleteModal').addEventListener('click', () => {
  document.getElementById('deleteModal').style.display = 'none';
});

// Cancelar eliminar
document.getElementById('cancelDeleteBtn').addEventListener('click', () => {
  document.getElementById('deleteModal').style.display = 'none';
});

// Confirmar eliminar
document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
  const id = document.getElementById('confirmDeleteBtn').getAttribute('data-id');

  fetch(`index.php?view=productos&action=eliminar&id=${id}`, {
    method: 'POST'
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Producto eliminado correctamente');
      // Cerrar modal
      document.getElementById('deleteModal').style.display = 'none';
      
      location.reload();
    } else {
      alert('Error al eliminar el producto');
    }
  })
  .catch(() => {
    alert('Error al eliminar el producto');
  });
});
