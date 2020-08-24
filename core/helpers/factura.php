<?php
require('../../helpers/database.php');
require('../../helpers/validator.php');
require('../../../libraries/fpdf181/fpdf.php');

/**
*   Clase para definir las plantillas de los reportes del sitio privado.
*/
class Factura extends FPDF
{

    public function startDocument($title)
    {
        // Se establece la zona horaria a utilizar.
        ini_set('date.timezone', 'America/El_Salvador');
        // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el documento.
        session_start();
        // Se verifica si hay un cliente dentro de la sesión para generar la factura, de lo contrario se direcciona a main.php
        if (isset($_SESSION['id_cliente'])) {
            // Se asigna el título del documento a la propiedad de la clase.
            $this->title = 'Factura';
            // Se establece el título del documento para que se muestre en la pestaña del navegador (true = utf-8).
            $this->SetTitle($this->title, true);
            // Se establecen los margenes del documento (izquierdo, superior y derecho).
            $this->setMargins(15, 15, 15);
            // Se añade una nueva página al documento (orientación vertical y formato carta) y se llama implicitamente al método Header()
            $this->AddPage('p', 'letter');
            // Se define el alias para el número total de páginas que se muestra en el pie del documento.
            $this->AliasNbPages();
        } else {
            header('location: ../../views/commerce/index.php');
        }
    }

    /*
    *   Se sobrescribe el método de la librería para establecer la plantilla del encabezado del documento.
    *   Se llama automáticamente en el método AddPage()
    */
    public function Header()
    {
        // Se establece el encabezado únicamente para la primera página.
        if ($this->PageNo() == 1) {
            // Se establece el logo con respecto a los bordes del documento.
            $this->Image('../../../resources/img/logo_reporte.png', 45, 15, 30);
            // Se establece el fondo para el título con respecto a los bordes del documento.
            $this->Image('../../../resources/img/titulo.png', 105, 15, 96);
            // Se ubica el título con respecto al margen izquierdo.
            $this->Cell(90);
            $this->SetFont('Arial', 'B', 15);
            $this->SetTextColor(255, 255, 255); // Se establece color blanco para el texto
            $this->Cell(0, 15, utf8_decode($this->title), 0, 1, 'C');
            $this->Ln(5);
            // Se establece la fuente para el usuario y fecha/hora
            $this->SetFont('Arial', 'B', 10);
            // Se ubica el usuario que ha iniciado sesión.
            $this->Cell(95);
            $this->SetTextColor(87, 50, 0);
            $this->Cell(40, 10, 'Factura para el cliente:', 0, 0, 'L');
            $this->SetTextColor(0, 0, 0);
            $this->Cell(0, 10, $_SESSION['usuario_c'], 0, 1, 'L');
            // Se ubica la fecha y hora actual.
            $this->Cell(95);
            $this->SetTextColor(87, 50, 0);
            $this->Cell(25, 10, 'Fecha y hora:', 0, 0, 'L');
            $this->SetTextColor(0, 0, 0);
            $this->Cell(0, 10, date('d/m/Y h:i a'), 0, 1, 'L');
            // Se agrega un salto de línea para mostrar el contenido principal del documento.
            $this->Ln(15);
        }
    }

    /*
    *   Se sobrescribe el método de la librería para establecer la plantilla del pie del documento.
    *   Se llama implicitamente en el método Output()
    */
    public function Footer()
    {
        // Se establece la posición para colocar el marco inferior (a 15 milimetros del final).
        $this->SetY(-15);
        // Se ubica el marco inferior con respecto al borde izquierdo del documento.
        $this->Image('../../../resources/img/marco.png', 0, null, 216);
        // Se imprime una celda con el número de página.
        $this->SetY(-15);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 15, $this->PageNo().'/{nb}', 0, 0, 'C');
    }
}
?>