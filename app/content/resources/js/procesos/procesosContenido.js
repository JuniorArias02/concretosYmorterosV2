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
    // Selecciona todos los botones de añadirDocumento
    const botonesAñadirDocumento = document.querySelectorAll('.añadirDocumento');

    // Agrega un evento de clic a cada botón
    botonesAñadirDocumento.forEach((boton) => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();

            // Obtiene el id_gestion del botón
            const idGestion = boton.getAttribute('data-id');

            // Abre la subventana (asegúrate de que la subventana esté oculta inicialmente)
            const subventana = document.querySelector('.subventana');
            subventana.style.display = 'block';

            // Inserta el id_gestion en el campo del formulario
            const inputIdGestion = document.querySelector('#formAgregarDocumento #id_gestion');
            inputIdGestion.value = idGestion;
        });
    });

    // Opcional: Cerrar la subventana al hacer clic fuera o en un botón "Cerrar"
    document.querySelector('.subventana').addEventListener('click', (e) => {
        if (e.target.classList.contains('subventana')) {
            e.target.style.display = 'none';
        }
    });

}