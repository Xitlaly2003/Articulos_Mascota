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

    <!-- VISTA DE REGISTRO -->
    <div id="registerView">
        <h2>Registro</h2>
        <form id="registerForm" action="register_process.php" method="POST">
            <input type="email" id="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" id="password" name="password" placeholder="Contraseña" required>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" required>
            <select id="registerRole" name="role" required>
                <option value="1">Admin</option>
                <option value="2">Usuario</option>
            </select>
            <button type="submit">Registrar</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>

</body>
</html>