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
	
	$query = "select i.id_ingreso, i.id_cliente, i.monto_total,i.fecha,i.observaciones,i.folio_nota,concat(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno), s.nombre,i.recibo_fiscal from ingresos i, clientes c, sucursales s where s.id_sucursal=c.id_sucursal and c.id_cliente = i.id_cliente and i.id_ingreso='".addslashes($_POST['id_ingreso'])."'";
	
	$registro_ingreso = @devolverValorQuery($query);
	
	if($registro_ingreso[0]!="")
	{
		//OBTENEMOS LOS DATOS
		$id_ingreso = $registro_ingreso[0];
		$id_cliente	= $registro_ingreso[1];
		$monto_total= $registro_ingreso[2];
		$fecha 		= $registro_ingreso[3];
		$observaciones = $registro_ingreso[4];
		if($registro_ingreso[8]==null)
			{$folio 		= $registro_ingreso[5];}
		else
			{$folio=$registro_ingreso[8];}
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
			$pdf->addTextWrap (90,750+$y,440,8,"TU VISION TELECABLE SA DE CV","center");
			$pdf->addTextWrap (90,740+$y,440,8,"CALLE VENUSTIANO CARRANZA S/N.","center");
			$pdf->addTextWrap (90,730+$y,440,8,"COL. CENTRO","center");
			$pdf->addTextWrap (90,720+$y,440,8,"SANTA MARIA ZACATEPEC, OAXACA, CP 71050","center");
			$pdf->addTextWrap (90,710+$y,440,8,"TVT160908N51","center");
			$pdf->addTextWrap (90,700+$y,440,8,"Regimen: GENERAL DE LEY PERSONAS MORALES","center");
			$pdf->line(20,695+$y,590,695+$y);
			$pdf->line(180,695+$y,180,770+$y);
			$pdf->line(420,695+$y,420,770+$y);
			$pdf->addTextWrap (141,750+$y,440,10,"RECIBO DE PAGO",'right');
			$pdf->addTextWrap (141,735+$y,440,10,"FOLIO: <b>".$folio."</b>",'right');
			$pdf->addTextWrap (141,725+$y,440,8,"LUGAR: <b>".$sucursal."</b>",'right');
			
			$pdf->addTextWrap (25,680+$y,130,10,"NO. CLIENTE:",'left');
			$pdf->addTextWrap (25,665+$y,80,10,"NOMBRE:",'left');
			$pdf->addTextWrap (25,650+$y,130,10,"FECHA DE PAGO:",'left');
			$pdf->addTextWrap (130,680+$y,470,10,"<b>".$id_cliente."</b>",'left');
			$pdf->addTextWrap (130,665+$y,470,10,"<b>".$nombre."</b>",'left');
			$pdf->addTextWrap (130,650+$y,470,10,"<b>".strtoupper(transformarFecha($fecha))."</b>",'left');
			$pdf->line(20,645+$y,590,645+$y);
			
			//TOTAL
			$pdf->addTextWrap (480,555+$y,80,10,"<b>TOTAL: $</b>",'left');
			$pdf->addTextWrap (500,555+$y,80,10,"<b>".number_format($monto_total, 2, '.', ',')."</b>",'right');		
			$pdf->line(20,570+$y,590,570+$y);
			$pdf->line(20,545+$y,590,545+$y);
			
			$pdf->addTextWrap (25,555+$y,450,12,transformarCantidadLetras($monto_total)." M. N.",'center');	
			
			
			
			//CONCEPTOS
			
			$pdf->addTextWrap (25,630+$y,80,10,"CONCEPTO:",'left');		
			$pdf->addTextWrap (480,630+$y,80,10,"MONTO: <b>$</b>",'left');
			$pdf->addTextWrap (110,630+$y,400,10,"<b>".$concepto_principal."</b>",'left');
			if($promocion_principal!="")
				$pdf->addTextWrap (260,630+$y,200,10,$promocion_principal." ".$porcentaje_principal." %",'right');
			$pdf->addTextWrap (500,630+$y,80,10,"<b>".number_format($monto_principal, 2, '.', ',')."</b>",'right');
			
			
			
			//$pdf->setLineStyle(1,'','',array(5));
			$pdf->line(20,625+$y,590,625+$y);
			$pdf->addTextWrap (25,615+$y,90,10,"ADICIONALES:",'left');	;
			
			$total_adicionales = count($conceptos_adicionales);
			
			$y_adicionales = 615+$y;
			
			for($i=0;$i<$total_adicionales;$i++)
			{
				$pdf->addTextWrap (110,$y_adicionales,400,10,"<b>".$conceptos_adicionales[$i]['descripcion']."</b>",'left');
				if($conceptos_adicionales[$i]['promocion']!="")
					$pdf->addTextWrap (260,$y_adicionales,200,10,$conceptos_adicionales[$i]['promocion']." ".$conceptos_adicionales[$i]['porcentaje']." %",'right');
				$pdf->addTextWrap (515,$y_adicionales,80,10,"<b>$</b>",'left');
				$pdf->addTextWrap (500,$y_adicionales,80,10,"<b>".number_format($conceptos_adicionales[$i]['monto'], 2, '.', ',')."</b>",'right');				
				
				$y_adicionales-=15;
			}
			
			$pdf->line(20,485+$y,590,485+$y);
		
			//OBSERVACCIONES
			$pdf->addTextWrap (25,535+$y,120,8,"OBSERVACIONES:",'left');	;
			$pdf->ezSetY(533+$y);
			$pdf->ezText("<b>".strtoupper($observaciones)."</b>",8,array('justification'=>'full'));
			
			
				
			//NOTA
			$mensaje = devolverValorQuery("select descripcion from mensaje_nota");
			
			$pdf->ezSetY(475+$y);
			$pdf->ezText(strtoupper($mensaje[0]),7,array('justification'=>'center'));
			
			$y = -370;
			
			
		}
		
		
		$pdf->ezStream(array("Content-Disposition"=>"NOTA_".date("d/m/Y").".pdf","compress"=>0));
	}
	else
	{
		echo "No se puede imprimir esta nota";
	}
		
?>