<?php 	require('../impresion/mc_table.php');
		require_once "../clases/ventas_data.php";
		require_once "../clases/numeros_a_letras_data.php";
		
		$venta = new Venta;
		//$comprobante = new Comprobante;
		$cliente = new Cliente;
		$numerosletras = new Numeros_a_letras;
		
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


//$pdf->FPDF('P','mm','A4');
$pdf=new FPDF('P','cm','custom',300.28,458.92);  //ingreso medida puntos 


//$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetLeftMargin(0.7);
$pdf->PageNo();
$pdf->SetTopMargin(5);
$pdf->SetAutoPageBreak(0.6);

$pdf->AddPage();
$pdf->SetFont('Arial','',9);

	$venta->ventas_ver($_REQUEST['venta']);
		
		$nro_documento=$venta->ven_nrodoc;		
		$cliente_nombre=$venta->cli_razonsocial;
		$cliente_direccion=$venta->cli_direccion;
		$cliente_ruc=$venta->cli_ruc;
		$e_fecha=$venta->_util->obtiene_fecha($venta->ven_fecha);
		
		$fecha = explode("/", $e_fecha);//si fecha esta en formato dia-mes-año 
	
		$dia=$fecha[0]; 
		$mes=$venta->_util->ver_nombre_mes($fecha[1]); 
		$mes_numero=substr($fecha[3],2);
		$anio=substr($fecha[2],3);		
		
		
		
$pdf->Cell(1.2,0.8,'',0,0,'L');//fecha
$pdf->Cell(1.2,0.8,$dia,0,0,'L');
$pdf->Cell(1.2,0.8,$mes_numero,0,0,'L');
$pdf->Cell(1.2,0.8,$anio,0,0,'L');
$pdf->Cell(1.2,0.8,'',0,0,'L');
$pdf->Ln(0.8);

$pdf->Cell(9,0.1,'',0,0,'L');
$pdf->Ln(0.1);

$pdf->Cell(1.7,0.7,'',0,0,'L');
$pdf->Cell(7.3,0.7,$cliente_nombre,0,0,'L');
$pdf->Ln(0.7);

$pdf->Cell(9,0.1,'',0,0,'L');
$pdf->Ln(0.1);

$pdf->Cell(9,0.7,'',0,0,'L');
$pdf->Ln(0.7);


		$j='0';
  		$rsd=$venta->detalle_ventas_listar($_REQUEST['venta']);
  		
		while($campod = mysql_fetch_array($rsd)){
			
			$producto =$campod['pro_descripcion'];			
			$cantidad =$campod['ven_totalcantidad'];
			$precio=$campod['ven_preciototal'];
		
			$pdf->Cell(1.2,0.5,number_format($cantidad,0),0,0,'C');//$cantidad. ' '.$unidad
			$pdf->Cell(4.6,0.5,$producto,0,0,'L');	
			$pdf->Cell(1.4,0.5,'',0,0,'C');			
			$pdf->Cell(1.8,0.5,'S/. '.$precio,0,0,'C');			
			$pdf->Ln(0.5);	
			
			$total=$total+$precio;			
			$j=$j+1;
		}
		
		//$subtotal=$total/1.19;
		//$igv=$total-$subtotal;
		
		$total_filas=14;
		$resto_filas=$total_filas - $j;
		
		for($i=1;$i<=$resto_filas;$i++)
		{
			//celdas vacias
			$pdf->Cell(9,0.5,'',0,0,'C');
			$pdf->Ln(0.5);
			
		}
		
			$pdf->Cell(7.2,0.7,'',0,0,'C');	
			$pdf->Cell(1.8,0.7,'S/. '.number_format($total,2),0,0,'C');				
			$pdf->Ln(0.7);


/*$valor = explode(".",$total);
$numero_entero=$valor[0];


if($valor[1]=='')
{
	$numero_decimal='00';	
}
else
{
	if($valor[1]<10)
	{
		$numero_decimal=$valor[1]*10;
	}
	else
	{
		$numero_decimal=$valor[1];
	}
}
$numero_letras=strtoupper($numerosletras->num2letras($numero_entero)).' CON '.$numero_decimal.'/100 NUEVOS SOLES';
*/

$venta->_util->_cn->desconectar(); 


$pdf->Output();
?>

