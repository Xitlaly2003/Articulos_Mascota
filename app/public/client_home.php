<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
        }

        .btn-primary,
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
    </style>
</head>

<body>
    <div class="header">
        <h1>Catálogo de Productos</h1>
        <a class="btn btn-danger" href="auth/logout.php">Cerrar Sesión</a>
    </div>

    <div class="container mt-4">
        <!-- Selector de categorías -->
        <div class="row mb-4">
            <form method="GET" class="d-flex justify-content-center">
                <a href="carrito.php" class="btn btn-outline-secondary me-3 d-flex align-items-center">
                    <i class="bi bi-cart-fill"></i> <!-- Ícono del carrito -->
                </a>
                <select name="categoria" class="form-select w-50 me-3">
                    <option value="">Selecciona una categoría</option>
                    <?php
                    require_once '../config/database.php';
                    $categorias = $conn->query("SELECT * FROM categoria WHERE estado = 1");
                    while ($categoria = $categorias->fetch_assoc()) {
                        echo "<option value='{$categoria['idcategoria']}'>{$categoria['nombre']}</option>";
                    }
                    ?>
                </select>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div>

        <!-- Lista de artículos -->
        <div class="row">
            <?php
            if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
                $idCategoria = intval($_GET['categoria']);
                $articulos = $conn->query("SELECT * FROM articulo WHERE idcategoria = $idCategoria AND estado = 1");

                if ($articulos->num_rows > 0) {
                    while ($articulo = $articulos->fetch_assoc()) {
                        echo "
                        <div class='col-md-4 mb-4'>
                            <div class='card'>
                                <div class='card-header bg-light'>
                                    <h5 class='card-title text-center'>{$articulo['nombre']}</h5>
                                </div>
                                <div class='card-body'>
                                    <p class='text-muted text-center'>{$articulo['descripcion']}</p>
                                    <p class='text-center'><strong>Precio:</strong> \${$articulo['precio_venta']}</p>
                                    <p class='text-center'><strong>Stock disponible:</strong> {$articulo['stock']}</p>
                                    <form method='POST' action='../controllers/carrito/agregar_al_carrito.php' class='text-center'>
                                        <input type='hidden' name='idarticulo' value='{$articulo['idarticulo']}'>
                                        <input type='hidden' name='stock' value='{$articulo['stock']}'>
                                        <div class='mb-3'>
                                            <input type='number' name='cantidad' class='form-control cantidad-input' placeholder='Cantidad' min='1' max='{$articulo['stock']}' required>
                                        </div>
                                        <button type='submit' class='btn btn-success w-100'>Añadir al Carrito <i class='fas fa-cart-plus'></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        ";
                    }
                } else {
                    echo "
                    <div class='col-12'>
                        <p class='text-center text-danger'>No hay artículos disponibles en esta categoría.</p>
                    </div>
                    ";
                }
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>