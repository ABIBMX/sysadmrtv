<?php

	session_start();
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment;filename=Reporte_auditoria_".date("Y/m/d").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	require_once('../config.php');
	require_once('../conexion.php');

	
		?>
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td colspan="7"><b>Reporte de Auditoria y Revision de Red</b> Generado:&nbsp;<?php echo date("Y/m/d"); ?></td>
           	</tr>            
        </table>
         <br />
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	<td>ID TAP</td>
                <td>Sucursal</td>
                <td>Fecha</td>
                <td>Clientes Asignados</td>
                <td>Diferencia de Clientes</td>                
                <td>DB Canal bajo</td>
                <td>DB Canal alto</td>
                <td>Cliente agregado 1</td>
                <td>Cliente agregado 2</td>
                <td>Cliente agregado 3</td>
                <td>DB Canal bajo Terminal</td>
                <td>DB Canal alto Terminal</td>
                <td>Varilla</td>
                <td>Conector</td>
                <td>Cable tierra</td>
                <td>Poste</td>
                <td>Edo. Poste</td>
                <td>Loop</td>
                <td>Tendido</td>
                <td>Protectores</td>
                <td>Cinta</td>
                <td>CMT</td>
                <td>Tensado</td>
                <td>Hilado</td>
                <td>Altura</td>
                <td>Libre de rama</td>
            	
            </tr>
       
        
<?php
		if(isset($_POST['select']))
		{
			$identif = array_keys($_POST['select']);
			$query="select a.id,a.id_tap,t.id_sucursal,a.diferencia,a.fechaRegistro,a.niveldbBajo,a.niveldbAlto,a.idCliente1,a.idCliente2,a.idCliente3,a.tapdbCanalBajo,a.tapdbCanalAlto,a.varillaTierra,a.conectorTierra,a.cableTierra,r.poste,r.estadoPoste,r.loop,r.tendido,r.protectores,r.cinta,r.cmt,r.tensado,r.hilado,r.altura,r.libreRamas from auditoria a, tap t,revision_red r 
where a.id_tap=t.id_tap and a.id_tap=r.id_tap and a.fechaRegistro=r.fechaRegistro and t.id_tap=r.id_tap and a.id=r.id and a.id in (".implode(",",$identif).") order by a.id_tap";
			
			/*$query="select t.id_tap,s.nombre,c.nombre,t.poste,t.tipoposte,t.trayectoria,t.fibracoaxial,t.especificacioncable,t.delposte,t.alposte,t.distancia,t.peso,t.pesofabrica,t.latitud,t.longitud from tap t,sucursales s,cat_calles c where t.id_sucursal=s.id_sucursal and t.calle=c.id_calle and t.id_tap in ('".implode("','",$identif)."')";*/
			
			$res=mysqli_query($conexion,$query);
			$conta=0;
			$contador=0;
			while($registro=mysqli_fetch_array($res)){			
	
				if($contador%2==0)
					$color = "";
				else
					$color = "bgcolor='#EEEEEE'";
				
					echo "<tr ".$color.">";
					echo "<td align='left'>".$registro[1]."</td>";
					echo "<td align='left'>".$registro[2]."</td>";
					echo "<td align='left'>".$registro[4]."</td>";
					$query_t_u="select count(id_cliente) from clientes where id_tap='".$registro[1]."' and id_tipo_status not in (4,5,7,8,9,10,11)";
					
					$tabla_t_u = mysqli_query($conexion,$query_t_u);
						$noclie="";
						while($registro_t_u = mysqli_fetch_array($tabla_t_u))
						{
							$noclie=$registro_t_u[0];
							
						}
					echo "<td align='left'>".$noclie."</td>";		/// no de clientes en tap

					echo "<td align='left'>".$registro[3]."</td>";
					echo "<td align='left'>".$registro[5]."</td>";
					echo "<td align='left'>".$registro[6]."</td>";	/////  nivel alto db
					$extra="";

					if(strlen($registro[7])>0){
					$query_t_u="select concat(id_cliente, ' ',nombre,' ',apellido_paterno,' ',apellido_materno) as cliente from clientes where id_cliente='".$registro[7]."'";
					$tabla_t_u = mysqli_query($conexion,$query_t_u);
						
						while($registro_t_u = mysqli_fetch_array($tabla_t_u))
						{
							$extra=$registro_t_u[0];						
						}
					}
					echo "<td align='left'>".$extra."</td>";

					$extra="";

					if(strlen($registro[8])>0){
					$query_t_u="select concat(id_cliente, ' ',nombre,' ',apellido_paterno,' ',apellido_materno) as cliente from clientes where id_cliente='".$registro[8]."'";
					$tabla_t_u = mysqli_query($conexion,$query_t_u);
						
						while($registro_t_u = mysqli_fetch_array($tabla_t_u))
						{
							$extra=$registro_t_u[0];						
						}
					}
					echo "<td align='left'>".$extra."</td>";

					$extra="";
					if(strlen($registro[9])>0){
					$query_t_u="select concat(id_cliente, ' ',nombre,' ',apellido_paterno,' ',apellido_materno) as cliente from clientes where id_cliente='".$registro[9]."'";
					$tabla_t_u = mysqli_query($conexion,$query_t_u);
						
						while($registro_t_u = mysqli_fetch_array($tabla_t_u))
						{
							$extra=$registro_t_u[0];						
						}
					}
					echo "<td align='left'>".$extra."</td>";
					

					echo "<td align='left'>".$registro[10]."</td>";
					echo "<td align='left'>".$registro[11]."</td>";
					echo "<td align='left'>".$registro[12]."</td>";
					echo "<td align='left'>".$registro[13]."</td>";
					echo "<td align='left'>".$registro[14]."</td>";
					echo "<td align='left'>".$registro[15]."</td>";
					echo "<td align='left'>".$registro[16]."</td>";	/// edo de poste
					echo "<td align='left'>".$registro[17]."</td>";
					echo "<td align='left'>".$registro[18]."</td>";
					echo "<td align='left'>".$registro[19]."</td>";
					echo "<td align='left'>".$registro[20]."</td>";
					echo "<td align='left'>".$registro[21]."</td>";
					echo "<td align='left'>".$registro[22]."</td>";
					echo "<td align='left'>".$registro[23]."</td>";
					echo "<td align='left'>".$registro[24]."</td>";
					echo "<td align='left'>".$registro[25]."</td>";

				
				echo "</tr>";

				$contador++;

			}
		}

		echo "</table>";
		
?>
 