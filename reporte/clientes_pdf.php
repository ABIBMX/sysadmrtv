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
		
		$consulta = mysqli_query($conexion,$_SESSION['tuvision_filtro_clientes2']);
			
		$titles = array(
		'id_cliente'=>'<b>CLAVE</b>',
		'nombre'=>'<b>NOMBRE</b>',
		'sucursal'=>'<b>SUCURSAL</b>',
		'status'=>'<b>STATUS</b>',
		'tipo_status'=>'<b>TIPO ESTATUS</b>',
		'tipo_servicio'=>'<b>ESTATUS SERVICIO INTERNET</b>',
		'activacion'=>'<b>FECHA ACTIVACION</b>',
		'saldo'=>'<b>SALDO ACTUAL</b>',
		'winbox'=>'<b>WINBOX</b>',
		'mac_winbox'=>'<b>MAC WINBOX</b>',
		'plan_datos'=>'<b>PLAN DATOS</b>',
		'ip_asignada'=>'<b>IP ASIGNADA</b>',
		);
		
		//$config = array('id'=>array('width'=>70),'f_trans'=>array('width'=>120),'h_trans'=>array('width'=>120,'desc'=>array('width'=>70),'cargo'=>array('width'=>45),'saldo_an'=>array('width'=>85),'saldo_ac'=>array('width'=>75)));
		
		$config = array(
			'id_cliente'=>array('width'=>55),
			'nombre'=>array('width'=>120),
			'sucursal'=>array('width'=>70),
			'status'=>array('width'=>70),
			'tipo_status'=>array('width'=>100),
			'tipo_servicio'=>array('width'=>80),
			'activacion'=>array('width'=>65),
			'saldo'=>array('width'=>50),
			'winbox'=>array('width'=>20),
			'mac_winbox'=>array('width'=>40),
			'plan_datos'=>array('width'=>30),
			'ip_asignada'=>array('width'=>70),
		);
		
		
		$options = array(
			'shadeCol'=>array(0.9,0.9,0.9),
			'xOrientation'=>'center',
			'justification'=>'center',
			'fontSize'=>8,'titleFontSize' => 8,
			'cols'=>$config,
			'splitRows'=>'1');
		
		if($registro= mysqli_fetch_array($consulta))
		{
			do
			{
				$aux = array('id_cliente'=>$registro[0],'nombre'=>$registro[1],'sucursal'=>$registro[3],'status'=>$registro[4],'tipo_status'=>$registro[5],'tipo_servicio'=>$registro[6],'activacion'=>$registro[8],'saldo'=>$registro[13],'winbox'=>$registro[14],'mac_winbox'=>$registro[15],'plan_datos'=>$registro[16],'ip_asignada'=>$registro[17]);
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
		
		$pdf->ezText("                                       Reporte de Clientes", 13);
		$pdf->ezText("                                                   Generado: ".date("Y/m/d"), 10);
		$pdf->ezText("\n", 12);

		
		$pdf->addJpegFromFile("../imagenes/tuvision_logo.jpg","25","545","140");
		
		$pdf->restoreState(); 
		$pdf->closeObject(); 
		
		// observe que el objeto se puede decir que aparezca en pagina par, impar o todas cambiando ' 
		// 'all' por 'even' o 'odd' 
		$pdf->addObject($Plantilla,'all'); 
		
		/* Empezamos a poner los n�meros de p�gina */ 
		$pdf->ezStartPageNumbers(300,4,8,'',"<b>Fecha:</b> ".date("d/m/Y")." <b>Hora:</b> ".date("H:i:s")."  <b>Pagina</b> {PAGENUM} <b>de</b> {TOTALPAGENUM}",1); 	
		
		$pdf->ezTable($data, $titles, '',$options,600);
	

		$pdf->ezStream(array("Content-Disposition"=>$filename."_".date("d/m/Y").".pdf","compress"=>0));

?>