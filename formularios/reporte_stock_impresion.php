<?php
require('../impresion/mc_table.php');
require_once('../clases/producto_data.php');	
$producto = new Producto;
//$tipoproducto = new Tipoproducto;

		
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



$pdf->Cell(190,10,'REPORTE DE STOCK DE PRODUCTOS',0,0,'C');
$pdf->Ln(10);



$pdf->SetWidths(array(30,30,100,20));	
//srand(microtime()*1000000);
$pdf->Row(array('LINEA','MARCA','DESCRIPCION','STOCK'));

$rs= $producto->producto_listar($_REQUEST['linea'],'0',$_REQUEST['marca']);;

//$rs= mysql_query($rs,$cargo->con->cn);

if($rs)
{
	
		$j=1;
		$suma_cantidad=0;
	while($campo =mysql_fetch_array($rs)) 
	{
		//cargamos a las variables los campos de la bd
		
		$linea=$campo['lin_descripcion'];
		$marca=$campo['mar_descripcion'];
		$cantidad=$campo['pro_stock'];
		$producto=$campo['pro_descripcion'];	
		
	
		$pdf->Row(array($linea,$marca,$producto,$cantidad));

		//$suma_cantidad=$suma_cantidad + $cantidad;

		$j=$j+1;
				

  	 } 
}

$pdf->Output();
?>