<?php
require('../../helpers/pdf.php');
require('../../models/productos.php');
require('../../models/pedidos.php');

// Se instancia la clase para crear el reporte.
$pdf = new PDF;
// Se inicia el reporte con el encabezado del documento.
$pdf->startDocument('Productos por estado');

// Se instancia el módelo Categorías para obtener los datos.
$pedidos = new Pedidos;
// Se verifica si existen registros (categorías) para mostrar, de lo contrario se imprime un mensaje.
if ($dataPedidos = $pedidos->readAllPedidos()) {
    // Se recorren los registros ($dataCategorias) fila por fila ($rowCategoria).
    foreach ($dataPedidos as $rowPedidos) {
        // Se establece un color de relleno para mostrar el nombre de la categoría.
        $pdf->SetFillColor(200);
        // Se establece la fuente para el nombre de la categoría.
        $pdf->SetFont('Arial', 'B', 12);
        // Se imprime una celda con el nombre de la categoría.
        $pdf->Cell(0, 10, utf8_decode('Estado del pedido: '.$rowPedidos['estado_pedido']), 1, 1, 'C', 1);
        // Se instancia el módelo Productos para obtener los datos.
        $producto = new Productos;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($pedidos->setEstado($rowPedidos['estado_pedido'])) {
            // Se verifica si existen registros (productos) para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $productos->productosEstado()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->SetFillColor(230);
                // Se establece la fuente para los encabezados de la tabla.
                $pdf->SetFont('Arial', 'B', 11);
                // Se imprimen las celdas con los encabezados. Se debe dividir el espacio entre 186.
                $pdf->Cell(62, 10, utf8_decode('Usuario del cliente'), 1, 0, 'C', 1);
                $pdf->Cell(62, 10, utf8_decode('Producto'), 1, 0, 'C', 1);
                $pdf->Cell(62, 10, utf8_decode('Precio'), 1, 1, 'C', 1);
                $pdf->Cell(62, 10, utf8_decode('Cantidad de producto'), 1, 1, 'C', 1);
                $pdf->Cell(62, 10, utf8_decode('Fecha del pedido'), 1, 1, 'C', 1);
                $pdf->Cell(62, 10, utf8_decode('Total'), 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->SetFont('Arial', '', 11);
                // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
                foreach ($dataProductos as $rowProducto) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->Cell(62, 10, utf8_decode($rowProducto['usuario_c']), 1, 0);
                    $pdf->Cell(62, 10, utf8_decode($rowProducto['nombre_producto']), 1, 0);
                    $pdf->Cell(62, 10, $rowProducto['precio'], 1, 0);
                    $pdf->Cell(62, 10, $rowProducto['cantidad_producto'], 1, 0);
                    $pdf->Cell(62, 10, utf8_decode($rowProducto['fecha']), 1, 0);
                    $pdf->Cell(62, 10, $rowProducto['total'], 1, 1);
                }
            } else {
                $pdf->Cell(0, 10, utf8_decode('No hay pedidos para este estado'), 1, 1);
            }
        } else {
            $pdf->Cell(0, 10, utf8_decode('Ocurrió un error en un pedido'), 1, 1);
        }
    }
} else {
    $pdf->Cell(0, 10, utf8_decode('No hay pedidos para mostrar'), 1, 1);
}

// Se envía el documento al navegador y se llama al método Footer() automáticamente.
$pdf->Output();
?>