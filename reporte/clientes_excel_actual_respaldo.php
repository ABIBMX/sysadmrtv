<?php
	session_start();
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment;filename=Ingresos_".date("Y/m/d").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	require_once('../config.php');
	require_once('../conexion.php');

	
		?>
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td colspan="7"><b>Reporte de Clientes</b> Generado:&nbsp;<?php echo date("Y/m/d"); ?></td>
           	</tr>            
        </table>
         <br />
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	<td>Clave</td>
                <td>Nombre</td>
				<td>Telefono</td>
                <td>Sucursal</td>
                <td>Estatus</td>
                <td>Tipo Estatus</td>
				<td>Estatus Servicio Internet</td>
                <td>Tap</td>
                <td>Calle</td>
                <td>Numero</td>
                <td>Referencia de la Casa</td>
                <td>Fecha de activacion</td>
				<td>Saldo actual</td>
				<td>winbox</td>
				<td>Mac winbox</td>
				<td>Plan de datos</td>
				<td>IP asignada</td>
				<td>Fecha Ultimo Reporte Servicio</td>
				<td>Estatus Ultimo Reporte Servicio</td>
				<td>Ultimo Tipo de Servicio</td>
				<td>Ultimo Ingreso (inscripcion)</td>
            </tr>
       
        
<?php
		$contador=0;
		
		$consulta = mysqli_query($conexion,$_SESSION['tuvision_filtro_clientes2']);
		while(list($id,$nombre,$telefono,$sucursal,$estatus,$tipo_status,$tipo_servicio,$fecha_contrato,$fecha_activacion,$tap,$calle,$numero,$referencia,$saldo_actual,$winbox,$mac_winbox,$plan_datos,$ip_asignada,$fecha_urs,$estatus_urs,$utipo_servicio,$ultima_inscripcion) = mysqli_fetch_array($consulta)){
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			
			echo "<tr $color>";
				echo "<td align='left'>".$id."</td>";
				echo "<td align='left'>".$nombre."</td>";
				echo "<td align='left'>".$telefono."</td>";
				echo "<td align='left'>".$sucursal."</td>";
				echo "<td align='left'>".$estatus."</td>";
				echo "<td align='left'>".$tipo_status."</td>";
				echo "<td align='left'>".$tipo_servicio."</td>";
				echo "<td align='left'>".$tap."</td>";
				echo "<td align='left'>".$calle."</td>";
				echo "<td align='left'>".$numero."</td>";
				echo "<td align='left'>".$referencia."</td>";
				echo "<td align='left'>".$fecha_activacion."</td>";
				echo "<td align='left'>".$saldo_actual."</td>";
				echo "<td align='left'>".$winbox."</td>";
				echo "<td align='left'>".$mac_winbox."</td>";
				echo "<td align='left'>".$plan_datos."</td>";
				echo "<td align='left'>".$ip_asignada."</td>";
				echo "<td align='left'>".$fecha_urs."</td>";
				echo "<td align='left'>".$estatus_urs."</td>";
				echo "<td align='left'>".$utipo_servicio."</td>";
				echo "<td align='left'>".$ultima_inscripcion."</td>";
			echo "</tr>";
			$contador++;
		}
?>
 </table>