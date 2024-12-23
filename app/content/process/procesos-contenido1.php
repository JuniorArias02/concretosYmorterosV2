<style>
    /* Estilos para el modal */
    .modal {
        display: none;
        /* Oculto por defecto */
        position: fixed;
        /* Fijo en la pantalla */
        z-index: 1000;
        /* Sobre otros elementos */
        left: 0;
        top: 0;
        width: 100%;
        /* Ancho completo */
        height: 100%;
        /* Alto completo */
        overflow: auto;
        /* Scroll si es necesario */
        background-color: rgba(0, 0, 0, 0.5);
        /* Fondo semi-transparente */
    }

    /* Contenido del modal */
    .modal-contenido {
        background-color: #fff;
        /* Fondo blanco */
        margin: 10% auto;
        /* Centrado vertical y horizontal */
        padding: 20px;
        /* Espaciado interno */
        border: 1px solid #888;
        /* Borde */
        border-radius: 8px;
        /* Bordes redondeados */
        width: 50%;
        /* Ancho del modal */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Sombra */
        animation: aparecer 0.3s ease-out;
        /* Animación */
    }

    /* Botón para cerrar el modal */
    .cerrar {
        color: #aaa;
        /* Color gris */
        float: right;
        /* Alineado a la derecha */
        font-size: 28px;
        /* Tamaño grande */
        font-weight: bold;
        /* Negrita */
        cursor: pointer;
        /* Manito al pasar */
    }

    .cerrar:hover,
    .cerrar:focus {
        color: #000;
        /* Cambiar color al pasar */
        text-decoration: none;
        /* Sin subrayado */
    }

    /* Título del modal */
    .modal-contenido h2 {
        margin-top: 0;
        /* Sin margen superior */
        font-size: 24px;
        /* Tamaño del título */
        color: #333;
        /* Color del texto */
    }

    /* Estilos del formulario */
    form {
        display: flex;
        flex-direction: column;
        /* Apilar elementos */
        gap: 10px;
        /* Separación entre campos */
    }

    label {
        font-weight: bold;
        /* Etiquetas en negrita */
        color: #555;
        /* Color gris oscuro */
    }

    input[type="text"],
    input[type="file"] {
        padding: 10px;
        /* Espaciado interno */
        border: 1px solid #ccc;
        /* Borde gris */
        border-radius: 4px;
        /* Bordes redondeados */
        font-size: 14px;
        /* Tamaño del texto */
    }

    button[type="submit"] {
        background-color: #007bff;
        /* Azul */
        color: white;
        /* Texto blanco */
        border: none;
        /* Sin borde */
        padding: 10px 15px;
        /* Espaciado */
        border-radius: 4px;
        /* Bordes redondeados */
        font-size: 16px;
        /* Tamaño del texto */
        cursor: pointer;
        /* Manito al pasar */
        transition: background-color 0.3s ease;
        /* Animación de color */
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
        /* Azul más oscuro */
    }

    /* Animación de entrada */
    @keyframes aparecer {
        from {
            opacity: 0;
            /* Invisible */
            transform: scale(0.9);
            /* Más pequeño */
        }

        to {
            opacity: 1;
            /* Visible */
            transform: scale(1);
            /* Tamaño normal */
        }
    }
</style>
<?php
include("../../backend/conexion/conexion.php");

$procesoId = 1; // ID del proceso a cargar

// Consultar el nombre del proceso
$consultaProceso = $conexion->prepare("
    SELECT nombre 
    FROM procesos 
    WHERE id = ?
");
$consultaProceso->bind_param("i", $procesoId);
$consultaProceso->execute();
$resultadoProceso = $consultaProceso->get_result();
$proceso = $resultadoProceso->fetch_assoc();
$nombreProceso = $proceso ? $proceso['nombre'] : 'Proceso no encontrado';

// Consultar las gestiones del proceso
$consultaGestiones = $conexion->prepare("
    SELECT 
        gestiones.id AS gestion_id, 
        gestiones.tipo AS gestion_tipo
    FROM 
        gestiones
    INNER JOIN 
        procesos ON gestiones.id_proceso = procesos.id
    WHERE 
        procesos.id = ?
");
$consultaGestiones->bind_param("i", $procesoId);
$consultaGestiones->execute();
$resultadoGestiones = $consultaGestiones->get_result();

// Construcción del HTML dinámico
echo '<div class="contenedorProcesos">';
echo '<div class="procesoEncabezado">
        <div class="procesosEncabezado_titulo">
            <h1>' . htmlspecialchars($nombreProceso) . '</h1>
        </div>
      </div>';
echo '<div class="procesosCuerpo">';

while ($gestion = $resultadoGestiones->fetch_assoc()) {
    $gestionId = $gestion['gestion_id'];
    $gestionTipo = strtoupper($gestion['gestion_tipo']);

    echo '<div class="gestionesBox">';
    echo '<div class="gestiones_titulo">';
    echo '<h2 class="gestiones-tipo">' . htmlspecialchars($gestionTipo) . '</h2>';
    echo '<span class="material-symbols-outlined row">keyboard_arrow_down</span>';
    echo '<button class="añadirDocumento" data-id="' . htmlspecialchars($gestionId) . '">
            <span class="material-symbols-outlined">add_notes</span>
          </button>';
    echo '</div>';
    echo '<div class="gestionesContenido">';
    echo '<table class="tabla-documentos">';
    echo '<thead><tr><th>Documento</th><th>Acción</th></tr></thead>';
    echo '<tbody>';

    // Consultar los documentos de la gestión
    $consultaDocumentos = $conexion->prepare("
        SELECT 
            documentos.id AS documento_id, 
            documentos.nombre AS documento_nombre
        FROM 
            documentos
        WHERE 
            documentos.id_gestion = ?
    ");
    $consultaDocumentos->bind_param("i", $gestionId);
    $consultaDocumentos->execute();
    $resultadoDocumentos = $consultaDocumentos->get_result();

    while ($documento = $resultadoDocumentos->fetch_assoc()) {
        $documentoId = $documento['documento_id'];
        $documentoNombre = $documento['documento_nombre'];

        echo '<tr>';
        echo '<td><a href="backend/queries/descargar_documento.php?id=' . htmlspecialchars($documentoId) . '" download="' . htmlspecialchars($documentoNombre) . '">' . htmlspecialchars($documentoNombre) . '</a></td>';

        echo '<td><button class="eliminarDocumento" data-id="' . htmlspecialchars($documentoId) . '">
        <span class="material-symbols-outlined">delete</span>
    </button></td>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>'; // Fin de gestionesContenido
    echo '</div>'; // Fin de gestionesBox
}

echo '</div>'; // Fin de procesosCuerpo
echo '</div>'; // Fin de contenedorProcesos
?>

<div id="modalSubirDocumento" class="modal" style="display: none; z-index: 1000;">
    <div class="modal-contenido">
        <span class="cerrar">&times;</span>
        <h2>Subir Documento</h2>
        <form id="formSubirDocumento" enctype="multipart/form-data">
            <input type="hidden" id="gestionId" name="gestion_id">
            <label for="nombreDocumento">Nombre del documento:</label>
            <input type="text" id="nombreDocumento" name="nombre" required>
            <label for="archivoDocumento">Seleccionar archivo:</label>
            <input type="file" id="archivoDocumento" name="archivo" required>
            <button type="submit">Subir</button>
        </form>
    </div>
</div>