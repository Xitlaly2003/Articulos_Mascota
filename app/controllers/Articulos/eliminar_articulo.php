<?php
require_once __DIR__ . '/../../config/database.php';

if (isset($_POST['idarticulo'])) {
    $idarticulo = $_POST['idarticulo'];

    // Consulta para eliminar el artículo
    $query = "DELETE FROM articulo WHERE idarticulo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idarticulo);

    if ($stmt->execute()) {
        // Redirigir con mensaje de éxito
        header("Location: ../../public/home.php?mensaje=eliminado");
    } else {
        echo "Error al eliminar artículo: " . $conn->error;
    }
    exit();
}
?>
