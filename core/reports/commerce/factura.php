<?php
require('../../helpers/pdf.php');
require('../../models/categorias.php');
require('../../models/pedidos.php');

// Se instancia la clase para crear el reporte.
$pdf = new PDF;

// Se instancia el módelo Categorías para obtener los datos.
$pedido = new Pedidos;
// Se verifica si existen registros (categorías) para mostrar, de lo contrario se imprime un mensaje.
if ($dataPedidos = $pedido->createFactura()) {
    foreach ($dataPedidos as $rowProducto) {
    // Se establece un color de relleno para los encabezados.
    $pdf->SetFillColor(230);
    // Se establece la fuente para los encabezados de la tabla.
    $pdf->SetFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados. Se debe dividir el espacio entre 186 espacios.
    $pdf->Cell(48, 10, utf8_decode('Producto'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, utf8_decode('Precio (US$)'), 1, 1, 'C', 1);
    $pdf->Cell(47, 10, utf8_decode('Cantidad de productos'), 1, 2, 'C', 1);
    $pdf->Cell(46, 10, utf8_decode('Subtotal'), 1, 3, 'C', 1);
    $pdf->Cell(0, 10, utf8_decode('Total a pagar'), 1, 4, 'C', 1);
    // Se establece la fuente para los datos de los productos.
    $pdf->SetFont('Arial', '', 11);
    // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
        foreach ($dataPedidos as $rowProducto) {
            // Se imprimen las celdas con los datos de los productos.
            $pdf->Cell(48, 10, utf8_decode($rowProducto['nombre_producto']), 1, 0);
            $pdf->Cell(45, 10, $rowProducto['precio'], 1, 1);
            $pdf->Cell(47, 10, $rowProducto['cantidad_producto'], 1, 2);
            $pdf->Cell(46, 10, $rowProducto['subtotal'], 1, 3);
            $pdf->Cell(0, 10, $rowProducto['totalpagar'], 1, 4);
        }

    }
    } else {
        $pdf->Cell(0, 10, utf8_decode('No hay productos en su carrito'), 1, 1);
    }

// Se envía el documento al navegador y se llama al método Footer() automáticamente.
$pdf->Output();
?>