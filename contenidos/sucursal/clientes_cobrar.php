<?php
	$ruta_modulo = "contenidos/sucursal/modulos/clientes_cobrar";
	switch($_GET['accion'])
	{
		//case 'agregar':include($ruta_modulo."/agregar.php");break;
		//case 'editar':include($ruta_modulo."/editar.php");break;
		default: include($ruta_modulo."/index.php");
	}
?>