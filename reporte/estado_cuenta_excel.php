<?php


header("Content-Type: application/vnd.ms-excel");
header("content-disposition: attachment;filename=Estado_de_cuenta_".date("Y/m/d").".xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once('../config.php');
require_once('../conexion.php');

$sucursal = addslashes($_POST['sucursal']);
$id_cliente = addslashes($_POST['id_cliente']);
$desde = addslashes($_POST['desde']);
$hasta = addslashes($_POST['hasta']);

$cliente = "select 
		concat(nombre,' ',apellido_paterno,' ',apellido_materno), 
		(select nombre from sucursales where id_sucursal='$sucursal')
		from clientes where id_cliente='$id_cliente'";
		$res = mysqli_query($conexion,$cliente);
		list($nombre_cliente,$nombre_sucursal)=mysqli_fetch_array($res);
		
		
		
		?>
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td rowspan="4" colspan="2"><img src="http://localhost/tuvision/imagenes/tuvision_logo.jpg" /></td>
                <td>Sucursal:</td><td colspan="5">&nbsp;<?php echo $nombre_sucursal; ?></td>
            </tr>
            <tr>
            	<td>Cliente:</td><td  colspan="5">&nbsp;<?php echo $nombre_cliente; ?></td>
            </tr>
            <tr>
            	<td>Fecha Actual:</td><td  colspan="5">&nbsp;<?php echo date("Y/m/d"); ?></td>
            </tr>
            <tr>
            	<td>Periodo:</td><td  colspan="5">&nbsp;<?php echo "De ".$desde." A ".$hasta; ?></td>
            </tr>
        </table>
         <br />
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	<td width="70">Transaccion</td>
                <td width="70">Fecha de Transaccion</td>
                <td width="70">Hora de Transccion</td>
                <td width="70">Descripcion</td>
                <td width="70">Cargo</td>
                <td width="70">Saldo Anterior</td>
                <td width="70">Saldo Actual</td>
                
            </tr>
       
        
<?php
		$contador=0;
		$reporte_saldo = "select id_transaccion, fecha_transaccion, hora_transaccion ,ct.descripcion,cargo,t.saldo_anterior,t.saldo_actual
		from transacciones t, clientes c, cat_concepto_transaccion ct where c.id_cliente=t.id_cliente and ct.id_concepto=t.id_concepto and t.id_cliente='$id_cliente' and fecha_transaccion between '$desde' and '$hasta' order by fecha_transaccion asc ";
		$consulta = mysqli_query($conexion,$reporte_saldo);
		while(list($id,$fecha,$hora,$desc,$cargo,$s_ant, $s_act) = mysqli_fetch_array($consulta)){
			if($contador%2==1)
				$color = "bgcolor='#EEEEEE'";
			
			echo "<tr $color>";
				echo "<td align='left'>".$id."</td>";
				echo "<td align='left'>".$fecha."</td>";
				echo "<td align='left'>".$hora."</td>";
				echo "<td align='left'>".$desc."</td>";
				echo "<td align='left'>".$cargo."</td>";
				echo "<td align='left'>".$s_ant."</td>";
				echo "<td align='left'>".$s_act."</td>";
			echo "</tr>";
			$contador++;
		}
?>
 </table>