<?php
	if(isset($_GET['opcion']))
	{
		switch($_GET['opcion'])
		{
			case 1: include("contenidos/buscar_cliente.php");break;
			case 2: include("contenidos/buscar_empleado.php");break;
			case 3: include("contenidos/filtro_ingresos_admin.php");break;
			case 4: include("contenidos/filtro_depositos_admin.php");break;
			case 5: include("contenidos/filtro_reporte_servicio_admin.php");break;
			case 6: include("contenidos/filtro_inventario_admin.php");break;
			case 7: include("contenidos/filtro_clientes_admin.php");break;
			case 8: include("contenidos/filtro_egreso_admin.php");break;
			case 9: include("contenidos/filtro_empleados_admin.php");break;
			case 10: include("contenidos/filtro_proveedores.php");break;
			case 11: include("contenidos/filtro_facturas.php");break;
			case 12:include("contenidos/filtro_taps.php");break;
			case 13:include("contenidos/filtro_auditoria.php");break;
			default: include("contenidos/about.php");
		}
		
	}
?>