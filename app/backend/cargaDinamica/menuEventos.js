// import { abrirMenu } from "../../content/resources/js/menuAnimacion/menuAnimacion.js";
import { efectoProcesos,abrirFormularioAgregar, eliminarDocumento } from "../../content/resources/js/procesos/procesosContenido.js";
import { agregarDocumento,  } from "../documentos/documentoLogica.js";
import { cerrarMenu } from "../../content/resources/js/menuAnimacion/menuAnimacion.js";


let paginaActual = '';
export const CONTENIDO_DINAMICO = document.getElementById("contenidoDinamico");
const cargarStyles = (urls, isPaginado = false) => {
  const promises = urls.map(url => {
    return new Promise((resolve, reject) => {
      const link = document.createElement('link');
      link.rel = 'stylesheet';
      link.href = url;
      link.onload = resolve;
      link.onerror = reject;
      if (isPaginado) {
        link.classList.add('paginado-dinamico');
      }
      document.head.appendChild(link);
    });
  });

  return Promise.all(promises); // Espera que todas las hojas de estilo se carguen
};

const cargarHTML = async (url) => {
  const response = await fetch(url);
  if (response.ok) {
    return await response.text();
  } else {
    throw new Error(`Error al cargar la página: ${url}`);
  }
};

const CARGAR_PAGINA = async (pageUrl, styles = [], linkUrl, forceLoad = false) => {
cerrarMenu();
  paginaActual = pageUrl;

  borrarRecursosCargados();
  removerContenidoDinamico();

  if (styles.length > 0) {
    try {
      // Aquí se debe llamar a la función cargarStyles, no cargarStyle
      await cargarStyles(styles, true); // True si quieres aplicar la clase 'paginado-dinamico'
    } catch (err) {
      console.error("Error cargando los estilos:", err);
    }
  }

  try {
    const htmlContent = await cargarHTML(pageUrl);
    CONTENIDO_DINAMICO.innerHTML = htmlContent;
  } catch (err) {
    console.error("Error cargando el HTML:", err);
    return;
  }

  // abrirMenu();  // Asegúrate de definir esta función si es necesario
  console.log(linkUrl);
  inicializarEventosPaginados(linkUrl); // Inicializa eventos para la paginación
};

function inicializarEventosPaginados(page) {
  const id_page = page;

  if (!isNaN(id_page)) {
    efectoProcesos();
    abrirFormularioAgregar();
    // agregarDocumento();
    eliminarDocumento();
  }

}


const borrarRecursosCargados = () => {
  const styles = document.querySelectorAll("link.paginado-dinamico"); // Solo eliminar los de paginado
  styles.forEach(style => style.remove());
};

const removerContenidoDinamico = () => {
  CONTENIDO_DINAMICO.innerHTML = "";
};

const menuLinks = document.querySelectorAll(".content_items_link");
menuLinks.forEach(link => {
  link.addEventListener("click", (e) => {
    e.preventDefault();
    const page = link.getAttribute("data-page");

    // if (!isNaN(page)) { // Es un ID de proceso
    //       CARGAR_PAGINA(
    //         "content/page/procesos/procesos-contenido1.php",
    //         ["content/resources/css/procesosContenido.css"],
    //         page)
    // }

    switch (page) {
      case "inicio":
        CARGAR_PAGINA("content/view/inicio.html", ["content/resources/css/inicio.css"], "inicio");
        break;
      case "workspace-gestion-produccion":
        CARGAR_PAGINA("content/page/workspace-gestion-produccion.html", ["content/resources/css/workspace.css"], "workspace-produccion");
        break;
      case "workspace-gestion-integral":
        CARGAR_PAGINA("content/page/workspace-gestion-integral.html", ["content/resources/css/workspace.css"], "workspace-gestion-integral");
        break;
      case "workspace-gestion-administrativa":
        CARGAR_PAGINA("content/page/workspace-gestion-administrativa.html", ["content/resources/css/workspace.css"], "workspace-gestion-integral");
        break;
      case "workspace-gestion-comercial":
        CARGAR_PAGINA("content/page/workspace-gestion-comercial.html", ["content/resources/css/workspace.css"], "workspace-gestion-integral");
        break;
      case "informes-gestion-produccion":
        CARGAR_PAGINA("content/page/informes-gestion-produccion.html", ["content/resources/css/workspace.css"], "workspace-gestion-integral");
        break;
      case "1":
        CARGAR_PAGINA(
          "content/process/procesos-contenido1.php",
          ["content/resources/css/procesosContenido.css","content/resources/css/subirDocumento.css"],
          page
        );
        break;
      case "2":
        CARGAR_PAGINA(
          "content/process/procesos-contenido2.php",
          ["content/resources/css/procesosContenido.css","content/resources/css/subirDocumento.css"],
          page
        );
        break;
      case "3":
        CARGAR_PAGINA(
          "content/process/procesos-contenido3.php",
          ["content/resources/css/procesosContenido.css","content/resources/css/subirDocumento.css"],
          page
        );
        break;
      case "4":
        CARGAR_PAGINA(
          "content/process/procesos-contenido4.php",
          ["content/resources/css/procesosContenido.css","content/resources/css/subirDocumento.css"],
          page
        );
        break;
      case "5":
        CARGAR_PAGINA(
          "content/process/procesos-contenido5.php",
          ["content/resources/css/procesosContenido.css","content/resources/css/subirDocumento.css"],
          page
        );
        break;
      case "6":
        CARGAR_PAGINA(
          "content/process/procesos-contenido6.php",
          ["content/resources/css/procesosContenido.css","content/resources/css/subirDocumento.css"],
          page
        );
        break;
      case "7":
        CARGAR_PAGINA(
          "content/process/procesos-contenido7.php",
          ["content/resources/css/procesosContenido.css","content/resources/css/subirDocumento.css"],
          page
        );
        break;
      default:
        CARGAR_PAGINA("content/view/Error404.html", ["content/resources/css/ventanaEfect.css", "content/resources/css/error404.css"]);
    }
  });
});
