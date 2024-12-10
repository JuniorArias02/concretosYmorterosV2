
<style>
    .subventana {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 500px;
        background: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        padding: 20px;
        z-index: 1000;
    }

    #formularioDocumento {
        text-align: center;
    }

    #formularioDocumento h2 {
        margin-bottom: 20px;
        font-size: 1.8rem;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #555;
    }

    .form-group input[type="text"],
    .form-group input[type="file"] {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        transition: border-color 0.3s;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="file"]:focus {
        border-color: #007bff;
        outline: none;
    }

    button[type="submit"] {
        background: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button[type="submit"]:hover {
        background: #0056b3;
    }

    /* Fondo oscuro detrás de la subventana */
    .subventana::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }
</style>

<div class="subventana" style="display: none;">
    <div id="formularioDocumento">
        <h2>Agregar Documento</h2>
        <form id="formAgregarDocumento" enctype="multipart/form-data">
        
            <input type="hidden" id="id_gestion" name="id_gestion" required>
            
            <div class="form-group">
                <label for="nombre">Nombre del Documento:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="contenido">Archivo:</label>
                <input type="file" id="contenido" name="contenido" required>
            </div>
            <button type="submit">Agregar Documento</button>
        </form>
    </div>
</div>
