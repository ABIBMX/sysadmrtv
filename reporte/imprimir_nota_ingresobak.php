<?php
	require_once('../pdf/class.ezpdf.php');
	require_once('../config.php');
	require_once('../conexion.php');
	require_once('../funciones.php');
	
	$pdf = new Cezpdf('letter','portrait');
	
	//$tmp = array('b'=>'Arial-Bold.afm');
	//$pdf->setFontFamily('Arial.afm',$tmp);	
	$pdf->selectFont('../pdf/fonts/Courier.afm');
	
	$pdf->ezSetCmMargins(1,1,1,1);
		
	
	/* Creamos un objeto que posteriormente pondremos en todas las páginas del documento */ 
	$Plantilla = $pdf->openObject(); 
	$pdf->saveState(); 
	
	$pdf->restoreState(); 
	$pdf->closeObject(); 
	
	// observe que el objeto se puede decir que aparezca en pagina par, impar o todas cambiando ' 
	// 'all' por 'even' o 'odd' 
	$pdf->addObject($Plantilla,'all'); 
	
	/* Empezamos a poner los números de página 
	$pdf->ezStartPageNumbers(600,15,6,'',"CALZADA CD. DEPORTIVA S/N UNIDAD ADMVA.",1); */
	
	$query = "select i.id_ingreso, i.id_cliente, i.monto_total,i.fecha,i.observaciones,i.folio_nota,concat(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno), s.nombre from ingresos i, clientes c, sucursales s where s.id_sucursal=c.id_sucursal and c.id_cliente = i.id_cliente and i.id_ingreso='".addslashes($_POST['id_ingreso'])."'";
	
	$registro_ingreso = @devolverValorQuery($query);
	
	if($registro_ingreso[0]!="")
	{
		//OBTENEMOS LOS DATOS
		$id_ingreso = $registro_ingreso[0];
		$id_cliente	= $registro_ingreso[1];
		$monto_total= $registro_ingreso[2];
		$fecha 		= $registro_ingreso[3];
		$observaciones = $registro_ingreso[4];
		$folio 		= $registro_ingreso[5];
		$nombre		= $registro_ingreso[6];
		$sucursal 	= $registro_ingreso[7];
		
		$query = "select i.descripcion, m.monto, m.es_adicional, (select p.descripcion from promociones p, monto_promocion mp where mp.id_promocion=p.id_promocion and mp.id_monto=m.id_monto), (select p.porcentaje from promociones p, monto_promocion mp where mp.id_promocion=p.id_promocion and mp.id_monto=m.id_monto) from montos m, cat_tipo_ingreso i where i.id_tipo_ingreso=m.id_tipo_ingreso and m.id_ingreso=".$id_ingreso;
		$tabla = mysqli_query($conexion,$query);
		$conceptos_adicionales = array();
		//echo count($conceptos_adicionales);
		while($registro_montos = mysqli_fetch_array($tabla))
		{
			if($registro_montos[2]==0)
			{
				$concepto_principal = $registro_montos[0];
				$monto_principal = $registro_montos[1];
				$promocion_principal = $registro_montos[3];
				$porcentaje_principal = $registro_montos[4];
			}
			else
			{
				if($registro_montos[3]!="")
					$var =array('descripcion'=>$registro_montos[0],'monto'=>$registro_montos[1],'promocion'=>$registro_montos[3],'porcentaje'=>$registro_montos[4]);
				else
					$var =array('descripcion'=>$registro_montos[0],'monto'=>$registro_montos[1],'promocion'=>'','porcentaje'=>'');
				$conceptos_adicionales[] = $var;
				
			}
		}
		
		$y=-20;
		for($j=0;$j<2;$j++)
		{
			//$pdf->setLineStyle(1);
			//ENCABEZADO
			$pdf->rectangle(20,420+$y,570,350);
			$pdf->addJpegFromFile("../imagenes/tuvision_logo.jpg",21,720+$y,140);
			$pdf->addTextWrap (141,750+$y,440,12,"RECIBO DE PAGO",'right');
			$pdf->addTextWrap (141,735+$y,440,12,"FOLIO: <b>".$folio."</b>",'right');
			$pdf->addTextWrap (141,725+$y,440,12,"LUGAR: <b>".$sucursal."</b>",'right');
			
			$pdf->addTextWrap (25,700+$y,80,12,"NO. CLIENTE:",'left');
			$pdf->addTextWrap (25,685+$y,80,12,"NOMBRE:",'left');
			$pdf->addTextWrap (25,670+$y,130,12,"FECHA DE PAGO:",'left');
			$pdf->addTextWrap (130,700+$y,470,12,"<b>".$id_cliente."</b>",'left');
			$pdf->addTextWrap (130,685+$y,470,12,"<b>".$nombre."</b>",'left');
			$pdf->addTextWrap (130,670+$y,470,12,"<b>".strtoupper(transformarFecha($fecha))."</b>",'left');
			$pdf->line(20,665+$y,590,665+$y);
			
			//TOTAL
			$pdf->addTextWrap (480,555+$y,80,12,"<b>TOTAL: $</b>",'left');
			$pdf->addTextWrap (500,555+$y,80,12,"<b>".number_format($monto_total, 2, '.', ',')."</b>",'right');		
			$pdf->line(20,570+$y,590,570+$y);
			$pdf->line(20,545+$y,590,545+$y);
			
			$pdf->addTextWrap (25,555+$y,450,12,transformarCantidadLetras($monto_total)." M. N.",'center');	
			
			
			
			//CONCEPTOS
			
			$pdf->addTextWrap (25,650+$y,80,12,"CONCEPTO:",'left');		
			$pdf->addTextWrap (480,650+$y,80,12,"MONTO: <b>$</b>",'left');
			$pdf->addTextWrap (110,650+$y,400,12,"<b>".$concepto_principal."</b>",'left');
			if($promocion_principal!="")
				$pdf->addTextWrap (260,650+$y,200,12,$promocion_principal." ".$porcentaje_principal." %",'right');
			$pdf->addTextWrap (500,650+$y,80,12,"<b>".number_format($monto_principal, 2, '.', ',')."</b>",'right');
			
			
			
			//$pdf->setLineStyle(1,'','',array(5));
			$pdf->line(20,640+$y,590,640+$y);
			$pdf->addTextWrap (25,625+$y,90,12,"ADICIONALES:",'left');	;
			
			$total_adicionales = count($conceptos_adicionales);
			
			$y_adicionales = 625+$y;
			
			for($i=0;$i<$total_adicionales;$i++)
			{
				$pdf->addTextWrap (110,$y_adicionales,400,12,"<b>".$conceptos_adicionales[$i]['descripcion']."</b>",'left');
				if($conceptos_adicionales[$i]['promocion']!="")
					$pdf->addTextWrap (260,$y_adicionales,200,12,$conceptos_adicionales[$i]['promocion']." ".$conceptos_adicionales[$i]['porcentaje']." %",'right');
				$pdf->addTextWrap (515,$y_adicionales,80,12,"<b>$</b>",'left');
				$pdf->addTextWrap (500,$y_adicionales,80,12,"<b>".number_format($conceptos_adicionales[$i]['monto'], 2, '.', ',')."</b>",'right');				
				
				$y_adicionales-=15;
			}
			
			$pdf->line(20,485+$y,590,485+$y);
		
			//OBSERVACCIONES
			$pdf->addTextWrap (25,535+$y,120,12,"OBSERVACIONES:",'left');	;
			$pdf->ezSetY(533+$y);
			$pdf->ezText("<b>".strtoupper($observaciones)."</b>",12,array('justification'=>'full'));
			
			
				
			//NOTA
			$mensaje = devolverValorQuery("select descripcion from mensaje_nota");
			
			$pdf->ezSetY(475+$y);
			$pdf->ezText(strtoupper($mensaje[0]),12,array('justification'=>'center'));
			
			$y = -370;
			
			
		}
		
		
		$pdf->ezStream(array("Content-Disposition"=>"NOTA_".date("d/m/Y").".pdf","compress"=>0));
	}
	else
	{
		echo "No se puede imprimir esta nota";
	}
		
?>