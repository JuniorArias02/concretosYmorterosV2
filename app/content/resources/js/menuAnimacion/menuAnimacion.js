
export function abrirMenu() {
    const cerrado = "menu";
    const abierto = "close";
    const menuToggle = document.querySelector('.menuToggle');
    const menuBoton = document.querySelector('.menuOpcion');
    const menu = document.querySelector('.menu');
    const menu_contenido = document.querySelector('.menu_contenido');


    menuBoton.addEventListener('click', () => {
        console.log("Estado del menú de click: " + menuBoton.textContent);
        if (menuBoton.textContent === cerrado) {
            console.log("Menú abierto");
            menuBoton.textContent = abierto;
            extenderMenu();
        } else {
            console.log("Menú cerrado");
            menuBoton.textContent = cerrado;
            minimizarMenu();
        }
    });

    function extenderMenu() {
        menu.classList.add("menuAbierto");
        menuToggle.classList.add('menuToggleAbierto');
        menuBoton.classList.add('menuOpcionTrasladar');
        menu_contenido.classList.add('menu_contenidoAbierto');
    }

    function minimizarMenu() {
        menu.classList.remove("menuAbierto");
        menuToggle.classList.remove('menuToggleAbierto');
        menuBoton.classList.remove('menuOpcionTrasladar');
        menu_contenido.classList.remove('menu_contenidoAbierto');
    }

    
    const items = document.querySelectorAll('.title-items');

    items.forEach(item => {
        item.addEventListener('click', () => {
            const content = item.nextElementSibling;
            if (content.style.display === "flex") {
                content.style.display = "none";
            } else {
                content.style.display = "flex";
                content.style.flexDirection = "column";
                content.style.alignItems = "center";
            }
            const arrow = item.querySelector('.arrow-item');
            if (content.style.display === "flex") {
                arrow.textContent = 'keyboard_arrow_up';  
            } else {
                arrow.textContent = 'keyboard_arrow_down';
            }
        });
    });



}

