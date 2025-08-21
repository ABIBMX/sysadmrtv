<?php
	session_start();
	include("config.php");
	include("conexion.php");
	include("funciones.php");
	if(isset($_GET['sesion']) && $_GET['sesion']=="cerrar")
	{
		unset($_SESSION['tuvision_usuario']);
		unset($_SESSION['tuvision_tipo_usuario']);
		unset($_SESSION['tuvision_id_empleado']);
		unset($_SESSION['tuvision_id_sucursal']);
		unset($_SESSION['filtro_reporte_servicio']);
		unset($_SESSION['filtro_tuvision_facturas_addquery']);
	}
	if(isset($_POST['tuvision_usuario'])&&!isset($_SESSION['tuvision_usuario']))
	{
		$query= "select id_usuario from usuario where id_usuario='".addslashes($_POST['tuvision_usuario'])."' and password='".addslashes($_POST['md5password'])."'";
		
		if(cantidadRegistros($query)>0)
		{
			
			$registro = devolverValorQuery("select u.id_usuario,u.id_tipo_usuario, u.id_empleado, e.id_sucursal from usuario u, empleados e where u.id_empleado=e.id_empleado and u.id_usuario='".addslashes($_POST['tuvision_usuario'])."'");
			$_SESSION['tuvision_usuario'] =$registro[0];
			$_SESSION['tuvision_tipo_usuario'] = $registro[1];
			$_SESSION['tuvision_id_empleado'] =$registro[2];
			if( $registro[1] != "1")
				$_SESSION['tuvision_id_sucursal'] = $registro[3];
		}
		else
		{
			$bandera = true;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"DTD/xhtml1-strict.dtd">
<html>
<head  xmlns="http://www.w3.org/1999/xhtml">
	<script type="text/javascript" src="jquery-1.3.2.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="jquery.backgroundPosition.js"></script>
    <link rel="stylesheet" type="text/css" href="css/estilos.css" />    
    <link rel="shortcut icon" href="imagenes/favicon.ico">
    
    <link rel="stylesheet" type="text/css" href="menu/skins/dhtmlxmenu_dhx_blue_light.css">
    <link rel="stylesheet" type="text/css" href="ventanas/dhtmlxwindows.css">
    <link rel="stylesheet" type="text/css" href="ventanas/skins/dhtmlxwindows_dhx_skyblue.css">
    <link rel="STYLESHEET" type="text/css" href="calendario/dhtmlxcalendar.css">
    <link rel="STYLESHEET" type="text/css" href="calendario/skins/dhtmlxcalendar_dhx_skyblue.css">
    
    <script>window.dhx_globalImgPath = "calendario/imgs/";</script>
	<script src="menu/dhtmlxcommon.js"></script>
    <script src="menu/dhtmlxmenu.js"></script>
    <script src="menu/ext/dhtmlxmenu_ext.js"></script>
    
    <script src="ventanas/dhtmlxwindows.js"></script>
    <script src="ventanas/dhtmlxcontainer.js"></script>    
   
    <script  src="calendario/dhtmlxcalendar.js"></script>
    
	<title><?php echo ENCABEZADO; ?></title>
    <script type="text/javascript">
	

	$(function(){
		$('#nav>li').hover(
			function()
			{
			//$('.submenu',this).stop(true,true).slideDown('fast');
			$('.submenu',this).fadeIn('fast');
			},
			function(){
			//$('.submenu',this).slideUp('fast');
			$('.submenu',this).fadeOut('fast');
			}
		);
		$('.submenu>li').hover(
			function()
			{
			//$('.submenu',this).stop(true,true).slideDown('fast');
			$('.subsubmenu',this).fadeIn('fast');
			},
			function(){
			//$('.submenu',this).slideUp('fast');
			$('.subsubmenu',this).fadeOut('fast');
			}				   	
		);
	});
	</script>
</head>
<body >

	<?php
		if(isset($_SESSION['tuvision_usuario']))
			include("panel.php");	
		else
			include("login.php");
	?>
    <script>
		var menu;
		
		menu = new dhtmlXMenuObject("menuWin");
		menu.setIconsPath("menu/imgs/imgs/");
		menu.setOpenMode("win");
		menu.loadXML(menuXML+"?e=" + new Date().getTime());
		menu.attachEvent("onClick", function(id, zoneId, casState)
		{
			switch(id)
			{
				case "cerrar":document.location="index.php?sesion="+id; break;
				case "about":
							createWindow("Acerca de Este Sistema",500,200,0,false, true);
							break;
				default:document.location="index.php?menu="+id;
			}
		});
		
		
		dhxWinsPanel = new dhtmlXWindows();
		dhxWinsPanel.enableAutoViewport(false);
		dhxWinsPanel.attachViewportTo("winVP");
		//dhxWinsPanel.setImagePath("ventanas/imgs/");
		
		dhxWinsPanel.attachEvent("onContentLoaded", function() {
			var modulo = document.getElementById('modulo');
			if(modulo!=null)
			{				
				switch(modulo.innerHTML)
				{
					case '1': ventanaBuscarClientes();	break;
					case '2': ventanaBuscarEmpleados(); break;
					case '3':					
						var cal1,
						cal2,
						mCal,
						mDCal,
						newStyleSheet;
						
						
						var monto = document.getElementById("monto");
						var enviar_filtro = document.getElementById("enviar_filtro");
						
						
						var dateFrom = null;
						var dateTo = null;
						
						cal1 = new dhtmlxCalendarObject('desde');
						cal1.setSkin('dhx_skyblue');
						
						cal2 = new dhtmlxCalendarObject('hasta');
						cal2.setSkin('dhx_skyblue');	
						
						monto.onkeyup = function(){
							solo_numeros_decimales(monto);							
						}
						monto.onblur = function(){
							solo_numeros_decimales(monto);							
						}
						
						try
						{
							ventanaBuscarClientes();
						}catch(e)
						{}
						
						enviar_filtro.onclick = function(){
							var form = document.createElement("form");
							var input_cliente =  document.createElement("input");
							var input_desde =  document.createElement("input");
							var input_hasta =  document.createElement("input");
							var input_monto =  document.createElement("input");
							var input_tipo_ingreso =  document.createElement("input");
							var filtro =  document.createElement("input");
							
							input_cliente.type = "hidden";
							input_desde.type = "hidden";
							input_hasta.type = "hidden";
							input_monto.type = "hidden";
							input_tipo_ingreso.type = "hidden";
							filtro.type = "hidden";
							
							input_cliente.name = "id_cliente";
							input_desde.name = "desde";
							input_hasta.name = "hasta";
							input_monto.name = "monto";
							input_tipo_ingreso.name = "tipo_ingreso";
							filtro.name= "aplicar_filtro";
							
							input_cliente.value = document.getElementById("id_cliente").value;
							input_desde.value = document.getElementById("desde").value;
							input_hasta.value = document.getElementById("hasta").value;
							input_monto.value = document.getElementById("monto").value;
							input_tipo_ingreso.value = document.getElementById("tipo_ingreso").value;
							
							// validar las fechas
							
							form.action = "index.php?menu=12";
							form.method = "post";
							
							form.appendChild(input_cliente);
							form.appendChild(input_desde);
							form.appendChild(input_hasta);
							form.appendChild(input_monto);
							form.appendChild(input_tipo_ingreso);
							form.appendChild(filtro);
							
							document.getElementById('filtro_div').appendChild(form);
							form.submit();
							
						}						
						break;
					case '4':
						var cal1,
						cal2,
						mCal,
						mDCal,
						newStyleSheet;
						
						
						var monto = document.getElementById("monto");
						var enviar_filtro = document.getElementById("enviar_filtro");
						
						
						var dateFrom = null;
						var dateTo = null;
						
						cal1 = new dhtmlxCalendarObject('desde');
						cal1.setSkin('dhx_skyblue');
						
						cal2 = new dhtmlxCalendarObject('hasta');
						cal2.setSkin('dhx_skyblue');	
						
						monto.onkeyup = function(){
							solo_numeros_decimales(monto);							
						}
						monto.onblur = function(){
							solo_numeros_decimales(monto);							
						}
						
						try
						{
							ventanaBuscarEmpleados();
						}catch(e)
						{}
						
						enviar_filtro.onclick = function(){
							var form = document.createElement("form");
							var input_empleado =  document.createElement("input");
							var input_desde =  document.createElement("input");
							var input_hasta =  document.createElement("input");
							var input_monto =  document.createElement("input");
							var input_banco =  document.createElement("input");
							var filtro =  document.createElement("input");
							
							input_empleado.type = "hidden";
							input_desde.type = "hidden";
							input_hasta.type = "hidden";
							input_monto.type = "hidden";
							input_banco.type = "hidden";
							filtro.type = "hidden";
							
							input_empleado.name = "id_empleado";
							input_desde.name = "desde";
							input_hasta.name = "hasta";
							input_monto.name = "monto";
							input_banco.name = "banco";
							filtro.name= "aplicar_filtro";
							
							input_empleado.value = document.getElementById("id_empleado").value;
							input_desde.value = document.getElementById("desde").value;
							input_hasta.value = document.getElementById("hasta").value;
							input_monto.value = document.getElementById("monto").value;
							input_banco.value = document.getElementById("banco").value;
							
							// validar las fechas
							
							form.action = "index.php?menu=16";
							form.method = "post";
							
							form.appendChild(input_empleado);
							form.appendChild(input_desde);
							form.appendChild(input_hasta);
							form.appendChild(input_monto);
							form.appendChild(input_banco);
							form.appendChild(filtro);
							
							document.getElementById('filtro_div').appendChild(form);
							form.submit();
							
						}						
						break;
					case '5':
						var cal1,
						cal2,
						cal3,
						cal4,
						mCal,
						mDCal,
						newStyleSheet;
						
						
						
						var enviar_filtro = document.getElementById("enviar_filtro");
						
						
						var dateFrom = null;
						var dateTo = null;
						
						cal1 = new dhtmlxCalendarObject('desde_r');
						cal1.setSkin('dhx_skyblue');
						
						cal2 = new dhtmlxCalendarObject('hasta_r');
						cal2.setSkin('dhx_skyblue');	
						
						cal3 = new dhtmlxCalendarObject('desde_a');
						cal3.setSkin('dhx_skyblue');
						
						cal4 = new dhtmlxCalendarObject('hasta_a');
						cal4.setSkin('dhx_skyblue');	
						
						
						
						try
						{
							ventanaBuscarClientes();
						}catch(e)
						{}
						
						enviar_filtro.onclick = function(){
							var form = document.createElement("form");
							var input_suc =  document.createElement("input");
							var input_cliente =  document.createElement("input");
							var input_desde_r =  document.createElement("input");
							var input_hasta_r =  document.createElement("input");
							var input_desde_a =  document.createElement("input");
							var input_hasta_a =  document.createElement("input");
							var input_servicio =  document.createElement("input");
							var filtro =  document.createElement("input");
							
							input_suc.type = "hidden";
							input_cliente.type = "hidden";
							input_desde_r.type = "hidden";
							input_hasta_r.type = "hidden";
							input_desde_a.type = "hidden";
							input_hasta_a.type = "hidden";
							input_servicio.type = "hidden";
							filtro.type = "hidden";
							
							input_suc.name = "id_suc";
							input_cliente.name = "id_cliente";
							input_desde_r.name = "desde_r";
							input_hasta_r.name = "hasta_r";
							input_desde_a.name = "desde_a";
							input_hasta_a.name = "hasta_a";
							input_servicio.name = "servicio";
							filtro.name= "aplicar_filtro";
							
							input_suc.value = document.getElementById("sucursal").value;
							input_cliente.value = document.getElementById("id_cliente").value;
							input_desde_r.value = document.getElementById("desde_r").value;
							input_hasta_r.value = document.getElementById("hasta_r").value;
							input_desde_a.value = document.getElementById("desde_a").value;
							input_hasta_a.value = document.getElementById("hasta_a").value;
							input_servicio.value = document.getElementById("servicio").value;
							
							// validar las fechas
							
							form.action = "index.php?menu=18";
							form.method = "post";
							
							form.appendChild(input_suc);
							form.appendChild(input_cliente);
							form.appendChild(input_desde_r);
							form.appendChild(input_hasta_r);
							form.appendChild(input_desde_a);
							form.appendChild(input_hasta_a);
							form.appendChild(input_servicio);
							form.appendChild(filtro);
							
							document.getElementById('filtro_div').appendChild(form);
							form.submit();
						}
						break;
					case '6':
						var cantidad = document.getElementById("cantidad");
						var enviar_filtro = document.getElementById("enviar_filtro");
						
						cantidad.onkeyup = function(){
							solo_numeros(cantidad);							
						}
						cantidad.onblur = function(){
							solo_numeros(cantidad);							
						}
						
						enviar_filtro.onclick = function(){
							
							
							var form = document.createElement("form");
							
												
							
							var input_cantidad =  document.createElement("input");
							var input_material =  document.createElement("select");
							var filtro =  document.createElement("input");
							
							
							input_cantidad.type = "hidden";
							filtro.type = "hidden";
							input_material.multiple = "multiple";
							
							
							input_cantidad.name = "cantidad";
							input_material.name = "material[]";
							
							filtro.name= "aplicar_filtro";
							
							input_cantidad.value = document.getElementById("cantidad").value;
							
						
							
							for(i=0; i<document.getElementById("material").options.length;i++)
							{
								option = document.createElement("option");
								if(document.getElementById("material").options[i].selected)
								{
									option.value = document.getElementById("material").options[i].value;
									
									option.selected= true;
								
									input_material.appendChild(option); 
								}
							}
							
														
							form.action = "index.php?menu=22";
							form.method = "post";
							
							form.appendChild(input_cantidad);
							form.appendChild(input_material);
							form.appendChild(filtro);
							
							try
							{
								var input_sucursal =  document.createElement("input");
								input_sucursal.type = "hidden";
								input_sucursal.name = "sucursal";
								input_sucursal.value = document.getElementById("sucursal").value;
								form.appendChild(input_sucursal);
								
							}catch(e){}
							
							document.getElementById('filtro_div').appendChild(form);
							form.submit();
							
						}						
						break;
					case '7':
					
						var cal1,
						cal2,
						cal3,
						cal4,
						cal5,
						cal6,
						mCal,
						mDCal,
						newStyleSheet;
						
						
						var enviar_filtro = document.getElementById("enviar_filtro");
						
						var limpiar_fecha_registro = document.getElementById("limpiar_fecha_registro");
						var limpiar_fecha_activacion = document.getElementById("limpiar_fecha_activacion");
						var limpiar_fecha_contrato = document.getElementById("limpiar_fecha_contrato");
						
						
						var dateFrom = null;
						var dateTo = null;
						
						cal1 = new dhtmlxCalendarObject('fecha_registro_desde');
						cal1.setSkin('dhx_skyblue');						
						cal2 = new dhtmlxCalendarObject('fecha_registro_hasta');
						cal2.setSkin('dhx_skyblue');
						
						cal3 = new dhtmlxCalendarObject('fecha_activacion_desde');
						cal3.setSkin('dhx_skyblue');	
						cal4 = new dhtmlxCalendarObject('fecha_activacion_hasta');
						cal4.setSkin('dhx_skyblue');	
						
						
						cal5 = new dhtmlxCalendarObject('fecha_contrato_desde');
						cal5.setSkin('dhx_skyblue');	
						cal6 = new dhtmlxCalendarObject('fecha_contrato_hasta');
						cal6.setSkin('dhx_skyblue');	
						
						
						
						try
						{
							ventanaBuscarClientes();
						}catch(e)
						{}
						
						
						
						
						enviar_filtro.onclick = function(){
							var form = document.createElement("form");
							var input_cliente =  document.createElement("input");
							var input_status =  document.createElement("input");
							
							var input_f_registro_desde =  document.createElement("input");
							var input_f_registro_hasta =  document.createElement("input");
							
							var input_f_contrato_desde =  document.createElement("input");
							var input_f_contrato_hasta =  document.createElement("input");
							
							var input_f_activacion_desde =  document.createElement("input");
							var input_f_activacion_hasta =  document.createElement("input");
							
							
							var filtro =  document.createElement("input");
							
							input_cliente.type = "hidden";
							input_status.type = "hidden";
							
							input_f_registro_desde.type = "hidden";
							input_f_registro_hasta.type = "hidden";
							
							input_f_contrato_desde.type = "hidden";
							input_f_contrato_hasta.type = "hidden";
							
							input_f_activacion_desde.type = "hidden";
							input_f_activacion_hasta.type = "hidden";
							
							
							filtro.type = "hidden";
							
							input_cliente.name = "id_cliente";
							input_status.name = "status";
							
							input_f_registro_desde.name = "fecha_registro_desde";
							input_f_registro_hasta.name = "fecha_registro_hasta";
							
							input_f_contrato_desde.name = "fecha_contrato_desde";
							input_f_contrato_hasta.name = "fecha_contrato_hasta";
							
							input_f_activacion_desde.name = "fecha_activacion_desde";
							input_f_activacion_hasta.name = "fecha_activacion_hasta";
							
							
							filtro.name= "aplicar_filtro";
							
							input_cliente.value = document.getElementById("id_cliente").value;
							input_status.value = document.getElementById("status").value;
							
							input_f_registro_desde.value = document.getElementById("fecha_registro_desde").value;
							input_f_registro_hasta.value = document.getElementById("fecha_registro_hasta").value;
							
							input_f_contrato_desde.value = document.getElementById("fecha_contrato_desde").value;
							input_f_contrato_hasta.value = document.getElementById("fecha_contrato_hasta").value;
							
							input_f_activacion_desde.value = document.getElementById("fecha_activacion_desde").value;
							input_f_activacion_hasta.value = document.getElementById("fecha_activacion_hasta").value;
							
							
							
							// validar las fechas
							
						
							
							
							form.action = "index.php?menu=10";
							form.method = "post";
							
							form.appendChild(input_cliente);
							
							form.appendChild(input_status);
							
							form.appendChild(input_f_registro_desde);
							form.appendChild(input_f_registro_hasta);
							
							form.appendChild(input_f_contrato_desde);
							form.appendChild(input_f_contrato_hasta);
							
							form.appendChild(input_f_activacion_desde);
							form.appendChild(input_f_activacion_hasta);
							
							
							form.appendChild(filtro);
							
							try
							{
								var input_sucursal =  document.createElement("input");
								input_sucursal.type = "hidden";
								input_sucursal.name = "sucursal";
								input_sucursal.value = document.getElementById("sucursal").value;
								form.appendChild(input_sucursal);
							}catch(e){}
							
							document.getElementById('filtro_div').appendChild(form);
							form.submit();
							
						}
						
						limpiar_fecha_activacion.onclick = function(){
							document.getElementById('fecha_activacion_desde').value="";
							document.getElementById('fecha_activacion_hasta').value="";
						}
						limpiar_fecha_registro.onclick = function(){
							document.getElementById('fecha_registro_desde').value="";
							document.getElementById('fecha_registro_hasta').value="";
						}
						limpiar_fecha_contrato.onclick = function(){
							document.getElementById('fecha_contrato_desde').value="";
							document.getElementById('fecha_contrato_hasta').value="";
						}
						
						break;
					case '8':
						var cal1,
						cal2,
						mCal,
						mDCal,
						newStyleSheet;
						
						
						
						var enviar_filtro = document.getElementById("enviar_filtro");
						
						
						var dateFrom = null;
						var dateTo = null;
						
									
						cal1 = new dhtmlxCalendarObject('desde_a');
						cal1.setSkin('dhx_skyblue');
						
						cal2 = new dhtmlxCalendarObject('hasta_a');
						cal2.setSkin('dhx_skyblue');	
						
						
						
						try
						{
							ventanaBuscarEmpleados();
						}catch(e)
						{}
						
						enviar_filtro.onclick = function(){
							var form = document.createElement("form");
							var sucur =  document.createElement("input");
							var empleado =  document.createElement("input");
							var t_egreso =  document.createElement("input");
							var estado =  document.createElement("input");
							var input_desde_a =  document.createElement("input");
							var input_hasta_a =  document.createElement("input");
							
							var filtro =  document.createElement("input");
							
							sucur.type = "hidden";
							empleado.type = "hidden";
							t_egreso.type = "hidden";
							estado.type = "hidden";
							input_desde_a.type = "hidden";
							input_hasta_a.type = "hidden";
							
							filtro.type = "hidden";
							
							sucur.name = "suc";
							empleado.name = "emp";
							t_egreso.name = "egre";
							estado.name = "edo";
							input_desde_a.name = "desde";
							input_hasta_a.name = "hasta";
							
							filtro.name= "aplicar_filtro";
							
							
							sucur.value = document.getElementById("sucursal").value;
							empleado.value = document.getElementById("id_empleado").value;
							t_egreso.value = document.getElementById("t_egreso").value;
							estado.value = document.getElementById("estado").value;
							input_desde_a.value = document.getElementById("desde_a").value;
							input_hasta_a.value = document.getElementById("hasta_a").value;
							
							
							// validar las fechas
							
							form.action = "index.php?menu=11";
							form.method = "post";
							
							form.appendChild(sucur);
							form.appendChild(empleado);
							form.appendChild(t_egreso);
							form.appendChild(estado);
							form.appendChild(input_desde_a);
							form.appendChild(input_hasta_a);
							form.appendChild(filtro);
							
							document.getElementById('filtro_div').appendChild(form);
							form.submit();
							
						}
						
						break;
					case '9':
						var cal1,
						cal2,
						mCal,
						mDCal,
						newStyleSheet;
						
						
						
						var enviar_filtro = document.getElementById("enviar_filtro");
						
						
						try
						{
							ventanaBuscarEmpleados();
						}catch(e)
						{}
						
						enviar_filtro.onclick = function(){
							var form = document.createElement("form");
							var sucur =  document.createElement("input");
							var empleado =  document.createElement("input");
							var clave =  document.createElement("input");
							
							var filtro =  document.createElement("input");
							
							sucur.type = "hidden";
							empleado.type = "hidden";
							clave.type = "hidden";
							
							filtro.type = "hidden";
							
							sucur.name = "suc";
							empleado.name = "emp";
							clave.name = "clave";
							
							
							filtro.name= "aplicar_filtro";
							
							
							sucur.value = document.getElementById("sucursal").value;
							empleado.value = document.getElementById("id_empleado").value;
							clave.value = document.getElementById("clave").value;
														
							// validar las fechas
							
							form.action = "index.php?menu=9";
							form.method = "post";
							
							form.appendChild(sucur);
							form.appendChild(empleado);
							form.appendChild(clave);
							
							document.getElementById('filtro_div').appendChild(form);
							form.submit();
							
						}
						
						break;
					case '10':
					
						
						
						var enviar_filtro = document.getElementById("enviar_filtro");
											
						
						
						
						
						
						enviar_filtro.onclick = function(){
							var form = document.createElement("form");
							var input_proveedor =  document.createElement("input");
							
							
							var filtro =  document.createElement("input");
							
							input_proveedor.type = "hidden";						
							input_proveedor.name = "filtro_nombre";						
							
							input_proveedor.value = document.getElementById("filtro_nombre").value;
							
							
							
							// validar las fechas
							
						
							
							
							form.action = "index.php?menu=34";
							form.method = "post";
							
							form.appendChild(input_proveedor);
												
							
							document.getElementById('filtro_div').appendChild(form);
							form.submit();
							
						}
						
						limpiar_fecha_activacion.onclick = function(){
							document.getElementById('fecha_activacion_desde').value="";
							document.getElementById('fecha_activacion_hasta').value="";
						}
						limpiar_fecha_registro.onclick = function(){
							document.getElementById('fecha_registro_desde').value="";
							document.getElementById('fecha_registro_hasta').value="";
						}
						limpiar_fecha_contrato.onclick = function(){
							document.getElementById('fecha_contrato_desde').value="";
							document.getElementById('fecha_contrato_hasta').value="";
						}
						
						break;
					case '11':
						var cal1,cal2,cal3,cal4;
						
						cal1 = new dhtmlxCalendarObject('fecha_recepcion_desde');
						cal1.setSkin('dhx_skyblue');
						cal2 = new dhtmlxCalendarObject('fecha_recepcion_hasta');
						cal2.setSkin('dhx_skyblue');
						cal3 = new dhtmlxCalendarObject('fecha_pago_desde');
						cal3.setSkin('dhx_skyblue');
						cal4 = new dhtmlxCalendarObject('fecha_pago_hasta');
						cal4.setSkin('dhx_skyblue');
						
						var enviar_filtro = document.getElementById("enviar_filtro");
						
						
						
						
						enviar_filtro.onclick = function(){
							var form = document.createElement("form");
							var proveedor =  document.createElement("input");
							var status =  document.createElement("input");
							var fecha_recepcion_desde =  document.createElement("input");
							var fecha_recepcion_hasta =  document.createElement("input");
							var fecha_pago_desde =  document.createElement("input");
							var fecha_pago_hasta =  document.createElement("input");
							
							proveedor.type = "hidden";
							status.type = "hidden";
							fecha_recepcion_desde.type = "hidden";
							fecha_recepcion_hasta.type = "hidden";
							fecha_pago_desde.type = "hidden";
							fecha_pago_hasta.type = "hidden";
							
							proveedor.name = "filtro_proveedor";
							status.name = "filtro_status";
							fecha_recepcion_desde.name = "filtro_fecha_recepcion_desde";
							fecha_recepcion_hasta.name = "filtro_fecha_recepcion_hasta";
							fecha_pago_desde.name = "filtro_fecha_pago_desde";
							fecha_pago_hasta.name = "filtro_fecha_pago_hasta";							
							
							
							proveedor.value = document.getElementById("proveedor").value;
							status.value = document.getElementById("status").value;
							fecha_recepcion_desde.value = document.getElementById("fecha_recepcion_desde").value;
							fecha_recepcion_hasta.value = document.getElementById("fecha_recepcion_hasta").value;
							fecha_pago_desde.value = document.getElementById("fecha_pago_desde").value;
							fecha_pago_hasta.value = document.getElementById("fecha_pago_hasta").value;
														
							// validar las fechas
							
							form.action = "index.php?menu=33";
							form.method = "post";
							
							form.appendChild(proveedor);
							form.appendChild(status);
							form.appendChild(fecha_recepcion_desde);														
							form.appendChild(fecha_recepcion_hasta);
							form.appendChild(fecha_pago_desde);
							form.appendChild(fecha_pago_hasta);
							
							document.getElementById('filtro_div').appendChild(form);
							form.submit();
							
						}
						
						break;

						case '12':
						
						var enviar_filtro = document.getElementById("enviar_filtro");
						
						
						enviar_filtro.onclick = function(){

							var form = document.createElement("form");
							var input_suc =  document.createElement("input");
							var input_calle =  document.createElement("input");
							
							var filtro =  document.createElement("input");
							
							input_suc.type = "hidden";
							input_calle.type="hidden";

							filtro.type = "hidden";
							
							input_suc.name = "id_suc";
							input_calle.name="id_calle";

							filtro.name= "aplicar_filtro";
							
							input_suc.value = document.getElementById("sucursal").value;
							if(input_suc.value=="null"){
							input_calle.value=null;
							}else{
							input_calle.value = document.getElementById("calle").value;
							}
							
							// validar las fechas
							
							form.action = "index.php?menu=20";
							form.method = "post";
							
							form.appendChild(input_suc);
							form.appendChild(input_calle);

							form.appendChild(filtro);
							
							document.getElementById('filtro_div').appendChild(form);
							form.submit();
						}
						break;

						case '13':    //// filtro para reporte auditoria
						
						var enviar_filtro = document.getElementById("enviar_filtro");
						
						
						enviar_filtro.onclick = function(){

							var form = document.createElement("form");
							var input_suc =  document.createElement("input");
							var input_tap =  document.createElement("input");
							
							var filtro =  document.createElement("input");
							
							input_suc.type = "hidden";
							input_tap.type="hidden";

							filtro.type = "hidden";
							
							input_suc.name = "id_suc";
							input_tap.name="id_tap";

							filtro.name= "aplicar_filtro";
							
							input_suc.value = document.getElementById("sucursal").value;
							if(input_suc.value=="null"){
							input_tap.value=null;
							}else{
							input_tap.value = document.getElementById("tap").value;
							}
							
							// validar las fechas
							
							form.action = "index.php?menu=35";
							form.method = "post";
							
							form.appendChild(input_suc);
							form.appendChild(input_tap);

							form.appendChild(filtro);
							
							document.getElementById('filtro_div').appendChild(form);
							form.submit();
						}
						break;

				}
			}
	
		});
		
		var idPrefix = 1;

		
		function createWindow(title,w,h,opcion,minmax,modal,limite)
		{
			if(limite==null)
				limite = 0;
			var p = 0;
			dhxWinsPanel.forEachWindow(function() {
				p++;
			});
			if (p > limite) {
				alert("Cierre una ventana antes de abrir otra.");
				return;
			}
			
			var id = "userWinGral" + (idPrefix++);
			
			
			var x = 100;
			var y = 20;
			ventana = dhxWinsPanel.createWindow(id, x, y, w, h);
					
			if(modal)
			{
				for(i=idPrefix-1;i>0;i--)
				{
					dhxWinsPanel.window("userWinGral"+i).setModal(false);
					
				}
				dhxWinsPanel.window(id).setModal(true);
			}
			
			ventana.center();
			var pos = ventana.getPosition();
			ventana.setPosition(pos[0], y);			
			ventana.setText(title)
			
			if(!minmax)
			{
				ventana.denyResize();
				ventana.button("minmax1").hide();
			}
			ventana.button("park").hide();
			ventana.attachURL("ventanas/contenido.php?opcion="+opcion, true);
			
			ventana.attachEvent("onClose",onClose);

			
		}
		function onClose(ventana)
		{
			
			idPrefix--;	
			
			dhxWinsPanel.window("userWinGral"+idPrefix).setModal(false);
			
			if(idPrefix-1>0)
			{
				dhxWinsPanel.window("userWinGral"+(idPrefix-1)).setModal(true);
			}
			
			return true;
			

		}		
		function ventanaBuscarClientes()
		{
			var buscar_cliente = document.getElementById('buscar_cliente');
						var cliente = document.getElementById('cliente');
						var lista_clientes = document.getElementById('lista_clientes');
						buscar_cliente.onclick = function (){
							
							//Reseteamos la lista de clientes
														
							lista_clientes.innerHTML = "<div><center><img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Clientes...</span></center></div>";
							
							var cdata="";
							
							if(parametro_sucursal_cliente!="")
								cdata = "cliente="+cliente.value+"&s="+parametro_sucursal_cliente;
							else
								cdata = "cliente="+cliente.value;
							
							$.ajax({
									type: "POST",
									url: "ajaxProcess/clientes.php",
									data: cdata,
									success: function(datos)
									{
										lista_clientes.innerHTML = datos;	
										$('#lista_clientes>div').click(function(){
											var id = $(this).find('div').get(0);
											if(id!=null)
											{
												id = document.getElementById(contenedor_cliente).value = id.innerHTML;
												//Incluir siempre esta funcion desde el modulo donde se quieren listar clientes aunque no se use
												cambio_id_cliente(id);
												/*
												idPrefix--;
												
												alert("al cerrar userWinGral"+idPrefix);
												if(idPrefix>0)
													dhxWinsPanel.window("userWinGral"+idPrefix).setModal(false);
												
												
												if(idPrefix-1>0)
												{
													alert("no deberia entrar aqui");
													dhxWinsPanel.window("userWinGral"+(idPrefix-1)).setModal(true);
												}
												*/
												dhxWinsPanel._closeWindow(ventana);
											}
										});
										
										
									}
							});
							
						}
		}
		function ventanaBuscarEmpleados()
		{
			var buscar_empleado = document.getElementById('buscar_empleado');
						var empleado = document.getElementById('empleado');
						var lista_empleados = document.getElementById('lista_empleados');
						buscar_empleado.onclick = function (){
							
							//Reseteamos la lista de clientes
														
							lista_empleados.innerHTML = "<div><center><img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Empleados...</span></center></div>";
							
							if(parametro_sucursal_empleado!="")
								cdata = "empleado="+empleado.value+"&s="+parametro_sucursal_empleado;
							else
								cdata = "empleado="+empleado.value;
								
							$.ajax({
									type: "POST",
									url: "ajaxProcess/empleados.php",
									data: cdata,
									success: function(datos)
									{
										lista_empleados.innerHTML = datos;	
										$('#lista_empleados>div').click(function(){
											var id = $(this).find('div').get(0);
											if(id!=null)
											{
												id = document.getElementById(contenedor_empleado).value = id.innerHTML;
												//Incluir siempre esta funcion desde el modulo donde se quieren listar clientes aunque no se use
												cambio_id_empleado(id);
												/*
												idPrefix--;
	
												if(idPrefix>0)
													dhxWinsPanel.window("userWinGral"+idPrefix).setModal(false);
												
												if(idPrefix-1>0)
													dhxWinsPanel.window("userWinGral"+(idPrefix-1)).setModal(true);
													*/
												dhxWinsPanel._closeWindow(ventana);
											}
										});										
									}
							});
							
						}
		}
		
	</script>

</body>	
</html>