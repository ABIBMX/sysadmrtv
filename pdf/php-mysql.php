<?php
require('../config.php');
require('../funciones/mysql.php');
require_once('class.ezpdf.php');
$pdf = new Cezpdf('a4');
$pdf->selectFont('../fonts/courier.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);

$queEmp = "SELECT usuario.nombre,usuario.fecha_reg, usuario.last_vi, pedido.fecha, pedido.totalped FROM usuario,pedido where usuario.idusuario=pedido.idcliente GROUP BY pedido.numref order by pedido.fecha desc";
$resEmp = mysqli_query($conexion,$queEmp) or die(mysqli_error($conexion));
$totEmp = mysqli_num_rows($resEmp);

$ixx = 0;
while($datatmp = mysqli_fetch_assoc($resEmp)) { 
	$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));
}
$titles = array(
				'num'=>'<b>Num</b>',
				'nombre'=>'<b>Nombre</b>',
				'fecha_reg'=>'<b>Fecha de registro</b>',
				'last_vi'=>'<b>Ultima visita</b>',
				'fecha'=>'<b>Ultima compra</b>',
				'totalped'=>'<b>Monto</b>'
			);
$options = array(
				'shadeCol'=>array(0.9,0.9,0.9),
				'xOrientation'=>'center',
				'width'=>500
			);
$txttit = "                                           <b>REPORTE DE USUARIOS QUESONRISA</b>                          \n";


$pdf->ezText($txttit, 12);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Reporte generado el dia:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>A las:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();
?>