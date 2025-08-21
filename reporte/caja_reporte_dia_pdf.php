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
			
		$config = array('ingresos'=>array('align'=>'right'),'egresos'=>array('align'=>'right'),'depositos'=>array('align'=>'right'),'caja_anterior'=>array('align'=>'right'),'caja_actual'=>array('align'=>'right'));
		
		$options = array('shadeCol'=>array(0.9,0.9,0.9),'xOrientation'=>'center','justification'=>'center','fontSize'=>8,'titleFontSize' => 8,'cols'=>$config,'splitRows'=>'1');
		
		if(isset($_SESSION['tuvision_id_sucursal']))
			$add_query = " where id_sucursal='".$_SESSION['tuvision_id_sucursal']."'";
		else
		{
			$total_ingresos = $total_egresos = $total_depositos = $total_caja = 0.0;
		}
		
		
		$titles = array(
		'sucursal'=>'<b>SUCURSAL</b>',
		'ingresos'=>'<b>INGRESOS</b>',
		'egresos'=>'<b>EGRESOS</b>',
		'depositos'=>'<b>DEPOSITOS</b>',
		'caja_anterior'=>'<b>CAJA ANTERIOR</b>',
		'caja_actual'=>'<b>CAJA ACTUAL</b>'
		);
		
		$tabla = mysqli_query($conexion,"select * from sucursales ".$add_query);
		
		while(list($id,$sucursal) = mysqli_fetch_array($tabla))
		{
			$query =  "select  (select sum(cantidad) from cajas where id_sucursal=c.id_sucursal and id_tipo_operacion=1 and fecha_operacion=current_date()), (select sum(cantidad) from cajas where id_sucursal=c.id_sucursal and id_tipo_operacion=2 and fecha_operacion=current_date()),(select sum(cantidad) from cajas where id_sucursal=c.id_sucursal and id_tipo_operacion=3 and fecha_operacion=current_date()),c.caja_anterior, c.caja_actual from cajas c where c.id_sucursal='".addslashes($id)."' order by fecha_operacion desc, id_caja desc limit 1";
								
			
			$caja = devolverValorQuery($query);
			
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			if($caja[0]=="")
				$caja[0] = "0.00";
			if($caja[1]=="")
				$caja[1] = "0.00";
			if($caja[2]=="")
				$caja[2] = "0.00";
			
			if($caja[3]=="")
			{
				$caja[3]="0.00";$caja[4]="0.00";
			}
			
			$total_ingresos += $caja[0];
			$total_egresos += $caja[1];
			$total_depositos += $caja[2];
			$total_caja += $caja[4];
			
			$aux = array('sucursal'=>$sucursal,'ingresos'=>number_format($caja[0],2, '.', ','),'egresos'=>number_format($caja[1],2, '.', ','),'depositos'=>number_format($caja[2],2, '.', ','),'caja_anterior'=>number_format($caja[3],2, '.', ','),'caja_actual'=>number_format($caja[4],2, '.', ','));
			$data[] = $aux;
		}
		
		if(!isset($_SESSION['tuvision_id_sucursal']))
		{
			$aux = array('sucursal'=>"<b>TOTALES</b>",'ingresos'=>"<b>".number_format($total_ingresos,2, '.', ',')."</b>",'egresos'=>"<b>".number_format($total_egresos,2, '.', ',')."</b>",'depositos'=>"<b>".number_format($total_depositos,2, '.', ',')."</b>",'caja_anterior'=>"",'caja_actual'=>"<b>".number_format($total_caja,2, '.', ',')."</b>");
			$data[] = $aux;
		}
		
		$Plantilla = $pdf->openObject(); 
		$pdf->saveState(); 
		
		$pdf->ezText("                                       Reporte del Dia de Caja", 13);
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