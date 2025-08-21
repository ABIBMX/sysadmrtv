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
		
		$consulta = mysqli_query($conexion,$_SESSION['tuvision_filtro_clientes_cobrar']);
			
		$titles = array(
		'id_cliente'=>'<b>ID CLIENTE</b>',
		'nombre'=>'<b>NOMBRE</b>',
		'telefono'=>'<b>TELEFONO</b>',
		'sucursal'=>'<b>SUCURSAL</b>',
		'calle'=>'<b>CALLE</b>',
		'numero'=>'<b>NO.</b>',
		'tap'=>'<b>ID TAP</b>',
		'referencia'=>'<b>REFERENCIA</b>',
		'saldo'=>'<b>SALDO</b>',
		'status'=>'<b>STATUS</b>',
		'tipo_contratacion'=>'<b>TIPO SERVICIO</b>'
		);
		
		//$config = array('id'=>array('width'=>70),'f_trans'=>array('width'=>120),'h_trans'=>array('width'=>120,'desc'=>array('width'=>70),'cargo'=>array('width'=>45),'saldo_an'=>array('width'=>85),'saldo_ac'=>array('width'=>75)));
		$config = array(
			'id_cliente'=>array('width'=>60),
			'nombre'=>array('width'=>150),
			'telefono'=>array('width'=>60),
			'sucursal'=>array('width'=>70),
			'calle'=>array('width'=>70),
			'numero'=>array('width'=>30),
			'tap'=>array('width'=>40),
			'referencia'=>array('width'=>100),
			'saldo'=>array('width'=>40),
			'status'=>array('width'=>70),
			'tipo_contratacion'=>array('width'=>80)
		);
		
		$options = array(
			'shadeCol'=>array(0.9,0.9,0.9),
			'xOrientation'=>'center',
			'justification'=>'center',
			'fontSize'=>8,
			'titleFontSize' => 8,
			'cols'=>$config,
			'splitRows'=>'1'
		);
		
		if($registro= mysqli_fetch_array($consulta))
		{
			do
			{
				$aux = array('id_cliente'=>$registro[0],'nombre'=>$registro[1],'telefono'=>$registro[2],'sucursal'=>$registro[3],'calle'=>$registro[4],'numero'=>$registro[5],'tap'=>$registro[6],'referencia'=>$registro[7],'saldo'=>$registro[8],'status'=>$registro[9],'tipo_contratacion'=>$registro[10]);
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
		
		$pdf->ezText("                                       Reporte de Clientes a Cobrar", 13);
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