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
		
		$consulta = mysqli_query($conexion,$_SESSION['tuvision_general_clientes']);
			
		$titles = array(
		'sucursal'=>'<b>SUCURSAL</b>',
		'activos'=>'<b>ACTIVOS</b>',
		'cancelados'=>'<b>CANCELADOS</b>',
		'pendientes'=>'<b>PENDIENTES DE INSTALAR</b>',
		'total'=>'<b>TOTAL</b>'
		);
		
		//$config = array('id'=>array('width'=>70),'f_trans'=>array('width'=>120),'h_trans'=>array('width'=>120,'desc'=>array('width'=>70),'cargo'=>array('width'=>45),'saldo_an'=>array('width'=>85),'saldo_ac'=>array('width'=>75)));
		
		$options = array('shadeCol'=>array(0.9,0.9,0.9),'xOrientation'=>'center','justification'=>'center','fontSize'=>8,'titleFontSize' => 8,'cols'=>$config,'splitRows'=>'1');
		
		if($registro= mysqli_fetch_array($consulta))
		{
			$total_activos = 0;
			$total_cancelados = 0;
			$total_pendientes = 0;
			$total_total = 0;

			do
			{
				
				$total_activos += $registro[1];
				$total_cancelados += $registro[2];
				$total_pendientes += $registro[3];
				$total = $registro[1] + $registro[2] + $registro[3];
				$total_total += $total;
				
				$aux = array('sucursal'=>$registro[0],'activos'=>$registro[1],'cancelados'=>$registro[2],'pendientes'=>$registro[3],'total'=>$total);
				
				$data[] = $aux;
			}while($registro= mysqli_fetch_array($consulta));
			
			$aux = array('sucursal'=>"<b>TOTALES</b>",'activos'=>"<b>".$total_activos."</b>",'cancelados'=>"<b>".$total_cancelados."</b>",'pendientes'=>"<b>".$total_pendientes."</b>",'total'=>"<b>".$total_total."</b>");
			$data[] = $aux;
			
		}
		else
		{
			for($i=0; $i <$total;$i++)
					$aux[] = '-';
				$data[] = $aux;	
		}
		
		$Plantilla = $pdf->openObject(); 
		$pdf->saveState(); 
		
		$pdf->ezText("                                       Reporte General de Clientes", 13);
		if(isset($_SESSION['general_desde_contrato'])&&isset($_SESSION['general_hasta_contrato']))
		{
			$cadena_fechas = "Fecha contrato del ".$_SESSION['general_desde_contrato']." al ".$_SESSION['general_hasta_contrato'];
			$pdf->ezText("                                                   ".$cadena_fechas, 10);
		}
		if(isset($_SESSION['general_desde_activacion'])&&isset($_SESSION['general_hasta_activacion']))
		{
			$cadena_fechas = "Fecha activacion del ".$_SESSION['general_desde_activacion']." al ".$_SESSION['general_hasta_activacion'];
			$pdf->ezText("                                                   ".$cadena_fechas, 10);
		}	
	
		$pdf->ezText("                                                                Generado: ".date("Y/m/d"."\n"), 8);

		
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