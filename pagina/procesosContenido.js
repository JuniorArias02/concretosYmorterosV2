
const gestionesBoxes = document.querySelectorAll(".gestionesBox")
gestionesBoxes.forEach(gestion => {
    const titulo = gestion.querySelector('.gestiones-tipo');
    const contenido = gestion.querySelector('.gestionesContenido');

    titulo.addEventListener('click', () => {
        contenido.classList.toggle('show'); // Alterna la clase 'show'
    });
});
