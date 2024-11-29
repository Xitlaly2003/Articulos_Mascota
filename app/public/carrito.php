<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit();
}

// Obtener carrito desde la sesión
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #343a40;
            color: white;
        }

        .header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        .card,
        .table-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .card-title,
        .table-custom th,
        .table-custom td {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
        }

        .btn-primary,
        .btn-danger,
        .btn-secondary,
        .btn-success {
            border-radius: 20px;
        }

        .form-select {
            border-radius: 20px;
        }

        .cantidad-input {
            border-radius: 10px;
        }

        .container {
            max-width: 1200px;
        }

        .table-custom th,
        .table-custom td {
            vertical-align: middle;
        }

        .table-custom td,
        .table-custom th {
            padding: 15px;
        }

        .table-custom .btn-danger {
            border-radius: 20px;
        }

        /* Estilo de la alerta */
        .alert-warning {
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="header">
        <h1>Carrito de compras</h1>
        <a class="btn btn-danger" href="auth/logout.php">Cerrar Sesión</a>
    </div>

    <div class="container mt-5">
        <h1 class="text-center mb-4">
            Carrito
            <a href="historial.php" class="ms-3 text-decoration-none text-secondary">
                Historial
            </a>
        </h1>

        <?php if (!empty($carrito)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Artículo</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalGeneral = 0;
                    foreach ($carrito as $index => $item):
                        $totalArticulo = $item['precio_venta'] * $item['cantidad'];
                        $totalGeneral += $totalArticulo;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nombre']); ?></td>
                            <td class="text-center">$<?= number_format($item['precio_venta'], 2); ?></td>
                            <td class="text-center"><?= htmlspecialchars($item['cantidad']); ?></td>
                            <td class="text-center">$<?= number_format($totalArticulo, 2); ?></td>
                            <td class="text-center">
                                <form action="../controllers/Carrito/eliminar.php" method="post">
                                    <input type="hidden" name="index" value="<?= $index; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total General:</td>
                        <td class="text-center fw-bold">$<?= number_format($totalGeneral, 2); ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end">
                <a href="client_home.php" class="btn btn-secondary">Volver</a>
                <a href="../../app/controllers/Carrito/comprar.php" class="btn btn-success">Pagar</a>
            </div>
        <?php else: ?>
            <div class="text-center">
                Tu carrito está vacío. <a href="client_home.php" class="alert-link">Empieza a comprar ahora</a>.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
if (isset($_GET['compra']) && $_GET['compra'] == 'exitosa') {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: '¡Compra exitosa!',
            text: 'Tu compra ha sido procesada con éxito.',
            confirmButtonText: 'Aceptar'
        });
    </script>";
}
?>