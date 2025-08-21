<?php
	$ruta_modulo = "contenidos/sucursal/modulos/inventario";
	switch($_GET['accion'])
	{
		case 'editar':include($ruta_modulo."/editar.php");break;
		default: include($ruta_modulo."/index.php");
	}
?>