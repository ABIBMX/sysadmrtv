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
		
		$consulta = mysqli_query($conexion,$_SESSION['tuvision_general_clientes_tap']);
			
		$titles = array(
		'id'=>'<b>ID TAP</b>',
		'valor'=>'<b>VALOR</b>',
		'salidas'=>'<b>SALIDAS</b>',
		'sucursal'=>'<b>SUCURSAL</b>',
		'cantidad'=>'<b>CANTIDAD CLIENTES</b>'
		);
		
		//$config = array('id'=>array('width'=>70),'f_trans'=>array('width'=>120),'h_trans'=>array('width'=>120,'desc'=>array('width'=>70),'cargo'=>array('width'=>45),'saldo_an'=>array('width'=>85),'saldo_ac'=>array('width'=>75)));
		
		$options = array('shadeCol'=>array(0.9,0.9,0.9),'xOrientation'=>'center','justification'=>'center','fontSize'=>8,'titleFontSize' => 8,'cols'=>$config,'splitRows'=>'1');
		
		if($registro= mysqli_fetch_array($consulta))
		{
			do
			{
				$aux = array('id'=>$registro[0],'valor'=>$registro[1],'salidas'=>$registro[2],'sucursal'=>$registro[3],'cantidad'=>$registro[4]);
				
				
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
		
		$pdf->ezText("                                       Reporte General de Clientes por Tap", 13);
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
	

		$pdf->ezStream(array("Content-Disposition"=>$filename."_".date("d/m/Y").".pdf","compress"=>0));

?>