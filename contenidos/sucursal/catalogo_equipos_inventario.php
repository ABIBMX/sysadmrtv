<?php
	$ruta_modulo = "contenidos/sucursal/modulos/catalogo_equipos_inventario";
	switch($_GET['accion'])
	{
		default: include($ruta_modulo."/index.php");
	}
?>