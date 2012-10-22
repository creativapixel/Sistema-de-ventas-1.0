<?php require('../impresion/mc_table.php');
require_once('../clases/ventas_data.php');
$venta = new Venta;	
$producto = new Producto;
$tipoproducto = new Tipoproducto;

		
$pdf=new PDF_MC_Table();



class PDF extends FPDF
{




//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}





$pdf->FPDF('P','mm','A4');






//$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetLeftMargin(15);
$pdf->PageNo();
//$pdf->SetTopMargin(0);


$pdf->AddPage();
$pdf->SetFont('Arial','',7);



$pdf->Cell(190,10,'REPORTE DE VENTA DE PRODUCTOS',0,0,'C');
$pdf->Ln(10);



$pdf->Cell(150,5,'VENTAS REGISTRADAS DESDE EL '.$_REQUEST['fecha'].' AL '.$_REQUEST['fecha2'].'',0,0,'L');
$pdf->Ln(5);

$pdf->Cell(275,5,'',0,0,'C');
$pdf->Ln(5);




$pdf->SetWidths(array(12,15,25,80,20,16,16));	
//srand(microtime()*1000000);
$pdf->Row(array('Nro','FECHA','TIPO PRODUCTO','DESCRIPCION','CANTIDAD','PRECIO','IMPORTE'));

$rs= $venta->ventas_listar_fecha($_REQUEST['fecha'],$_REQUEST['fecha2']);


if($rs)
{
	
		$j=1;
		$suma_cantidad=0;
		$suma_precio=0;
		$suma_importe=0;
	while($campo =mysql_fetch_array($rs)) 
	{
		//cargamos a las variables los campos de la bd
		$fecha=$venta->_util->obtiene_fecha($campo['ven_fecha']);
		$tipo=$campo['tipp_descripcion'];
		$descripcion=$campo['prod_descripcion'];
		$cantidad=$campo['ven_cantidad'];
		$precio=$campo['ven_precio'];
		$unidad=$campo['uni_descripcion'];
		$moneda=$campo['tipm_descripcion'];
		$importe=$cantidad*$precio;
	
		$pdf->Row(array($j,$fecha,$tipo,$descripcion,$cantidad.' '.$unidad,$moneda.' '.$precio,$moneda.' '.number_format($importe,2)));

		$suma_importe=$suma_importe + $importe;
		$suma_cantidad=$suma_cantidad + $cantidad;
		$suma_precio=$suma_precio + $precio;
		$j=$j+1;
				

  	 } 
}


$pdf->Row(array('','','','Total',number_format($suma_cantidad,2).' '.$unidad,$moneda.' '.number_format($suma_precio,2),$moneda.' '.number_format($suma_importe,2)));



//$ingreso->con->cerrar();

//$pdf->WriteHTML($htmlTable);
$pdf->Output();
?>