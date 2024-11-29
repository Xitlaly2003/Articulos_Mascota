<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit();
}

require_once '../controllers/Articulos/obtener_articulos.php';
require_once '../controllers/Categorias/obtener_categorias.php';
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
        <div style="text-align: center;">
            <h1>Artículos</h1>
            <a class="btn btn-danger ms-1" href="auth/logout.php">Cerrar Sesión</a>

            <form id="articuloForm" action="../controllers/Articulos/crear_articulo.php" method="POST">
                <select id="categoria" name="idcategoria" required>
                    <option value="" disabled selected>Selecciona una categoría</option>
                    <?php

                    $categorias = obtenerCategorias($conn);

                    while ($categoria = $categorias->fetch_assoc()) {
                        echo "<option value='{$categoria['idcategoria']}'>{$categoria['nombre']}</option>";
                    }
                    ?>
                </select>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre del artículo" required>
                <input type="number" id="precio" name="precio" placeholder="Precio de venta" required>
                <input type="number" id="stock" name="stock" placeholder="Stock disponible" required>
                <textarea id="descripcion" name="descripcion" placeholder="Descripción"></textarea>
                <button type="submit">Guardar</button>
            </form>
        </div>
        <h2>Artículos Existentes</h2>
        <div id="articulosContainer">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $articulos = obtenerArticulos($conn);

                    if ($articulos->num_rows > 0) {
                        while ($articulo = $articulos->fetch_assoc()) {

                            $articuloJson = json_encode($articulo);

                            echo "
                        <tr>
                            <td>{$articulo['nombre']}</td>
                            <td>{$articulo['codigo']}</td>
                            <td>{$articulo['precio_venta']}</td>
                            <td>{$articulo['stock']}</td>
                            <td>{$articulo['descripcion']}</td>
                            <td>{$articulo['categoria']}</td>
                            <td>
                                <button class='btn btn-warning btn-sm' onclick='abrirModalEditar($articuloJson)'>Editar</button>
                                <button class='btn btn-danger btn-sm' onclick='eliminarArticulo({$articulo['idarticulo']})'>Eliminar</button>
                            </td>
                        </tr>
                    ";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No hay artículos registrados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Modal de Edición -->
        <div class="modal" id="modalEditar" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="../controllers/Articulos/actualizar_articulo.php" style="width: 100% !important;">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Artículo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idarticulo" name="idarticulo">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nuevo nombre" required><br>
                            <input type="number" class="form-control" id="precio" name="precio" step="0.1" placeholder="Nuevo precio" required><br>
                            <input type="number" class="form-control" id="stock" name="stock" placeholder="Nuevo stock" required><br>
                            <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Nueva descripción" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" style="background-color: #c790c3;">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Función para eliminar artículo
            function eliminarArticulo(idarticulo) {
                if (confirm("¿Estás seguro de que deseas eliminar este artículo?")) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '../controllers/Articulos/eliminar_articulo.php';

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'idarticulo';
                    input.value = idarticulo;

                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                }
            }

            // Función para abrir el modal y cargar los datos del artículo
            function abrirModalEditar(articulo) {
                // Asignar los valores a los campos del formulario en el modal
                document.getElementById('idarticulo').value = articulo.idarticulo;
                document.getElementById('nombre').value = articulo.nombre;
                document.getElementById('precio').value = parseFloat(articulo.precio_venta).toFixed(2);
                document.getElementById('stock').value = parseInt(articulo.stock);
                document.getElementById('descripcion').value = articulo.descripcion;
                console.log(articulo.nombre);

                // Mostrar el modal
                const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
                modal.show();
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'eliminado') {
    echo "<script>
        Swal.fire({
            title: 'Eliminación exitosa!',
            text: 'Se elimino el articulo correctamente.',
            confirmButtonText: 'Aceptar'
        });
    </script>";
}

if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'editado') {
    echo "<script>
        Swal.fire({
            title: 'Actualización exitosa!',
            text: 'Se actualizo el articulo correctamente.',
            confirmButtonText: 'Aceptar'
        });
    </script>";
}
?>
