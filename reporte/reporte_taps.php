<?php
		session_start();
		require_once('../pdf/class.ezpdf.php');
		require_once('../config.php');
		require_once('../conexion.php');
		require_once('../funciones.php');
		
		$pdf = new Cezpdf('letter','portrait');
		//$pdf->selectFont('../pdf/fonts/Helvetica.afm');
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
		

		if(isset($_POST['select'])){
			$identif = array_keys($_POST['select']);
					
		}
		
		if(addslashes($_GET['id'])){
			
		/*$query = "select
		id_reporte,
		(select nombre from sucursales where id_sucursal=(select id_sucursal from empleados where id_empleado=rep.id_empleado)),
		folio,
		fecha_reporte,
		id_cliente,
		(select concat(nombre,' ',apellido_paterno,' ',apellido_materno) from empleados where rep.id_empleado=id_empleado),
		fecha_atencion,
		(select concat(nombre,' ',apellido_paterno,' ',apellido_materno) from clientes where rep.id_cliente=id_cliente),
		(select nombre from cat_calles where id_calle=(select id_calle from clientes where rep.id_cliente=id_cliente)),
		(select concat('# ',numero,' (', referencia_casa,')') from clientes where rep.id_cliente=id_cliente),
		(select id_tap from tap where id_tap=(select id_tap from clientes where rep.id_cliente=id_cliente)),
		(select valor from tap where id_tap=(select id_tap from clientes where rep.id_cliente=id_cliente)),
		(select salidas from tap where id_tap=(select id_tap from clientes where rep.id_cliente=id_cliente)),
		descripcion_atencion,
		importe_inputable,
		nota_inputable,
		id_tipo_atencion
		from reporte_servicios rep where id_reporte = '".addslashes($_GET['id'])."'";
		*/
		
		}else{
/*
		$query = "select
		id_reporte,
		(select nombre from sucursales where id_sucursal=(select id_sucursal from empleados where id_empleado=rep.id_empleado)),
		folio,
		fecha_reporte,
		id_cliente,
		(select concat(nombre,' ',apellido_paterno,' ',apellido_materno) from empleados where rep.id_empleado=id_empleado),
		fecha_atencion,
		(select concat(nombre,' ',apellido_paterno,' ',apellido_materno) from clientes where rep.id_cliente=id_cliente),
		(select nombre from cat_calles where id_calle=(select id_calle from clientes where rep.id_cliente=id_cliente)),
		(select concat('# ',numero,' (', referencia_casa,')') from clientes where rep.id_cliente=id_cliente),
		(select id_tap from tap where id_tap=(select id_tap from clientes where rep.id_cliente=id_cliente)),
		(select valor from tap where id_tap=(select id_tap from clientes where rep.id_cliente=id_cliente)),
		(select salidas from tap where id_tap=(select id_tap from clientes where rep.id_cliente=id_cliente)),
		descripcion_atencion,
		importe_inputable,
		nota_inputable,
		id_tipo_atencion
		from reporte_servicios rep where id_reporte in (".implode(",",$identif).")";
		*/
		$query="select t.id_tap,s.nombre,c.nombre,t.poste,t.tipoposte,t.trayectoria,t.fibracoaxial,t.especificacioncable,t.delposte,t.alposte,t.distancia,t.peso,t.pesofabrica,t.latitud,t.longitud,t.zona from tap t,sucursales s,cat_calles c where t.id_sucursal=s.id_sucursal and t.calle=c.id_calle and t.id_tap in ('".implode("','",$identif)."')";
		}
		
		$res=mysqli_query($conexion,$query);
		
		$conta=0;
		while($registro=mysqli_fetch_array($res)){
			
		if($conta!=0)
		$pdf->ezNewPage();


				//parte de arriba
				
				$y=680;
				///////////////////////////////////////////
				$pdf->addTextWrap (10,740,300,14,"<b>TV CABLE TU VISION</b>");
				$pdf->addTextWrap (10,710,600,12,"<b>REPORTE TAP ".$registro[0]."</b>");
				$pdf->addTextWrap (10,$y,300,12,"ID :<b>".$registro[0]."</b>");
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"SUCURSAL <b>:".$registro[1]."</b>");
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"CALLE :<b>".$registro[2]."</b>");
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"POSTE #:<b>".$registro[3]."</b>");
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"TIPO DE POSTE :<b>".$registro[4]."</b>");
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"TRAYECTORIA :<b>".$registro[5]."</b>");
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"FIBRA / COAXIAL :<b>".$registro[6]."</b>");
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"ESPECIFICACION DEL CABLE :<b>".$registro[7]."</b>");
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"DEL POSTE :<b>".$registro[8]."</b>");
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"AL POSTE :<b>".$registro[9]."</b>");
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"DISTANCIA ENTRE POSTES:<b>".$registro[10]."</b>");
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"PESO KG/KM DE TRAYECTORIA:<b>".$registro[11]."</b>");
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"KG/KM DE FABRICA :<b>".$registro[12]."</b>");
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"LATITUD - LONGITUD:<b>".$registro[13]." - ".$registro[14]."</b>");
				$y=$y-20;
				$pdf->addTextWrap(10,$y,300,12,"ZONA :".$registro[15]);
				$y=$y-20;
				$pdf->addTextWrap (10,$y,300,12,"<b>- CLIENTES  EN  TAP -</b>");
				$y=$y-20;
				$query_t_u = "select * from clientes where id_tap='".$registro[0]."'";
					$tabla_t_u = mysqli_query($conexion,$query_t_u);
					while($registro_t_u = mysqli_fetch_array($tabla_t_u))
					{
						$pdf->addTextWrap (10,$y,300,12,$registro_t_u[0]." - ".$registro_t_u[4]." ".$registro_t_u[5]." ".$registro_t_u[6]);
						$y=$y-20;
						//echo "<tr><td>".$registro_t_u[0]." - ".$registro_t_u[4]." ".$registro_t_u[5]." ".$registro_t_u[6]."</td></tr>";
					}	

			
		$conta++;
		}
		$pdf->ezStream(array("Content-Disposition"=>"FORMATO_".date("d/m/Y").".pdf","compress"=>0));
