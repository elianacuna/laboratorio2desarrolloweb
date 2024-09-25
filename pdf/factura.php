<?php

include ('fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      $this->Image('v42_4.png', 270, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(95); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(110, 15, utf8_decode('Factura Laboral'), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color

   
      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(228, 100, 0);
      $this->Cell(100); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("Nomina liquidacion laboral "), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(252, 166, 55); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(10, 10, utf8_decode('ID'), 1, 0, 'C', 1);
      $this->Cell(70, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('Contratacion'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('Finalizacion'), 1, 0, 'C', 1);
      $this->Cell(29, 10, utf8_decode('Indermizacion'), 1,0 , 'C', 1);
      $this->Cell(20, 10, utf8_decode('Bono 14'), 1, 0, 'C', 1);
      $this->Cell(20, 10, utf8_decode('Aguinaldo'), 1, 0, 'C', 1);
       $this->Cell(25, 10, utf8_decode('Vacaciones'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('Horas extras'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('Total'), 1, 1, 'C', 1);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(540, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

include('../includes/conexion.php');

$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
   $Idq = $_GET["id"];
 

$consulta_reporte_quincena = $conn->query("SELECT * FROM liquidacionlaboral WHERE id_liquidacionlaboral = $Idq");

while ($datos_reporte = $consulta_reporte_quincena->fetch_object()) {
   $pdf->Cell(10, 10, utf8_decode($datos_reporte->id_liquidacionlaboral ), 1, 0, 'C', 0);
   $pdf->Cell(70, 10, utf8_decode($datos_reporte->empledo ), 1, 0, 'C', 0); 
$pdf->Cell(25, 10, utf8_decode($datos_reporte->fecha_contratacion ), 1, 0, 'C', 0);
  $pdf->Cell(25, 10, utf8_decode($datos_reporte->fecha_terminacion_trabajo ), 1, 0, 'C', 0);
  $pdf->Cell(29, 10, utf8_decode($datos_reporte->monto_liquidacion), 1, 0, 'C', 0);
   $pdf->Cell(20, 10, utf8_decode($datos_reporte->bono14 ), 1, 0, 'C', 0); 
$pdf->Cell(20, 10, utf8_decode($datos_reporte->aguinaldo ), 1, 0, 'C', 0);
  $pdf->Cell(25, 10, utf8_decode($datos_reporte->vacaciones ), 1, 0, 'C', 0);
   $pdf->Cell(25, 10, utf8_decode($datos_reporte->horas_extras ), 1, 0, 'C', 0); 
$pdf->Cell(25, 10, utf8_decode($datos_reporte->totalprestacion ), 1, 1, 'C', 0);

$pdf->Output("liquidacion de $datos_reporte->empledo".'.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
   }
   

}
?>




