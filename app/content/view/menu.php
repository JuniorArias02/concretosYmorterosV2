<div class="menu">
    <div class="menuToggle">
        <span class="material-symbols-outlined menuOpcion">
            menu
        </span>
    </div>
    <div class="menu_contenido">

        <div class="menu-item_content" data-section="inicio">
            <h2 class="title-items">Inicio
                <span class="material-symbols-outlined arrow-item">
                    keyboard_arrow_down
                </span>
            </h2>
            <div class="content_items">
                <a href="#" class="content_items_link" data-page="inicio">Inicio</a>
            </div>
        </div>
        <div class="menu-item_content" data-section="procesos">
            <h2 class="title-items">Procesos
                <span class="material-symbols-outlined arrow-item">
                    keyboard_arrow_down
                </span>
            </h2>
            <div class="content_items">
                <?php
                include '../../backend/conexion/conexion.php'; // Incluimos el archivo de conexión a la base de datos

                // Consulta para obtener todos los procesos
                $query = "SELECT id, nombre FROM procesos";
                $result = $conexion->query($query);

                if ($result->num_rows > 0) {
                    // Si hay resultados, generamos los enlaces
                    while ($row = $result->fetch_assoc()) {
                        echo '<a href="#" class="content_items_link" data-page="' . $row['id'] . '">' . $row['nombre'] . '</a>';
                    }
                } else {
                    // Si no hay procesos
                    echo '<p>No hay procesos disponibles.</p>';
                }
                ?>
            </div>
        </div>

        <div class="menu-item_content" data-section="workspace">
            <h2 class="title-items">Workspace
                <span class="material-symbols-outlined arrow-item">
                    keyboard_arrow_down
                </span>
            </h2>
            <div class="content_items">
                <a href="#" class="content_items_link" data-page="workspace-gestion-produccion">Producción</a>
                <a href="#" class="content_items_link" data-page="workspace-gestion-integral">Gestión Integral</a>
                <a href="#" class="content_items_link" data-page="workspace-gestion-administrativa">Gestión
                    Administrativa</a>
                <a href="#" class="content_items_link" data-page="workspace-gestion-comercial">Gestión Comercial</a>
            </div>
        </div>

        <div class="menu-item_content" data-section="informes">
            <h2 class="title-items">Informes
                <span class="material-symbols-outlined arrow-item">
                    keyboard_arrow_down
                </span>
            </h2>
            <div class="content_items">
                <a href="#" class="content_items_link" data-page="informes-gestion-produccion">Gestión de la Producción</a>
            </div>
        </div>

        <div class="menu-item_content" data-section="perfil">
            <h2 class="title-items">Perfil
                <span class="material-symbols-outlined arrow-item">
                    keyboard_arrow_down
                </span>
            </h2>
            <div class="content_items">
                <a href="#" class="content_items_link" data-page="perfil">Perfil</a>
            </div>
        </div>

    </div>
</div>


<form id="autoForm" method="post" action="content/page/procesos-contenido.php" style="display: none;">
    <input type="hidden" name="processItemId" id="processItemId">
</form>