<?php
	$ruta_modulo = "contenidos/administrador/modulos/general_caja";
	switch($_GET['accion'])
	{
		//case 'agregar':include($ruta_modulo."/agregar.php");break;
		//case 'editar':include($ruta_modulo."/editar.php");break;
		default: include($ruta_modulo."/index.php");
	}
?>