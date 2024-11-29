<?php

require_once('../../libs/fpdf/fpdf.php');
require_once('historial.php');
require_once('../../config/database.php'); // Asegúrate de incluir correctamente la conexión

class ticket {
    public function generateTicket($idVenta) {
        global $conn;

        // Obtén los datos de la venta
        $historial = new historial();
        session_start(); // Asegúrate de que la sesión esté iniciada para obtener el ID de usuario
        $ventas = $historial->obtenerHistorial($_SESSION['idusuario']);

        if (!isset($ventas[$idVenta])) {
            die('Venta no encontrada');
        }

        $venta = $ventas[$idVenta];

        // Crear el PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10); // Márgenes
        $pdf->SetFont('Arial', 'B', 16);

        // Título del ticket
        $pdf->SetFillColor(40, 40, 40);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 10, utf8_decode("Ticket de Venta #{$venta['idventa']}"), 0, 1, 'C', true);
        $pdf->Ln(5);

        // Información general de la venta
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 10, utf8_decode("Fecha: {$venta['fecha_hora']}"), 0, 1);
        $pdf->Cell(0, 10, utf8_decode("Comprobante: {$venta['tipo_comprobante']} - {$venta['serie_comprobante']}{$venta['num_comprobante']}"), 0, 1);
        $pdf->Cell(0, 10, utf8_decode("Total: $ {$venta['total']} (Impuesto: $ {$venta['impuesto']})"), 0, 1);
        $pdf->Cell(0, 10, utf8_decode("Estado: {$venta['estado']}"), 0, 1);
        $pdf->Ln(10);

        // Encabezado de artículos
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(220, 220, 220); // Color de fondo
        $pdf->Cell(70, 10, utf8_decode("Artículo"), 1, 0, 'C', true);
        $pdf->Cell(30, 10, utf8_decode("Cantidad"), 1, 0, 'C', true);
        $pdf->Cell(30, 10, utf8_decode("Precio"), 1, 0, 'C', true);
        $pdf->Cell(30, 10, utf8_decode("Descuento"), 1, 0, 'C', true);
        $pdf->Cell(30, 10, utf8_decode("Subtotal"), 1, 1, 'C', true);

        // Listado de artículos
        $pdf->SetFont('Arial', '', 12);
        foreach ($venta['articulos'] as $articulo) {
            $subtotal = $articulo['cantidad'] * $articulo['precio'] - $articulo['descuento'];
            $pdf->Cell(70, 10, utf8_decode($articulo['nombre']), 1, 0, 'L');
            $pdf->Cell(30, 10, $articulo['cantidad'], 1, 0, 'C');
            $pdf->Cell(30, 10, "$ " . number_format($articulo['precio'], 2), 1, 0, 'C');
            $pdf->Cell(30, 10, "$ " . number_format($articulo['descuento'], 2), 1, 0, 'C');
            $pdf->Cell(30, 10, "$ " . number_format($subtotal, 2), 1, 1, 'C');
        }

        // Total final
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, utf8_decode("Total Final: $ {$venta['total']}"), 0, 1, 'R');
        $pdf->Ln(5);

        // Mensaje de agradecimiento
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 10, utf8_decode("¡Compre nuevamente!"), 0, 1, 'C');

        // Salida del PDF
        $pdf->Output('D', "ticket_venta_{$venta['idventa']}.pdf");
    }
}

// Verificar si se solicitó un ticket
if (isset($_GET['idventa'])) {
    $pdfController = new ticket();
    $pdfController->generateTicket($_GET['idventa']);
}
