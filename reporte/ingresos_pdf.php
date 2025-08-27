<?php
		session_start();
		require_once('../pdf/class.ezpdf.php');
		require_once('../config.php');
		require_once('../conexion.php');
		require_once('../funciones.php');

		$pdf = new Cezpdf('letter','landscape');
		$pdf->selectFont('../pdf/fonts/Helvetica.afm');
		$pdf->ezSetCmMargins(1,1,1,1);
		
		/* Creamos un objeto que posteriormente pondremos en todas las p�ginas del documento */ 
		$Plantilla = $pdf->openObject(); 
		$pdf->saveState(); 
		
		$pdf->restoreState(); 
		$pdf->closeObject(); 
		
		// observe que el objeto se puede decir que aparezca en pagina par, impar o todas cambiando ' 
		// 'all' por 'even' o 'odd' 
		$pdf->addObject($Plantilla,'all'); 
		
		/* Empezamos a poner los n�meros de p�gina */
		
		$consulta = mysqli_query($conexion,$_SESSION['filtro_ingresos']);
			
		$titles = array(
		'folio'=>'<b>FOLIO</b>',
		'sucursal'=>'<b>SUCURSAL</b>',
		'cliente'=>'<b>CLIENTE</b>',
		'nota'=>'<b>NOTA IMPRESA</b>',
		'monto'=>'<b>MONTO</b>',
		'observaciones'=>'<b>OBSERVACIONES</b>',
		'fecha'=>'<b>FECHA</b>'
		);
		
		//$config = array('id'=>array('width'=>70),'f_trans'=>array('width'=>120),'h_trans'=>array('width'=>120,'desc'=>array('width'=>70),'cargo'=>array('width'=>45),'saldo_an'=>array('width'=>85),'saldo_ac'=>array('width'=>75)));
		
		$options = array('shadeCol'=>array(0.9,0.9,0.9),'xOrientation'=>'center','justification'=>'center','fontSize'=>8,'titleFontSize' => 8,'cols'=>$config,'splitRows'=>'1');
		
		if($registro= mysqli_fetch_array($consulta))
		{
			do
			{
				$aux = array('folio'=>$registro[1],'sucursal'=>$registro[2],'cliente'=>$registro[3] . ' ' . $registro[4] . ' ' . $registro[5] . ' ' . $registro[6],'nota'=>$registro[7],'monto'=>$registro[8],'observaciones'=>$registro[9],'fecha'=>$registro[10]);
				
				
				$data[] = $aux;
			}while($registro= mysqli_fetch_array($consulta));
		}
		else
		{
			for($i=0; $i <$total;$i++)
					$aux[] = '-';
				$data[] = $aux;	
		}
		
		$Plantilla = $pdf->openObject(); 
		$pdf->saveState(); 
		
		$pdf->ezText("                                       Reporte de Ingresos", 13);
		$pdf->ezText("                                                   Generado: ".date("Y/m/d"), 10);
		$pdf->ezText("\n", 12);

		
		$pdf->addJpegFromFile("../imagenes/tuvision_logo.jpg","25","545","140");
		
		$pdf->restoreState(); 
		$pdf->closeObject(); 
		
		// observe que el objeto se puede decir que aparezca en pagina par, impar o todas cambiando ' 
		// 'all' por 'even' o 'odd' 
		$pdf->addObject($Plantilla,'all'); 
		
		/* Empezamos a poner los n�meros de p�gina */ 
		$pdf->ezStartPageNumbers(300,4,8,'',"<b>Fecha:</b> ".date("d/m/Y")." <b>Hora:</b> ".date("H:i:s")."  <b>P�gina</b> {PAGENUM} <b>de</b> {TOTALPAGENUM}",1); 	
		
		$pdf->ezTable($data, $titles, '',$options,600);

		$nombreArchivo = "ingresos.pdf";

		header("Content-Type: application/pdf");
		header("Content-Disposition: inline; filename=\"$nombreArchivo\"");
		header("Cache-Control: private, must-revalidate, max-age=0");
		header("Pragma: public");

		// Aquí SÓLO compress
		$pdf->ezStream(array("compress" => 0));


?>