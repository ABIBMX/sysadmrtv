<?php
	$ruta_modulo = "contenidos/sucursal/modulos/catalogo_t_status";
	switch($_GET['accion'])
	{
		case 'agregar':include($ruta_modulo."/agregar.php");break;
		case 'editar':include($ruta_modulo."/editar.php");break;
		default: include($ruta_modulo."/index.php");
	}
?>