<?php
require_once __DIR__ . '/../../config/database.php';

$idCategoria = $_GET['idcategoria'] ?? null;

if ($idCategoria) {
    $query = $conn->prepare("SELECT * FROM articulo WHERE idcategoria = ?");
    $query->bind_param('i', $idCategoria);
    $query->execute();
    $result = $query->get_result();

    $articulos = [];
    while ($row = $result->fetch_assoc()) {
        $articulos[] = $row;
    }

    echo json_encode($articulos);
} else {
    echo json_encode([]);
}
?>
