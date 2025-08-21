<?php
		session_start();
		require_once('../pdf/class.ezpdf.php');
		require_once('../config.php');
		require_once('../conexion.php');
		require_once('../funciones.php');

		$pdf = new Cezpdf('letter','landscape');
		$pdf->selectFont('../pdf/fonts/Helvetica.afm');
		$pdf->ezSetCmMargins(1,1,1,1);
		
		/* Creamos un objeto que posteriormente pondremos en todas las páginas del documento */ 
		$Plantilla = $pdf->openObject(); 
		$pdf->saveState(); 
		
		$pdf->restoreState(); 
		$pdf->closeObject(); 
		
		// observe que el objeto se puede decir que aparezca en pagina par, impar o todas cambiando ' 
		// 'all' por 'even' o 'odd' 
		$pdf->addObject($Plantilla,'all'); 
		
		/* Empezamos a poner los números de página */
		
		$consulta = mysqli_query($conexion,$_SESSION['filtro_reporte_servicio2']);
			
		$titles = array(
		'folio'=>'<b>FOLIO</b>',
		'suc'=>'<b>SUCURSAL</b>',
		'n_cli'=>'<b>N. DE CLIENTE</b>',
		'cli'=>'<b>CLIENTE</b>',
		'fecha_r'=>'<b>FECHA DE REPORTE</b>',
		'fecha_a'=>'<b>FECHA DE ATENCION</b>',
		'serv'=>'<b>SERVICIO</b>',
		'edo'=>'<b>ESTADO</b>'
		);
		
		//$config = array('id'=>array('width'=>70),'f_trans'=>array('width'=>120),'h_trans'=>array('width'=>120,'desc'=>array('width'=>70),'cargo'=>array('width'=>45),'saldo_an'=>array('width'=>85),'saldo_ac'=>array('width'=>75)));
		
		$config = array(
			'folio'=>array('width'=>55),
			'suc'=>array('width'=>80),
			'n_cli'=>array('width'=>55),
			'cli'=>array('width'=>120),
			'fecha_r'=>array('width'=>65),
			'fecha_a'=>array('width'=>65),
			'serv'=>array('width'=>120),
			'edo'=>array('width'=>70),
		);
		
		$options = array('shadeCol'=>array(0.9,0.9,0.9),'xOrientation'=>'center','justification'=>'center','fontSize'=>8,'titleFontSize' => 8,'cols'=>$config,'splitRows'=>'1');
		
		if($registro= mysqli_fetch_array($consulta))
		{
			do
			{
				$aux = array('folio'=>$registro[6],'suc'=>$registro[1],'n_cli'=>$registro[2],'cli'=>$registro[3],'fecha_r'=>$registro[4],'fecha_a'=>$registro[5],'serv'=>$registro[9],'edo'=>$registro[7]);
				
				
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
		
		$pdf->ezText("                                       Reporte de Servicios", 13);
		$pdf->ezText("                                                   Generado: ".date("Y/m/d"), 10);
		$pdf->ezText("\n", 12);

		
		$pdf->addJpegFromFile("../imagenes/tuvision_logo.jpg","25","545","140");
		
		$pdf->restoreState(); 
		$pdf->closeObject(); 
		
		// observe que el objeto se puede decir que aparezca en pagina par, impar o todas cambiando ' 
		// 'all' por 'even' o 'odd' 
		$pdf->addObject($Plantilla,'all'); 
		
		/* Empezamos a poner los números de página */ 
		$pdf->ezStartPageNumbers(300,4,8,'',"<b>Fecha:</b> ".date("d/m/Y")." <b>Hora:</b> ".date("H:i:s")."  <b>Página</b> {PAGENUM} <b>de</b> {TOTALPAGENUM}",1); 	
		
		$pdf->ezTable($data, $titles, '',$options,600);
	

		$pdf->ezStream(array("Content-Disposition"=>$filename."_".date("d/m/Y").".pdf","compress"=>0));

?>
