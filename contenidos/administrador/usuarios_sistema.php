<?php
	switch($_GET['accion'])
	{
		case 'agregar':include("contenidos/administrador/modulos/usuarios_sistema/agregar.php");break;
		case 'editar':include("contenidos/administrador/modulos/usuarios_sistema/editar.php");break;
		default: include("contenidos/administrador/modulos/usuarios_sistema/index.php");
	}
?>