<?php 	require('../impresion/mc_table.php');
		require_once "../clases/ventas_data.php";
		require_once "../clases/numeros_a_letras_data.php";
		
		$venta = new Venta;
		//$comprobante = new Comprobante;
		$cliente = new Cliente;
		$numerosletras = new Numeros_a_letras;
		
		$pdf=new PDF_MC_Table();

/*class PDF extends FPDF
{

//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('arial','',9);
    //Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}*/


	require('../impresion/pdf_js.php');
	
	class PDF_AutoPrint extends PDF_JavaScript
	{
		function AutoPrint($dialog=false)
		{
			//Open the print dialog or start printing immediately on the standard printer
			$param=($dialog ? 'true' : 'false');
			$script="print($param);";
			$this->IncludeJS($script);
		}
	
		function AutoPrintToPrinter($server, $printer, $dialog=false)
		{
			//Print on a shared printer (requires at least Acrobat 6)
			$script = "var pp = getPrintParams();";
			if($dialog)
				$script .= "pp.interactive = pp.constants.interactionLevel.full;";
			else
				$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
			$script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
			$script .= "print(pp);";
			$this->IncludeJS($script);
		}
	}


$pdf=new PDF_AutoPrint('P','cm','custom',714.00,394.016);  //ingreso medida puntos


//$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetLeftMargin(0.3);
$pdf->PageNo();
$pdf->SetTopMargin(2.5);
$pdf->SetAutoPageBreak(0.9);

$pdf->AddPage();
$pdf->SetFont('arial','',9);

	$venta->ventas_ver($_REQUEST['venta']);
		
		$nro_documento=$venta->ven_nrodoc;		
		$cliente_nombre=$venta->cli_razonsocial;
		$cliente_direccion=$venta->cli_direccion;
		$cliente_ruc=$venta->cli_ruc;
		$e_fecha=$venta->_util->obtiene_fecha($venta->ven_fecha);
		
		$fecha = explode("/", $e_fecha);//si fecha esta en formato dia-mes-año 
	
		$dia=$fecha[0]; 
		$mes=$venta->_util->ver_nombre_mes($fecha[1]); 
		$mes_numero=$fecha[1];
		$anio=substr($fecha[2],2);		
		
		
		
$pdf->Cell(1.7,0.5,'',0,0,'L');//señor(es)
$pdf->Cell(10.8,0.5,$cliente_nombre,0,0,'L');
$pdf->Ln(0.5);

$pdf->Cell(1.7,0.5,'',0,0,'L');//dirección
$pdf->Cell(10.8,0.5,$cliente_direccion,0,0,'L');
$pdf->Ln(0.5);

$pdf->Cell(1.7,0.5,'',0,0,'L');//ruc
$pdf->Cell(2.5,0.5,$cliente_ruc,0,0,'L');
$pdf->Cell(2.7,0.5,'',0,0,'L');//guia
$pdf->Cell(1.9,0.5,'',0,0,'L');
$pdf->Cell(1.1,0.5,'',0,0,'L');//fecha
$pdf->Cell(2.6,0.5,$e_fecha,0,0,'L');
$pdf->Ln(0.5);

$pdf->Cell(1.9,0.5,'',0,0,'L');//cantidad
$pdf->Cell(1.3,0.5,'',0,0,'L');//unidad
$pdf->Cell(12.2,0.5,'',0,0,'L');//descripcion
$pdf->Cell(2.3,0.5,'',0,0,'L');//precio unitario
$pdf->Cell(2.7,0.5,'',0,0,'L');//importe
$pdf->Ln(0.5);


		$j='0';
  		$rsd=$venta->detalle_ventas_listar($_REQUEST['venta']);
  		
		while($campod = mysql_fetch_array($rsd)){
			
			$producto =$campod['pro_descripcion'];			
			$cantidad =$campod['ven_totalcantidad'];
			$importe=$campod['ven_preciototal'];
			$precio = $importe / $cantidad;
		
				$pdf->Cell(1.9,0.5,$cantidad,0,0,'C');//cantidad
				$pdf->Cell(1.3,0.5,'',0,0,'C');//unidad
				$pdf->Cell(12.2,0.5,$producto,0,0,'L');//descripcion
				$pdf->Cell(2.3,0.5,number_format($precio,2),0,0,'C');//precio unitario
				$pdf->Cell(2.7,0.5,number_format($importe,2),0,0,'C');//importe
				$pdf->Ln(0.5);
			
			$total=$total+$importe;
			$j=$j+1;
		}
		
		$subtotal=$total/1.19;
		$igv=$total-$subtotal;
		
		$total_filas=12;
		$resto_filas=$total_filas - $j;
		
		for($i=1;$i<=$resto_filas;$i++)
		{
			//celdas vacias
			$pdf->Cell(20.4,0.5,'',0,0,'C');
			$pdf->Ln(0.5);
			
		}

			//celdas vacias
			//$pdf->Cell(20.4,0.5,'',0,0,'C');
			//$pdf->Ln(0.5);

			//obtener total en letras
			$valor = explode(".",$total);
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
			//fin



			$pdf->Cell(1,0.5,'',0,0,'C');
			$pdf->Cell(16.7,0.5,$numero_letras,0,0,'L');
			$pdf->Cell(2.7,0.5,'S/. '.number_format($subtotal,2),0,0,'C');
			$pdf->Ln(0.5);

			$pdf->Cell(17.7,0.5,'',0,0,'L');
			$pdf->Cell(2.7,0.5,'S/. '.number_format($igv,2),0,0,'C');
			$pdf->Ln(0.5);

			$pdf->Cell(17.7,0.5,'',0,0,'L');
			$pdf->Cell(2.7,0.5,'S/. '.number_format($total,2),0,0,'C');
			$pdf->Ln(0.5);


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

$pdf->AutoPrint(true);

$pdf->Output();
?>

