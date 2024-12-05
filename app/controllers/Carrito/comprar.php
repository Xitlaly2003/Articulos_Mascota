<?php
session_start();
require_once '../../config/database.php'; // Conexión con mysqli

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit();
}

// Verificar si el carrito no está vacío
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
if (empty($carrito)) {
    $_SESSION['mensaje'] = "El carrito está vacío. No se puede procesar la compra.";
    header("Location: carrito.php");
    exit();
}
$conn->begin_transaction();

try {
    // Insertar en la tabla venta
    $idusuario = $_SESSION['idusuario']; // ID del usuario autenticado
    $idcliente = $idusuario; // Asumimos que el cliente es el usuario logueado
    $tipo_comprobante = "Factura"; // Tipo de comprobante
    $serie_comprobante = "F001"; // Serie de comprobante
    $num_comprobante = strval(rand(10000, 99999)); // Número aleatorio
    $fecha_hora = date("Y-m-d H:i:s"); // Generar la fecha y hora actual
    if (!preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $fecha_hora)) {
        throw new Exception("El formato de fecha y hora no es válido: $fecha_hora");
    }
    $impuesto = 0.18;
    $total = array_reduce($carrito, function ($sum, $item) {
        return $sum + ($item['precio_venta'] * $item['cantidad']);
    }, 0);

    // Insertar venta
    $stmtVenta = $conn->prepare("INSERT INTO venta (idcliente, idusuario, tipo_comprobante, serie_comprobante, num_comprobante, fecha_hora, impuesto, total, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmtVenta) {
        throw new Exception("Error al preparar la consulta de venta: " . $conn->error);
    }
    $estado = "Procesado"; // Estado de la venta
    $stmtVenta->bind_param("iissssdds", $idcliente, $idusuario, $tipo_comprobante, $serie_comprobante, $num_comprobante, $fecha_hora, $impuesto, $total, $estado);
    // Ejecutar y verificar errores
    if (!$stmtVenta->execute()) {
        throw new Exception("Error al ejecutar consulta de venta: " . $stmtVenta->error);
    }

    // Obtener el ID de la venta
    $idventa = $conn->insert_id;
    if ($idventa == 0) {
        throw new Exception("ID de la venta no generado. Verifica la configuración de la tabla venta.");
    }
    // Insertar detalles de la venta y actualizar stock
    $stmtDetalleVenta = $conn->prepare("INSERT INTO detalle_venta (idventa, idarticulo, cantidad, precio, descuento) VALUES (?, ?, ?, ?, ?)");
    if (!$stmtDetalleVenta) {
        throw new Exception("Error al preparar la consulta de detalle_venta: " . $conn->error);
    }
    $stmtActualizarStock = $conn->prepare("UPDATE articulo SET stock = stock - ? WHERE idarticulo = ?");
    if (!$stmtActualizarStock) {
        throw new Exception("Error al preparar la consulta de actualización de stock: " . $conn->error);
    }

    foreach ($_SESSION['carrito'] as $idArticulo => $articulo) {
        if (!isset($articulo['nombre'], $articulo['precio_venta'], $articulo['cantidad'])) {
            error_log("Error en los datos del carrito para el artículo ID: $idArticulo");
            die("Datos incompletos en el carrito. No se puede procesar la compra.");
        }

        $descuento = 0;
        +$stmtDetalleVenta->bind_param("iiidi", $idventa, $idArticulo, $articulo['cantidad'], $articulo['precio_venta'], $descuento);
        $stmtDetalleVenta->execute();

        $stmtActualizarStock->bind_param("ii", $articulo['cantidad'], $idArticulo);
        $stmtActualizarStock->execute();
    }

    // Confirmar transacción
    $conn->commit();
    $_SESSION['mensaje'] = "Compra procesada con éxito.";
    unset($_SESSION['carrito']); // Limpiar el carrito
    header("Location: ../../public/carrito.php?compra=exitosa");
} catch (Exception $e) {
    // Si ocurre un error, revertir la transacción
    $conn->rollback();
    $_SESSION['mensaje'] = "Ocurrió un error al procesar la compra.";
    header("Location: ../../public/carrito.php");
}
exit();
