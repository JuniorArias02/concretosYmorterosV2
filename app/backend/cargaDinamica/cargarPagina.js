import { iniciarFuncionesMenu } from "../../content/resources/js/menuAnimacion/menuMain.js";

fetch("content/view/menu.php")
    .then(response => response.text())
    .then(data => {
        const menuContenedor = document.querySelector(".contenedor_menu");
        if (menuContenedor) {
            menuContenedor.innerHTML = data;

            cargarScript(["backend/cargaDinamica/menuEventos.js"]);
            iniciarFuncionesMenu();
        } else {
            throw new Error("El contenedor del menú no fue encontrado.");
        }
    })

fetch("content/view/inicio.html")
    .then(response => response.text())
    .then(data => {
        const contenido = document.querySelector(".contenido");
        if (contenido) {
            contenido.innerHTML = data;
        } else {
            throw new Error("El contenedor del menú no fue encontrado.");
        }
    })


fetch("content/view/piePagina.html")
    .then(response => response.text())
    .then(data => {
        const contenido = document.querySelector(".piePagina");
        if (contenido) {
            contenido.innerHTML = data;
        } else {
            throw new Error("El contenedor del menú no fue encontrado.");
        }
    })

const cargarScript = (src) => {
    return new Promise((resolve, reject) => {
        const script = document.createElement('script');
        script.type = 'module'; // Especificamos que es un módulo
        script.src = src;
        script.onload = resolve;
        script.onerror = reject;
        document.body.appendChild(script);
    });
};
