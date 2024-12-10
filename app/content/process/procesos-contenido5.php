<?php
include("../../backend/conexion/conexion.php");

include("../subVentana/agregarDocumento.php");


$procesoId = 5; // ID del proceso a cargar


try {
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
            echo '<td><a href="/ruta/documento/' . htmlspecialchars($documentoId) . '" download="' . htmlspecialchars($documentoNombre) . '">' . htmlspecialchars($documentoNombre) . '</a></td>';
            echo '<td><button class="eliminarDocumento" data-id="' . htmlspecialchars($documentoId) . '">
                    <span class="material-symbols-outlined">delete</span>
                  </button></td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>'; // Fin de gestionesContenido
        echo '</div>'; // Fin de gestionesBox
    }

    echo '</div>'; // Fin de procesosCuerpo
    echo '</div>'; // Fin de contenedorProcesos

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>

