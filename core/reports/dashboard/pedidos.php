<?php
require('../../helpers/pdf.php');
require('../../models/pedidos.php');
require('../../models/productos.php');

// Se instancia la clase para crear el reporte.
$pdf = new PDF;
// Se inicia el reporte con el encabezado del documento.
$pdf->startDocument('Ventas por semana');

// Se instancia el modelo para obtener los datos.
$pedidos = new Pedidos;
// Se verifica si existen registros (categorías) para mostrar, de lo contrario se imprime un mensaje.
if ($dataPedidos = $pedidos->readAllPedidos()) {
    // Se recorren los registros fila por fila.
    foreach ($dataPedidos as $rowPedido) {
        // Se establece un color de relleno para mostrar el nombre de la semana.
        $pdf->SetFillColor(200);
        // Se establece la fuente para el nombre de la categoría.
        $pdf->SetFont('Arial', 'B', 12);
        // Se imprime una celda con el nombre de la categoría.
        $pdf->Cell(0, 10, utf8_decode('Semana número '.$rowPedido['semana']), 1, 1, 'C', 1);
        // Se instancia el módelo Productos para obtener los datos.
        $producto = new Productos;
        // Se establece la semana para obtener los pedisos, de lo contrario se imprime un mensaje de error.
        if ($pedidos->setSemana($rowPedido['semana'])) {
            // Se verifica si existen registros (pedidos) para mostrar, de lo contrario se imprime un mensaje.
            if ($dataPedidos = $pedidos->ventasSemana()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->SetFillColor(230);
                // Se establece la fuente para los encabezados de la tabla.
                $pdf->SetFont('Arial', 'B', 11);
                // Se imprimen las celdas con los encabezados. Se debe dividir el espacio entre 186.
                $pdf->Cell(62, 10, utf8_decode('Fecha de los pedidos'), 1, 0, 'C', 1);
                $pdf->Cell(62, 10, utf8_decode('Número de pedidos por día'), 1, 0, 'C', 1);
                $pdf->Cell(62, 10, utf8_decode('Venta total del día'), 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->SetFont('Arial', '', 11);
                // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
                foreach ($dataPedidos as $rowPedido) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->Cell(62, 10, utf8_decode($rowPedido['fecha']), 1, 0);
                    $pdf->Cell(62, 10, utf8_decode($rowPedido['pedidos']), 1, 0);
                    $pdf->Cell(62, 10, $rowPedido['ventatotaldia'], 1, 1);
                }
            } else {
                $pdf->Cell(0, 10, utf8_decode('No hay pedidos para esta semana'), 1, 1);
            }
        } else {
            $pdf->Cell(0, 10, utf8_decode('Ocurrió un error en una semana'), 1, 1);
        }
    }
} else {
    $pdf->Cell(0, 10, utf8_decode('No hay productos para mostrar'), 1, 1);
}

// Se envía el documento al navegador y se llama al método Footer() automáticamente.
$pdf->Output();
?>