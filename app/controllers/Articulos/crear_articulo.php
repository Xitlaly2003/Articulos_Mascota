<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar datos recibidos
    $idcategoria = $_POST['idcategoria'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $descripcion = $_POST['descripcion'];

    // Obtener las primeras dos letras de la categoría
    $query = "SELECT nombre FROM categoria WHERE idcategoria = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idcategoria);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $categoria = $result->fetch_assoc();
        $codigoBase = strtoupper(substr($categoria['nombre'], 0, 2)); // Primeras 2 letras en mayúsculas
    } else {
        die("Categoría no encontrada.");
    }

    // Verificar el próximo número disponible para el código
    $queryCodigo = "SELECT MAX(CAST(SUBSTRING(codigo, 3) AS UNSIGNED)) AS max_codigo 
                    FROM articulo 
                    WHERE idcategoria = ?";
    $stmt = $conn->prepare($queryCodigo);
    $stmt->bind_param("i", $idcategoria);
    $stmt->execute();
    $result = $stmt->get_result();

    $nextNumber = 1; // Por defecto, comienza con 1
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['max_codigo'] !== null) {
            $nextNumber = (int)$row['max_codigo'] + 1; // Incrementar el número más alto encontrado
        }
    }

    $codigo = $codigoBase . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    // Evitar inyecciones SQL y realizar la inserción
    $insertQuery = "
        INSERT INTO articulo (idcategoria, codigo, nombre, precio_venta, stock, descripcion, estado) 
        VALUES (?, ?, ?, ?, ?, ?, 1)
    ";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("issdis", $idcategoria, $codigo, $nombre, $precio, $stock, $descripcion);

    if ($stmt->execute()) {
        // Redirigir al CRUD con un mensaje de éxito
        header("Location: ../../public/home.php?mensaje=Artículo agregado con éxito");
        exit();
    } else {
        echo "Error al insertar artículo: " . $conn->error;
    }
}
?>
