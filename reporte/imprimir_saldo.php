<?php

		require_once('../pdf/class.ezpdf.php');
		require_once('../config.php');
		require_once('../conexion.php');
		require_once('../funciones.php');

		$pdf = new Cezpdf('letter','portrait');
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
		
		
		$id_cliente = addslashes($_POST['id_cliente']);
		
		
		$cliente = "select nombre from sucursales where id_sucursal=(select id_sucursal from clientes where id_cliente='$id_cliente')";
		$res = mysqli_query($conexion,$cliente);
		list($nombre_sucursal)=mysqli_fetch_array($res);
		
		$reporte_saldo = "select t.id_cliente,concat(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno),t.saldo_anterior,t.saldo_actual from transacciones t, clientes c where c.id_cliente=t.id_cliente and t.id_cliente='".$id_cliente."' order by fecha_transaccion desc, id_transaccion desc limit 1";
		$consulta = mysqli_query($conexion,$reporte_saldo);
		
		$titles = array(
		'id'=>'<b>ID CLIENTE</b>',
		'name'=>'<b>NOMBRE DE CLIENTE</b>',
		'saldo_an'=>'<b>SALDO ANTERIOR</b>',
		'saldo_ac'=>'<b>SALDO ACTUAL</b>'
		);
		
		$config = array('id'=>array('width'=>70),'name'=>array('width'=>320),'saldo_an'=>array('width'=>85),'saldo_ac'=>array('width'=>75));
		
		$options = array('shadeCol'=>array(0.9,0.9,0.9),'xOrientation'=>'center','justification'=>'center','fontSize'=>8,'titleFontSize' => 8,'cols'=>$config,'splitRows'=>'1');
		
		if($registro= mysqli_fetch_array($consulta))
		{
			do
			{
				$aux = array();
				$contador = 0;
				foreach($titles as $variable => $valor)
				{
					if($numeros[$contador]==1)
						$aux[$variable] = convertirNumero($registro[$contador]);	
					else if($numeros[$contador]==2)
						$aux[$variable] = convertirPrecio($registro[$contador]);	
					else	
						$aux[$variable] = $registro[$contador];	
					$contador++;
				}
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
		
		$pdf->ezText("                                  Sucursal : ".$nombre_sucursal, 12);
		$pdf->ezText("                                  Fecha     : ".date("Y/m/d"), 12);
		$pdf->ezText("\n", 12);

		
		$pdf->addJpegFromFile("../imagenes/tuvision_logo.jpg","0","720","140");
		
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