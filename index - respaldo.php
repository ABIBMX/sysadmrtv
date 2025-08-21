<?php
	session_start();
	include("config.php");
	include("conexion.php");
	include("funciones.php");
	if(isset($_GET['sesion']) && $_GET['sesion']=="cerrar")
	{
		unset($_SESSION['tuvision_usuario']);
	}
	if(isset($_POST['tuvision_usuario'])&&!isset($_SESSION['tuvision_usuario']))
	{
		
		$query= "select id_usuario from usuario where id_usuario='".addslashes($_POST['tuvision_usuario'])."' and password='".addslashes($_POST['md5password'])."'";
		
		if(cantidadRegistros($query)>0)
		{
			$registro = devolverValorQuery("select id_usuario,id_tipo_usuario from usuario where id_usuario='".addslashes($_POST['tuvision_usuario'])."'");
			$_SESSION['tuvision_usuario'] =$registro[0];
			$_SESSION['tuvision_tipo_usuario'] = $registro[1];
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
	<link href="fckeditor/_samples/sample.css" rel="stylesheet" type="text/css" >
    
    <link rel="stylesheet" type="text/css" href="menu/skins/dhtmlxmenu_dhx_blue_light.css">
    <link rel="stylesheet" type="text/css" href="ventanas/dhtmlxwindows.css">
    <link rel="stylesheet" type="text/css" href="ventanas/skins/dhtmlxwindows_dhx_skyblue.css">
    
	<script src="menu/dhtmlxcommon.js"></script>
    <script src="menu/dhtmlxmenu.js"></script>
    <script src="menu/ext/dhtmlxmenu_ext.js"></script>
    
    <script src="ventanas/dhtmlxwindows.js"></script>
    <script src="ventanas/dhtmlxcontainer.js"></script>
 


    
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
		var menuXML = '/menu/menu1.xml';
		var menu;
		menu = new dhtmlXMenuObject("menuWin");
		menu.setIconsPath("/menu/imgs/imgs/");
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
		dhxWinsPanel.setImagePath("ventanas/imgs/");
		
		dhxWinsPanel.attachEvent("onContentLoaded", function() {
			var modulo = document.getElementById('modulo');
			if(modulo!=null)
			{				
				switch(modulo.innerHTML)
				{
					case '1':
						var buscar_cliente = document.getElementById('buscar_cliente');
						var cliente = document.getElementById('cliente');
						var lista_clientes = document.getElementById('lista_clientes');
						buscar_cliente.onclick = function (){
							
							//Reseteamos la lista de clientes
														
							lista_clientes.innerHTML = "<div><center><img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Clientes...</span></center></div>";
							var cdata = "cliente="+cliente.value;
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
												id = document.getElementById('id_cliente').value = id.innerHTML;
												//Incluir siempre esta funcion desde el modulo donde se quieren listar clientes aunque no se use
												cambio_id_cliente(id);
												dhxWinsPanel._closeWindow(ventana);
											}
										});
										
										
									}
							});
							
						}
						break;
					case '2':
						var buscar_empleado = document.getElementById('buscar_empleado');
						var empleado = document.getElementById('empleado');
						var lista_empleados = document.getElementById('lista_empleados');
						buscar_empleado.onclick = function (){
							
							//Reseteamos la lista de clientes
														
							lista_empleados.innerHTML = "<div><center><img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Empleados...</span></center></div>";
							var cdata = "empleado="+empleado.value;
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
												id = document.getElementById('id_empleado').value = id.innerHTML;
												//Incluir siempre esta funcion desde el modulo donde se quieren listar clientes aunque no se use
												cambio_id_empleado(id);
												dhxWinsPanel._closeWindow(ventana);
											}
										});										
									}
							});
							
						}
						break;
				}
			}
	
		});
		
		var idPrefix = 1;

		
		function createWindow(title,w,h,opcion,minmax,modal,parametro_extra)
		{
			var p = 0;
			dhxWinsPanel.forEachWindow(function() {
				p++;
			});
			if (p > 0) {
				alert("Cierre una ventana antes de abrir otra.");
				return;
			}
			
			var id = "userWinGral" + (idPrefix++);
			
			var x = 100;
			var y = 20;
			ventana = dhxWinsPanel.createWindow(id, x, y, w, h);
				
			if(modal)
				ventana.setModal(true);
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
			ventana.attachURL("ventanas/contenido.php?opcion="+opcion+"&"+parametro_extra, true);

			
		}
	</script>

</body>	
</html>