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
		$id_servicio=addslashes($_GET['id']);
		
		/* Empezamos a poner los números de página 
		$pdf->ezStartPageNumbers(600,15,6,'',"CALZADA CD. DEPORTIVA S/N UNIDAD ADMVA.",1); */
		
		if(isset($_POST['select'])){
			$identif = array_keys($_POST['select']);
			
		}
		
		if(addslashes($_GET['id'])){
			$id_servicio=addslashes($_GET['id']);
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
		from reporte_servicios rep where id_reporte = '".addslashes($_GET['id'])."'";
		
		}else{
			$id_servicio=addslashes($_GET['id']);
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
		id_tipo_atencion,
		id_empleado
		from reporte_servicios rep where id_reporte in (".implode(",",$identif).")";
		}
		$res=mysqli_query($conexion,$query);
		$conta=0;
		
		while(list($reporte,$sucursal,$folio,$f_reporte,$cliente,$nom_emp,$f_atencion,$nom_cli,$dom_cli,$ref,$id_tap,$tap_valor,$tap_sal,$des_aten,$importe,$nota,$atencion)=mysqli_fetch_array($res)){
		if($conta!=0)
		$pdf->ezNewPage();

		

				//parte de arriba
				$pdf->addTextWrap (10,760,300,20,"REPORTE ");
				$pdf->addTextWrap (40,740,300,20,"DE");
				$pdf->addTextWrap (10,720,300,20,"SERVICIO");
				
				
				$pdf->addTextWrap (120,750,300,15,"TV CABLE TU VISION");
				$pdf->addTextWrap (120,735,300,9,"CONTROL DE REPORTES DE SERVICIOS");
				$pdf->addTextWrap (120,720,300,12,"".$sucursal);
				
				
				$pdf->addTextWrap (360,760,300,12,"Folio:");
				$pdf->addTextWrap (360,750,300,12,"F. Rep:");
				$pdf->addTextWrap (360,740,300,12,"No. Cte:");
				$pdf->addTextWrap (360,730,300,12,"Empleado:");
				$pdf->addTextWrap (360,720,300,12,"F. At:");
				
				
				////////////////DATOS
				$pdf->addTextWrap (430,760,300,12,"".$folio."");
				$pdf->addTextWrap (430,750,300,12,"".$f_reporte."");
				$pdf->addTextWrap (430,740,300,12,"".$cliente."");
				$pdf->addTextWrap (430,730,300,12,"".$nom_emp."");
				$pdf->addTextWrap (430,720,300,12,"".$f_atencion."");
				//////////////////////////
				
				///////////////////////////////////////////
				$pdf->addTextWrap (10,700,300,12,"<b>DATOS GENERALES DEL SUSCRIPTOR:</b>");
				$pdf->addTextWrap (10,685,300,12,"NOMBRE:");
				
				$pdf->addTextWrap (10,670,300,12,"DOMICILIO:");
				
				////////////////DATOS
				$pdf->addTextWrap (80,685,300,12,"".$nom_cli."");
				$pdf->addTextWrap (80,670,300,12,"".$dom_cli." ".$ref);
				//////////////////////////
				//////////////////////////////////////////
				
				
				///////////////////////////////////////////
				$pdf->addTextWrap (10,645,300,12,"<b>TIPO DE SERVICIO QUE REPORTA:</b>");
				
				////////////////DATOS
				$query_serv = "select descripcion from cat_tipo_servicios where id_tipo_servicio in (select id_tipo_servicio from cliente_servicios where id_reporte='$reporte')";
					$res_serv=mysqli_query($conexion,$query_serv);
					
					$lista_serv=array();
					$titles=array();
					$conta=0;
					$indice=0;
					while(list($servicios)=mysqli_fetch_array($res_serv)){
						//$lista_serv[$indice][$conta]=$servicio;
						
						$lista_serv [$conta]["servicio".$indice]  = $servicios; 
						if($conta==3){
							$conta=0;
							$indice++;
						}
						$conta++;
					}
					$pdf->y=640;
					
					$titles=array('servicio0'=>'','servicio1'=>'','servicio2'=>'');
					
					$pdf->ezTable($lista_serv,$titles,'',array('showHeadings'=>0,'shaded'=>0,'xPos'=>610,'fontSize'=>12,'xOrientation'=>'left','width'=>100,'lineCol'=>array(1,1,1),'cols'=>array('servicio0'=>array('width'=>200),'servicio1'=>array('width'=>200),'servicio2'=>array('width'=>200))));
				
				////////////////////
				
				
				///////////////////////////////////////////
				
				
				///////////////////////////////////////////
				$pdf->addTextWrap (10,450,300,12,"Id tap:");
				$pdf->addTextWrap (110,450,300,12,"Valor:");
				$pdf->addTextWrap (210,450,300,12,"Salida:");
				//$pdf->addTextWrap (310,450,300,12,"# Poste:");
				
				////////////////DATOS
				$pdf->addTextWrap (60,450,300,12,"".$id_tap."");
				$pdf->addTextWrap (155,450,300,12,"".$tap_valor."");
				$pdf->addTextWrap (260,450,300,12,"".$tap_sal."");
				//$pdf->addTextWrap (320,450,300,8,$nom_emp);
				
				//////////////////////////
				///////////////////////////////////////////


				///////////////////////////////////////////
				$pdf->addTextWrap (10,430,300,12,"<b>DESCRIPCION DE LA ATENCION DEL SERVICIO:</b>");
				
				////////////////DATOS
				$pdf->y=430;
				$datos [0]["desc"]  = $des_aten;
				
				$pdf->ezTable($datos,'','',array('showHeadings'=>0,'shaded'=>0,'xPos'=>600,'fontSize'=>12,'xOrientation'=>'left','width'=>590,'lineCol'=>array(1,1,1)));
				

				//$pdf->addTextWrap (10,410,300,8,$des_aten);

				//////////////////////////
				///////////////////////////////////////////
				
				///////////////////////////////////////////
				$pdf->addTextWrap (10,330,330,10,"LISTA DE MATERIALES UTILIZADOS NUEVOS:");
				$pdf->addTextWrap (300,330,300,10,"LISTA DE MATERIALES REEMPLAZADOS:");
				
				////////////////DATOS
					$query_serv = "select (select descripcion from cat_equipos_inventario where id_equipo_inventario=m.nom_bueno),cantidad_bueno,(select descripcion from cat_equipos_inventario where id_equipo_inventario=m.nom_reemplazo),cantidad_reemplazo,comentario from material m where id_reporte='$reporte'";
					$res_serv=mysqli_query($conexion,$query_serv);
					
					$lista_serv=array();
					$titles=array();
					$conta=0;
					$indice=0;
					while(list($nom_b,$cant_b,$nom_r,$cant_r,$comen)=mysqli_fetch_array($res_serv)){
						//$lista_serv[$indice][$conta]=$servicio;
						
						$lista_serv [$conta]["material0"]  = $nom_b; 
						$lista_serv [$conta]["material1"]  = $cant_b; 
						$lista_serv [$conta]["material2"]  = $nom_r; 
						$lista_serv [$conta]["material3"]  = $cant_r; 
						$lista_serv [$conta]["material4"]  = $comen; 
						
						$conta++;
					}
					$pdf->y=320;
					
					$titles=array('material0'=>'NOMBRE','material1'=>'CANT.','material2'=>'NOMBRE','material3'=>'CANT.','material4'=>'COMENTARIO');
					
					$pdf->ezTable($lista_serv,$titles,'',array('showHeadings'=>1,'shaded'=>0,'xPos'=>610,'fontSize'=>8,'xOrientation'=>'left','width'=>100,'lineCol'=>array(1,1,1),'cols'=>array('material0'=>array('width'=>175),'material1'=>array('width'=>45),'material2'=>array('width'=>150),'material3'=>array('width'=>45),'material4'=>array('width'=>185))));
				
				
				
				//////////////////////////////////////////
				
				///////////////////////////////////////////
				$pdf->addTextWrap (10,230,600,12,"IMPORTE POR SERVICIO");
				$pdf->addTextWrap (10,215,300,12,"IMPORTE:");
				$pdf->addTextWrap (10,200,300,12,"# NOTA");
				
				////////////////DATOS
				$pdf->addTextWrap (70,215,300,12,""."$ ".$importe."");
				$pdf->addTextWrap (70,200,300,12,"".$nota."");
				
				//////////////////////////
				
				///////////////////////////////////////////
				
				///////////////////////////////////////////
				$pdf->addTextWrap (30,180,300,12,utf8_decode('INDICAR CON UNA "X" EL TIPO DE ATENCION RECIBIDO POR EL TECNICO'));				
				$pdf->addTextWrap (30,140,300,12,utf8_decode('EXCELENTE'));
				$pdf->addTextWrap (190,140,300,12,utf8_decode('BUENO'));				
				$pdf->addTextWrap (350,140,300,12,utf8_decode('REGULAR'));				
				$pdf->addTextWrap (510,140,300,12,utf8_decode('MALO'));	
				
				$pdf->rectangle(15,95,80,80);
				$pdf->rectangle(165,95,80,80);
				$pdf->rectangle(330,95,80,80);
				$pdf->rectangle(485,95,80,80);
				
				//////////////////////DATOS
				if($atencion==1)
				$pdf->addTextWrap (60,150,300,15,"<b>X</b>");	
				else if($atencion==2)
				$pdf->addTextWrap (210,150,300,15,"<b>X</b>");	
				else if($atencion==3)
				$pdf->addTextWrap (375,150,300,15,"<b>X</b>");	
				else if($atencion==4)
				$pdf->addTextWrap (525,150,300,15,"<b>X</b>");	
				//////////////////////DATOS
				
				///////////////////////////////////////////
				
				///////////////////////////////////////////
			
				$rutacliente="../../api/public/storage/upload/servicios/".$reporte.".jpg";
				$rutatecnico="../../api/public/storage/upload/servicios/".$reporte."-tecnico.jpg";
				$pdf->addJpegFromFile($rutacliente,100,55,50); //// firma del cliente
				$pdf->addJpegFromFile($rutatecnico,430,55,50); //// servicios/".$id_servicio."-tecnico.jpg",410,55,90); //// firma del tecnico
				$pdf->addTextWrap (50,30,300,12,utf8_decode("NOMBRE Y FIRMA DEL CLIENTE"));				
				$pdf->addTextWrap (370,30,300,12,utf8_decode('NOMBRE Y FIRMA DEL TECNICO'));				
				
				
				////////////////DATOS
				$pdf->addTextWrap (60,40,300,12,"".$nom_cli."");
				$pdf->addTextWrap(400,40,300,12,"".$nom_emp."");
				//////////////////////////
				/////////////////////////////////////////////////////////7
				

			
		$conta++;
		}
		$pdf->ezStream(array("Content-Disposition"=>"FORMATO_".date("d/m/Y").".pdf","compress"=>0));