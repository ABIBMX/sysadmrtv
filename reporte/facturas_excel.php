<?php
	session_start();
	if(isset($_SESSION['filtro_tuvision_facturas_addquery'])){
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment;filename=Facturas_".date("Y/m/d").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	require_once('../config.php');
	require_once('../conexion.php');

	
		?>
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td colspan="7"><b>Reporte de Facturas</b> Generado:&nbsp;<?php echo date("Y/m/d"); ?></td>
           	</tr>            
        </table>
         <br />
        <table border="1" cellpadding="3" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	<th>ID Factura</th>
                <th>Proveedor</th>
                <th>Descripcion</th>
                <th>Tipo</th>
                <th>Tipo Moneda</th>
                <th>Tiene IVA</th>
                <th>Subtotal</th>
                <th>IVA</th>
                <th>Total</th>
                <th>Tipo de Cambio</th>
                <th>Importe a Pagar MXN</th>
                <th>Total Pagado</th>
                <th>Saldo Factura</th>
                <th>Status</td>
                <th>Fecha de Recepcion</th>
                <th>Fecha de Pago</th>
                <th>Fecha de Captura</th>
                <th>Usuario Capturo</th>
            </tr>
       
        
<?php
		$contador=0;
		
		$query = "select f.id_factura,
						 p.nombre,
						 f.descripcion, 
						 tf.nombre,
						 tm.nombre,
						 f.tiene_iva,
						 f.subtotal,
						 f.iva,
						 f.total,
						 f.tipo_cambio,
						 f.importe_a_pagar_mxn,
						 f.total_pagado,
						 f.saldo_factura,
						 s.nombre,
						 f.fecha_recepcion, 
						 f.fecha_pago,
						 f.fecha_captura,
						 f.id_usuario
						 from f_facturas f, f_cat_proveedor p, f_status_factura s, f_cat_tipo_factura tf, f_cat_tipo_moneda tm where tm.id_tipo=f.id_tipo_moneda and tf.id_tipo=f.id_tipo and  p.id_proveedor=f.id_proveedor and f.id_status=s.id_status".$_SESSION['filtro_tuvision_facturas_addquery'];

		$consulta = mysqli_query($conexion,$query);
		while($registro = mysqli_fetch_array($consulta)){
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			
			echo "<tr $color>";
				echo "<td align='left'>".$registro[0]."</td>";
				echo "<td align='left'>".$registro[1]."</td>";
				echo "<td align='left'>".$registro[2]."</td>";
				echo "<td align='left'>".$registro[3]."</td>";
				echo "<td align='left'>".$registro[4]."</td>";
				
				if($registro[5]=="1")
					echo "<td align='left'>SI</td>";
				else
					echo "<td align='left'>NO</td>";
				
				echo "<td align='right'>".$registro[6]."</td>";
				echo "<td align='right'>".$registro[7]."</td>";
				echo "<td align='right'>".$registro[8]."</td>";
				echo "<td align='right'>".$registro[9]."</td>";
				echo "<td align='right'>".$registro[10]."</td>";
				echo "<td align='right'>".$registro[11]."</td>";
				echo "<td align='right'>".$registro[12]."</td>";

				echo "<td align='left'>".$registro[13]."</td>";
				echo "<td align='left'>".$registro[14]."</td>";
				echo "<td align='left'>".$registro[15]."</td>";
				echo "<td align='left'>".$registro[16]."</td>";
				echo "<td align='left'>".$registro[17]."</td>";
			echo "</tr>";
			$contador++;
		}
	?>
 	</table>
	<?php
		}
	?>