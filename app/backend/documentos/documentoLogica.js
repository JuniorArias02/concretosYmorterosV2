export function agregarDocumento(){
    document.addEventListener("click", async (e) => {
        if (e.target.closest(".añadirDocumento")) {
            const idGestion = e.target.closest(".gestionesBox").dataset.gestionId;
            const nombreDocumento = prompt("Ingrese el nombre del documento:");
    
            if (nombreDocumento) {
                const response = await fetch("../crud/agregar_documento.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id_gestion: idGestion, nombre_documento: nombreDocumento })
                });
    
                const result = await response.json();
                alert(result.message);
                if (result.success) location.reload(); // Recargar para actualizar la tabla
            }
        }
    });
    
}

export function eliminarDocumento(){
    document.addEventListener("click", async (e) => {
        if (e.target.closest(".eliminarDocumento")) {
            const idDocumento = e.target.closest(".eliminarDocumento").dataset.id;
    
            if (confirm("¿Seguro que quieres eliminar este documento?")) {
                const response = await fetch("../crud/eliminar_documento.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id_documento: idDocumento })
                });
    
                const result = await response.json();
                alert(result.message);
                if (result.success) location.reload(); // Recargar para actualizar la tabla
            }
        }
    });    
}



export function formularioAgregarDocumentp(){
    document.getElementById("formAgregarDocumento").addEventListener("submit", async (e) => {
        e.preventDefault(); // Prevenir el envío estándar
    
        const formData = new FormData(e.target); // Crear objeto FormData con los datos del formulario
    
        try {
            const response = await fetch("../crud/procesar_documento.php", {
                method: "POST",
                body: formData,
            });
    
            const result = await response.json();
            alert(result.message);
    
            if (result.success) {
                // Lógica adicional, como cerrar la ventana modal
                console.log("Documento agregado correctamente");
            }
        } catch (error) {
            console.error("Error al procesar el formulario:", error);
            alert("Ocurrió un error. Intenta nuevamente.");
        }
    });
    
}