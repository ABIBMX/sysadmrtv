<?php
		session_start();
		require_once('../pdf/class.ezpdf.php');
		require_once('../config.php');
		require_once('../conexion.php');
		require_once('../funciones.php');
		
		$pdf = new Cezpdf('letter','portrait');
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
		
		/* Empezamos a poner los números de página 
		$pdf->ezStartPageNumbers(600,15,6,'',"CALZADA CD. DEPORTIVA S/N UNIDAD ADMVA.",1); */
		
		if(isset($_POST['select'])){
			$identif = array_keys($_POST['select']);
		}
		
		if(addslashes($_GET['id'])){
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
				
				
				$pdf->addTextWrap (120,750,300,15,"TU VISION TELECABLE");
				$pdf->addTextWrap (120,735,300,8,"CONTROL DE REPORTES DE SERVICIOS Y FALLAS");
				$pdf->addTextWrap (120,720,300,8,"".$sucursal);
				
				
				$pdf->addTextWrap (360,760,300,8,"Folio:");
				$pdf->addTextWrap (360,750,300,8,"Fecha de Reporte:");
				$pdf->addTextWrap (360,740,300,8,"No. de Cliente:");
				$pdf->addTextWrap (360,730,300,8,"Nombre recibido solicitud:");
				$pdf->addTextWrap (360,720,300,8,"Fecha de Atencion:");
				
				
				////////////////DATOS
				$pdf->addTextWrap (470,760,300,8,"".$folio."");
				$pdf->addTextWrap (470,750,300,8,"".$f_reporte."");
				$pdf->addTextWrap (470,740,300,8,"".$cliente."");
				$pdf->addTextWrap (470,730,300,8,"".$nom_emp."");
				$pdf->addTextWrap (470,720,300,8,"".$f_atencion."");
				//////////////////////////
				
				///////////////////////////////////////////
				$pdf->addTextWrap (10,700,300,8,"DATOS GENERALES DEL SUSCRIPTOR:");
				$pdf->addTextWrap (10,690,300,8,"NOMBRE:");
				
				$pdf->addTextWrap (10,670,300,8,"DOMICILIO:");
				
				////////////////DATOS
				$pdf->addTextWrap (80,690,300,8,"".$nom_cli."");
				$pdf->addTextWrap (80,670,300,8,"".$dom_cli." ".$ref);
				//////////////////////////
				//////////////////////////////////////////
				
				
				///////////////////////////////////////////
				$pdf->addTextWrap (10,650,300,8,"TIPO DE SERVICIO QUE REPORTA:");
				
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
				$pdf->addTextWrap (10,450,300,8,"Id tap:");
				$pdf->addTextWrap (110,450,300,8,"Valor:");
				$pdf->addTextWrap (210,450,300,8,"Salida:");
				$pdf->addTextWrap (310,450,300,8,"# Poste:");
				
				////////////////DATOS
				$pdf->addTextWrap (40,450,300,8,"".$id_tap."");
				$pdf->addTextWrap (140,450,300,8,"".$tap_valor."");
				$pdf->addTextWrap (240,450,300,8,"".$tap_sal."");
				//$pdf->addTextWrap (320,450,300,8,$nom_emp);
				
				//////////////////////////
				///////////////////////////////////////////


				///////////////////////////////////////////
				$pdf->addTextWrap (10,430,300,8,"DESCRIPCION DE LA ATENCION DEL SERVICIO:");
				
				////////////////DATOS
				$pdf->y=430;
				$datos [0]["desc"]  = $des_aten;
				
				$pdf->ezTable($datos,'','',array('showHeadings'=>0,'shaded'=>0,'xPos'=>600,'fontSize'=>12,'xOrientation'=>'left','width'=>590,'lineCol'=>array(1,1,1)));
				

				//$pdf->addTextWrap (10,410,300,8,$des_aten);

				//////////////////////////
				///////////////////////////////////////////
				
				///////////////////////////////////////////
				$pdf->addTextWrap (10,330,300,6,"LISTA DE MATERIALES UTILIZADOS NUEVOS O EN BUEN ESTADO:");
				$pdf->addTextWrap (290,330,300,6,"LISTA DE MATERIALES REEMPLAZADOS:");
				
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
					
					$titles=array('material0'=>'NOMBRE','material1'=>'CANTIDAD','material2'=>'NOMBRE','material3'=>'CANTIDAD','material4'=>'COMENTARIO');
					
					$pdf->ezTable($lista_serv,$titles,'',array('showHeadings'=>1,'shaded'=>0,'xPos'=>610,'fontSize'=>6,'xOrientation'=>'left','width'=>100,'lineCol'=>array(1,1,1),'cols'=>array('material0'=>array('width'=>175),'material1'=>array('width'=>45),'material2'=>array('width'=>150),'material3'=>array('width'=>45),'material4'=>array('width'=>185))));
				
				
				
				//////////////////////////////////////////
				
				///////////////////////////////////////////
				$pdf->addTextWrap (10,230,300,8,"EN CASO QUE EL SERVICIO O FALLA SEA IMPUTABLE AL CLIENTE ANOTAR EL IMPORTE POR EL COBRO DEL MATERIAL.");
				$pdf->addTextWrap (10,215,300,8,"IMPORTE:");
				$pdf->addTextWrap (10,200,300,8,"# NOMBRE DEL TECNICO:");
				
				////////////////DATOS
				$pdf->addTextWrap (70,215,300,8,""."$ ".$importe."");
				$pdf->addTextWrap (70,200,300,8,"".$nota."");
				
				//////////////////////////
				
				///////////////////////////////////////////
				
				///////////////////////////////////////////
				$pdf->addTextWrap (30,180,300,8,utf8_decode('INDICAR CON UNA "X" EL TIPO DE ATENCION RECIBIDO POR EL TECNICO'));				
				$pdf->addTextWrap (30,100,300,8,utf8_decode('EXCELENTE'));
				$pdf->addTextWrap (190,100,300,8,utf8_decode('BUENO'));				
				$pdf->addTextWrap (350,100,300,8,utf8_decode('REGULAR'));				
				$pdf->addTextWrap (510,100,300,8,utf8_decode('MALO'));	
				
				$pdf->rectangle(15,95,80,80);
				$pdf->rectangle(165,95,80,80);
				$pdf->rectangle(330,95,80,80);
				$pdf->rectangle(485,95,80,80);
				
				//////////////////////DATOS
				if($atencion==1)
				$pdf->addTextWrap (40,110,300,48,"X");	
				else if($atencion==2)
				$pdf->addTextWrap (190,110,300,48,"X");	
				else if($atencion==3)
				$pdf->addTextWrap (355,110,300,48,"X");	
				else if($atencion==4)
				$pdf->addTextWrap (505,110,300,48,"X");	
				//////////////////////DATOS
				
				///////////////////////////////////////////
				
				///////////////////////////////////////////
				$pdf->addTextWrap (50,30,300,8,utf8_decode('NOMBRE Y FIRMA DEL CLIENTE'));				
				$pdf->addTextWrap (370,30,300,8,utf8_decode('NOMBRE Y FIRMA DEL TECNICO'));				
				
				
				////////////////DATOS
				$pdf->addTextWrap (60,40,300,8,"".$nom_cli."");
				//////////////////////////
				/////////////////////////////////////////////////////////7
				

			
		$conta++;
		}
		$pdf->ezStream(array("Content-Disposition"=>"FORMATO_".date("d/m/Y").".pdf","compress"=>0));