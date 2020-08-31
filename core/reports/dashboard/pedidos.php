<?php
require('../../helpers/pdf.php');
require('../../models/pedidos.php');

// Se instancia la clase para crear el reporte.
$pdf = new PDF;
// Se inicia el reporte con el encabezado del documento.
$pdf->startDocument('Ventas diarias por semana');

// Se instancia el módelo Pedidos para obtener los datos.
$pedido = new Pedidos;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($data = $pedido->ventasSemana()) {
    // Se obtiene la primera semana
    $semana = $data[0]['semana'];
    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->SetFillColor(175);
    // Se establece la fuente para el nombre de la categoría.
    $pdf->SetFont('Arial', 'B', 12);
    // Se imprime una celda con el nombre de la categoría.
    $pdf->Cell(0, 10, utf8_decode('Semana '.$data[0]['semana']), 1, 1, 'C', 1);
    // Se establece un color de relleno para los encabezados.
    $pdf->SetFillColor(225);
    // Se establece la fuente para los encabezados de la tabla.
    $pdf->SetFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->Cell(100, 10, utf8_decode('Fecha de los pedidos'), 1, 0, 'C', 1);
    $pdf->Cell(46, 10, utf8_decode('Cantidad de pedidos'), 1, 0, 'C', 1);
    $pdf->Cell(40, 10, utf8_decode('Venta total'), 1, 1, 'C', 1);
    // Se recorren los registros fila por fila.
    foreach ($data as $row) {
        if ($semana != $row['semana'] ) {
            // Se establece un color de relleno para mostrar el nombre de la categoría.
            $pdf->SetFillColor(175);
            // Se establece la fuente para el nombre de la categoría.
            $pdf->SetFont('Arial', 'B', 12);
            // Se imprime una celda con el nombre de la categoría.
            $pdf->Cell(0, 10, utf8_decode('Semana '.$row['semana']), 1, 1, 'C', 1);
            // Se establece un color de relleno para los encabezados.
            $pdf->SetFillColor(225);
            // Se establece la fuente para los encabezados de la tabla.
            $pdf->SetFont('Arial', 'B', 11);
            // Se imprimen las celdas con los encabezados.
            $pdf->Cell(100, 10, utf8_decode('Fecha de los pedidos'), 1, 0, 'C', 1);
            $pdf->Cell(46, 10, utf8_decode('Cantidad de pedidos'), 1, 0, 'C', 1);
            $pdf->Cell(40, 10, utf8_decode('Venta total'), 1, 1, 'C', 1);
            $semana = $row['semana'];
        } else {
            $semana = $row['semana'];
        }
        // Se establece la fuente para los datos de los productos.
        $pdf->SetFont('Arial', '', 11);
        // Se imprimen las celdas con los datos de los productos.
        $pdf->Cell(100, 10, utf8_decode($row['fecha']), 1, 0);
        $pdf->Cell(46, 10, $row['pedidos'], 1, 0);
        $pdf->Cell(40, 10, $row['ventatotaldia'], 1, 1);
    }
} else {
    $pdf->Cell(0, 10, utf8_decode('No hay datos para mostrar'), 1, 1, 'C');
}

// Se envía el documento al navegador y se llama al método Footer() automáticamente.
$pdf->Output();
?>