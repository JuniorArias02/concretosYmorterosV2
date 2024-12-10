<?php
include("app/backend/conexion/conexion.php");
include("app/backend/queries/roles.php");
// include("app/backend/queries/login.php");

$roles = getRoles($conexion);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- api de google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <!-- cargar estilos -->
    <link rel="stylesheet" href="app/content/resources/css/index.css">
    <title>concretos y morteros</title>
</head>

<body>
    <div class="app">
        <div class="encabezado">
            <img src="app/content/resources/img/bannerArriba.svg" alt="" srcset="">
        </div>
        <div class="contenido">
            <form id="loginForm" method="POST">
                <div class="form_logo">
                    <img src="app/content/resources/img/co.png" alt="Logo">
                </div>

                <div class="form_campos">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Clave:</label>
                    <input type="password" id="password" name="password" required>

                    <label for="role">Rol:</label>
                    <select id="role" name="role" required>
                        <?php if (!empty($roles)): ?>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role['id']; ?>">
                                    <?php echo htmlspecialchars($role['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No hay roles disponibles</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form_boton">
                    <button type="submit">Iniciar sesión</button>
                </div>
            </form>
        </div>
        <div class="pie">
            <img src="app/content/resources/img/bannerAbajo.svg" alt="">
        </div>
    </div>
    <script>
        const loginForm = document.getElementById('loginForm');
        loginForm.addEventListener('submit', async (event) => {
            event.preventDefault(); 

            const formData = new FormData(loginForm);

            try {
                const response = await fetch('app/backend/queries/login.php', {
                    method: 'POST', 
                    body: formData 
                });

                const result = await response.json(); 

                if (result.success) {
                    alert(result.message);
                    window.location = 'app/main.php'; 
                } else {
                    alert(result.message); 
                }
            } catch (error) {
                console.error("Error al iniciar sesión:", error);
                alert("Error en el servidor."); 
            }
        });
    </script>
</body>

</html>