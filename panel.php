<table style="min-width:800px;" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="encabezado">
					<tr>
						<td width="5px"  background="imagenes/header_left.png" rowspan="2"></td>
						<td width="50px" height="55px" rowspan="2"><a href="index.php" id="logo"></a></td>
						<td height="28px" background="imagenes/header_center.png">
							<?php echo "&nbsp;".ENCABEZADO; ?>
						</td>
						<td align="right" height="28px"  background="imagenes/header_center.png">
							Bienvenido: <b><?php echo $_SESSION['tuvision_usuario']; ?>&nbsp;</b>
						</td>
						<td width="5px" rowspan="2" height="55px" background="imagenes/header_right.png"></td>
					</tr>
                    <tr>
                        <td class="menu" colspan="2">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td height="25px"><div id="menuWin"></div></td></tr></table>
                            <?php 
                                switch($_SESSION['tuvision_tipo_usuario'])
                                {
                                    case 1: {?><script>var menuXML ="menu/menu1.xml";</script><?php } break;
									case 2: {?><script>var menuXML ="menu/menu2.xml";</script><?php } break;
                                }
                                    
                            ?>
                        </td>
                    </tr>
				</table>
			</td>
		</tr>		
		<tr>
			<td class="contenido"   height="400px" >
            	<div id="winVP" style="position: relative;min-height:400px;">
				<?php
					switch($_SESSION['tuvision_tipo_usuario'])
					{
						case 1:
							switch($_GET['menu'])
							{
								case 2: include("contenidos/administrador/usuarios_sistema.php");break;
								case 3: include("contenidos/administrador/catalogo_bancos.php");break;
								case 4: include("contenidos/administrador/sucursales.php");break;
								case 5: include("contenidos/administrador/catalogo_t_ingreso.php");break;
								case 6: include("contenidos/administrador/catalogo_t_egreso.php");break;
								case 7: include("contenidos/administrador/catalogo_t_servicios.php");break;
								case 8: include("contenidos/administrador/catalogo_t_status.php");break;
								case 9: include("contenidos/administrador/empleados.php");break;
								case 10: include("contenidos/administrador/clientes.php");break;
								case 11: include("contenidos/administrador/egresos.php");break;
								case 12: include("contenidos/administrador/ingresos.php");break;
								case 16: include("contenidos/administrador/depositos.php");break;
								case 18: include("contenidos/administrador/reportes_servicios.php");break;
								case 19: include("contenidos/administrador/catalogo_calles.php");break;
								case 20: include("contenidos/administrador/catalogo_taps.php");break;
								case 21: include("contenidos/administrador/catalogo_equipos_inventario.php");break;
								case 22: include("contenidos/administrador/inventario.php");break;
								case 23: include("contenidos/administrador/generar_saldos.php");break;
								case 24: include("contenidos/administrador/consultar_saldos.php");break;
								case 25: include("contenidos/administrador/estados_cuenta.php");break;
								case 26: include("contenidos/administrador/promociones.php");break;
								case 27: include("contenidos/administrador/caja.php");break;
								case 28: include("contenidos/administrador/clientes_cobrar.php");break;
								case 29: include("contenidos/administrador/general_clientes.php");break;
								case 30: include("contenidos/administrador/general_caja.php");break;
								case 31: include("contenidos/administrador/general_reportes_servicio.php");break;
								case 32: include("contenidos/administrador/general_clientes_tap.php");break;								
								case 33: include("contenidos/administrador/facturas.php");break;										
								case 34: include("contenidos/administrador/proveedores.php");break;
								case 35: include("contenidos/administrador/catalogo_auditoria.php");break;
								case 36: include("contenidos/administrador/canales.php");break;
								case 37: include("contenidos/administrador/conceptos.php");break;
								default: include("contenidos/administrador/index.php");break;
								
								
							}
						break;
						case 2:
							switch($_GET['menu'])
							{
								case 7: include("contenidos/sucursal/catalogo_t_servicios.php");break;
								case 8: include("contenidos/sucursal/catalogo_t_status.php");break;
								case 10: include("contenidos/sucursal/clientes.php");break;
								case 11: include("contenidos/sucursal/egresos.php");break;
								case 12: include("contenidos/sucursal/ingresos.php");break;
								case 16: include("contenidos/sucursal/depositos.php");break;
								case 18: include("contenidos/sucursal/reportes_servicios.php");break;
								case 21: include("contenidos/sucursal/catalogo_equipos_inventario.php");break;
								case 22: include("contenidos/sucursal/inventario.php");break;
								case 24: include("contenidos/sucursal/consultar_saldos.php");break;
								case 25: include("contenidos/sucursal/estados_cuenta.php");break;
								case 27: include("contenidos/sucursal/caja.php");break;
								case 28: include("contenidos/sucursal/clientes_cobrar.php");break;
								default: include("contenidos/sucursal/index.php");break;
								
							}
						break;
					}
				?>
                </div>
			</td>
		</tr>
		<tr><td class="footer"><?php echo PIE_PAGINA; ?></td></tr>
	</table>