export function efectoProcesos() {
    const gestionesBoxes = document.querySelectorAll(".gestionesBox")
    gestionesBoxes.forEach(gestion => {
        const titulo = gestion.querySelector('.gestiones-tipo');
        const contenido = gestion.querySelector('.gestionesContenido');

        titulo.addEventListener('click', () => {
            contenido.classList.toggle('show'); // Alterna la clase 'show'
        });
    });


    const botonesAñadirDocumento = document.querySelectorAll('.añadirDocumento');

}

export function abrirFormularioAgregar() {
    const modal = document.getElementById('modalSubirDocumento');
    const form = document.getElementById('formSubirDocumento');
    const closeBtn = document.querySelector('.cerrar');

    // Abre el modal y asigna el gestionId
    document.querySelectorAll('.añadirDocumento').forEach(button => {
        button.addEventListener('click', () => {
            const gestionId = button.getAttribute('data-id');
            document.getElementById('gestionId').value = gestionId;  // Asignar el ID de la gestión al campo oculto
            modal.style.display = 'block';
        });
    });

    // Cerrar el modal
    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Enviar el formulario con el archivo
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Prueba básica para verificar si el archivo PHP responde
        try {
            const testResponse = await fetch('backend/crud/subir_documento.php', {
                method: 'POST',
            });

            if (!testResponse.ok) {
                alert('El archivo PHP no se encuentra o no responde correctamente');
                return;
            }

            const testResult = await testResponse.json();
            if (testResult.success) {
                alert(`Prueba exitosa: ${testResult.message}`);
            } else {
                alert('El archivo PHP respondió, pero hubo un error inesperado.');
            }
        } catch (error) {
            alert('Error en la conexión al servidor: ' + error.message);
            return;
        }

        // Si la prueba básica pasa, continúa con el envío real
        const formData = new FormData(form);
        try {
            const response = await fetch('backend/crud/subir_documento.php', {
                method: 'POST',
                body: formData,
            });
            const result = await response.json();

            if (result.success) {
                alert('Documento subido con éxito');
                location.reload();
            } else {
                alert('Error al subir el documento');
            }
        } catch (error) {
            alert('Error en la conexión al servidor');
        }
    });
}


export function eliminarDocumento(){
    document.querySelectorAll('.eliminarDocumento').forEach(button => {
        button.addEventListener('click', function() {
            const documentoId = this.getAttribute('data-id');
            // Confirmar la eliminación
            if (confirm('¿Estás seguro de que deseas eliminar este documento?')) {
                fetch('backend/crud/eliminar_documento.php?documento_id=' + documentoId, {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        // Eliminar la fila del documento de la tabla (si todo sale bien)
                        this.closest('tr').remove();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    alert('Error al eliminar el documento');
                });
            }
        });
    });
    
}