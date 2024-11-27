<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artículos para Mascotas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../index.css">
</head>
<body>

    <!-- VISTA DE INICIO DE SESIÓN -->
    <div id="loginView">
        <h2>Iniciar Sesión</h2>
        <form id="loginForm" action="login_process.php" method="POST">
            <input type="email" id="loginEmail" name="email" placeholder="Correo electrónico" required>
            <input type="password" id="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar sesión</button>
        </form>
        <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
    </div>

</body>
</html>
