// Abrir el modal de crear producto
document.querySelector('.btn-create').addEventListener('click', () => {
  // Cargar categorías desde el backend
  fetch('index.php?view=productos&action=categorias')
    .then(res => res.json())
    .then(categorias => {
      const select = document.getElementById('id_categoria');
      select.innerHTML = '';
      categorias.forEach(cat => {
        const option = document.createElement('option');
        option.value = cat.id_categoria;
        option.textContent = cat.nombre;
        select.appendChild(option);
      });

      // Mostrar el modal
      document.getElementById('createModal').style.display = 'flex';
    })
    .catch(() => {
      alert('Error al cargar categorías');
    });
});

// Cerrar el modal de crear producto
document.getElementById('closeCreateModal').addEventListener('click', () => {
  document.getElementById('createModal').style.display = 'none';
});

// Manejar el envío del formulario de creación
document.getElementById('createForm').addEventListener('submit', (e) => {
  e.preventDefault();

  const formData = new FormData(e.target);

  fetch('index.php?view=productos&action=guardar', {
    method: 'POST',
    body: formData
  })
    .then(res => {
      if (!res.ok) {
        throw new Error('Error en la solicitud');
      }
      return res.json();
    })
    .then(response => {
      if (response.success) {
        alert('Producto creado correctamente');
        document.getElementById('createModal').style.display = 'none';
        location.reload(); 
      } else {
        alert('Error: ' + (response.message || 'No se pudo crear el producto'));
      }
    })
    .catch(() => {
      alert('Error en la solicitud');
    });
});
