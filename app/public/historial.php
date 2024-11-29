<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit();
}

require_once '../controllers/Historial/historial.php';

// Obtener carrito desde la sesión
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
$idCliente = $_SESSION['idusuario'];
$historial = new historial();
$historialVentas = $historial->obtenerHistorial($idCliente);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
        }

        .header {
            text-align: center;
            padding: 40px 0;
            background-color: #343a40;
            color: white;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header a {
            color: white;
            font-size: 1.1rem;
            text-decoration: none;
            border-radius: 25px;
            padding: 10px 20px;
            background-color: #e74c3c;
            transition: background-color 0.3s ease;
        }

        .header a:hover {
            background-color: #c0392b;
        }

        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
            margin-bottom: 20px;
        }

        .card-custom .card-header {
            background-color: #1abc9c;
            color: white;
            padding: 20px;
            border-radius: 15px 15px 0 0;
        }

        .card-custom .card-body {
            padding: 20px;
            font-size: 1rem;
        }

        .card-custom .card-footer {
            background-color: #f0f2f5;
            border-radius: 0 0 15px 15px;
        }

        .btn-primary,
        .btn-danger,
        .btn-secondary,
        .btn-success {
            border-radius: 20px;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }

        .table-custom th,
        .table-custom td {
            vertical-align: middle;
            padding: 15px;
        }

        .list-group-item {
            background-color: #f9f9f9;
            border: none;
            margin-bottom: 10px;
            padding: 15px;
        }

        .table-custom {
            border: none;
            margin-top: 20px;
        }

        .alert-warning {
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="header">
        <h1>Historial de Compras</h1>
        <a href="auth/logout.php" class="btn">Cerrar Sesión</a>
    </div>

    <div class="container mt-5">
        <h1 class="text-center mb-4">
            <a href="carrito.php" class="ms-3 text-decoration-none text-secondary">
                Carrito
            </a>
            Historial
        </h1>

        <div class="row">
            <?php if (!empty($historialVentas)): ?>
                <?php foreach ($historialVentas as $venta): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card card-custom">
                            <div class="card-header">
                                <h5 class="card-title">Venta #<?= $venta['idventa']; ?></h5>
                                <p>Comprobante: <?= $venta['tipo_comprobante'] . " - " . $venta['serie_comprobante'] . $venta['num_comprobante']; ?></p>
                                <p>Fecha: <?= $venta['fecha_hora']; ?></p>
                                <p>Estado: <span class="badge bg-success"><?= $venta['estado']; ?></span></p>
                                <p><strong>Total: </strong>$<?= $venta['total']; ?> (Impuesto: $<?= $venta['impuesto']; ?>)</p>
                            </div>
                            <div class="card-body">
                                <h6>Artículos:</h6>
                                <ul class="list-group">
                                    <?php foreach ($venta['articulos'] as $articulo): ?>
                                        <li class="list-group-item">
                                            <strong>Artículo:</strong> <?= $articulo['nombre']; ?> <br>
                                            <strong>Cantidad:</strong> <?= $articulo['cantidad']; ?> <br>
                                            <strong>Precio Unitario:</strong> $<?= $articulo['precio']; ?> <br>
                                            <strong>Descuento:</strong> $<?= $articulo['descuento']; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="card-footer text-end">
                                <a href="../controllers/Historial/ticket.php?idventa=<?= $venta['idventa']; ?>" class="btn btn-primary">
                                    Descargar Ticket
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No tienes compras en tu historial.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>