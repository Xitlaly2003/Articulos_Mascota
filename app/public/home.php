<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit();
}

// Obtener datos del usuario desde la sesión
$nombre = $_SESSION['usuario'];
$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articulos para Mascotas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    
    <!-- VISTA DEL CRUD DE ARTÍCULOS -->
    <div id="crudView">
        <h1>Artículos</h1>
        <button id="logoutButton" href="auth/logout.php">Cerrar sesión</button>
        <br>
        <form id="articuloForm">
            <input type="text" id="nombre" placeholder="Nombre del artículo" required>
            <input type="number" id="precio" placeholder="Precio de venta" required>
            <input type="number" id="stock" placeholder="Stock disponible" required>
            <textarea id="descripcion" placeholder="Descripción"></textarea>
            <button type="submit">Guardar</button>
        </form>
        <div id="articulosContainer"></div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
