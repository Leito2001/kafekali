<?php
require('../../helpers/pdf.php');
require('../../models/productos.php');
require('../../models/proveedores.php');

// Se instancia la clase para crear el reporte.
$pdf = new PDF;
// Se inicia el reporte con el encabezado del documento.
$pdf->startDocument('Productos por empresa');

// Se instancia el módelo Categorías para obtener los datos.
$proveedor = new Proveedores;
// Se verifica si existen registros (categorías) para mostrar, de lo contrario se imprime un mensaje.
if ($dataProveedores = $proveedor->readAllProveedores()) {
    // Se recorren los registros ($dataCategorias) fila por fila ($rowCategoria).
    foreach ($dataProveedores as $rowProveedor) {
        // Se establece un color de relleno para mostrar el nombre de la categoría.
        $pdf->SetFillColor(200);
        // Se establece la fuente para el nombre de la categoría.
        $pdf->SetFont('Arial', 'B', 12);
        // Se imprime una celda con el nombre de la categoría.
        $pdf->Cell(0, 10, utf8_decode('Empresa: '.$rowProveedor['nombre_empresa']), 1, 1, 'C', 1);
        // Se instancia el módelo Productos para obtener los datos.
        $producto = new Productos;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($proveedor->setNombreEmpresa($rowProveedor['nombre_empresa'])) {
            // Se verifica si existen registros (productos) para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $proveedor->productosProveedor()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->SetFillColor(230);
                // Se establece la fuente para los encabezados de la tabla.
                $pdf->SetFont('Arial', 'B', 11);
                // Se imprimen las celdas con los encabezados. Se debe dividir el espacio entre 186.
                $pdf->Cell(62, 10, utf8_decode('Nombre proveedor'), 1, 0, 'C', 1);
                $pdf->Cell(62, 10, utf8_decode('Celular'), 1, 0, 'C', 1);
                $pdf->Cell(62, 10, utf8_decode('Producto'), 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->SetFont('Arial', '', 11);
                // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
                foreach ($dataProductos as $rowProducto) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->Cell(62, 10, utf8_decode($rowProducto['nombre_prov']), 1, 0);
                    $pdf->Cell(62, 10, utf8_decode($rowProducto['celular']), 1, 0);
                    $pdf->Cell(62, 10, utf8_decode($rowProducto['nombre_producto']), 1, 1);
                }
            } else {
                $pdf->Cell(0, 10, utf8_decode('No hay productos para este proveedor'), 1, 1);
            }
        } else {
            $pdf->Cell(0, 10, utf8_decode('Ocurrió un error en un proveedor'), 1, 1);
        }
    }
} else {
    $pdf->Cell(0, 10, utf8_decode('No hay productos para mostrar'), 1, 1);
}

// Se envía el documento al navegador y se llama al método Footer() automáticamente.
$pdf->Output();
?>