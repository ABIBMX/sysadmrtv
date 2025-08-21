<?php
	require_once('../pdf/class.ezpdf.php');
	require_once('../config.php');
	require_once('../conexion.php');
	require_once('../funciones.php');
	
	$pdf = new Cezpdf('letter','portrait');
	$pdf->selectFont('../pdf/fonts/Helvetica.afm');
	$pdf->ezSetCmMargins(1,1,1,1);
		
	
	/* Creamos un objeto que posteriormente pondremos en todas las páginas del documento */ 
	$Plantilla = $pdf->openObject(); 
	$pdf->saveState(); 
	
	$pdf->restoreState(); 
	$pdf->closeObject(); 
	
	// observe que el objeto se puede decir que aparezca en pagina par, impar o todas cambiando ' 
	// 'all' por 'even' o 'odd' 
	$pdf->addObject($Plantilla,'all'); 
	
	foreach($_POST as $variable => $valor)
	{
		if($variable != "selector")
		{
			if($variable != "accion")
			{
				$id =  $variable;									
			} 
		}
	}
	
	$query = "select c.id_cliente, concat(c.nombre, ' ',apellido_paterno, ' ',apellido_materno), c.num_contrato, c.fecha_contrato, cc.nombre, c.numero, s.nombre  from clientes c, cat_calles cc, sucursales s where cc.id_calle=c.id_calle and s.id_sucursal = c.id_sucursal and c.id_cliente='".addslashes($id)."'";
	
	$registro = @devolverValorQuery($query);
	
	if($registro[0]!="")
	{
		//OBTENEMOS LOS DATOS
		$id_cliente = $registro[0];
		$cliente = $registro[1];
		$num_contrato = $registro[2];
		$fecha_contrato = strtoupper(transformarFecha($registro[3]));
		if($registro[5]!='0')
			$direccion = $registro[4]." No. ".$registro[5].", ".$registro[6];
		else
			$direccion = $registro[4]." S/N, ".$registro[6];
		
			$pdf->addJpegFromFile("../imagenes/tuvision_logo.jpg",20,745,100);
		
		$texto = "Las partes que suscriben el presente contrato están de acuerdo que, para fines de este, los términos empleados en el cuerpo del mismo se sujetan a las siguientes:

<b>DEFINICIONES:</b>

	1.	Concesionario: El titular y/o prestador de servicios de telecomunicaciones principales, de valor agregado, adicionales o conexos, a través de una red publica de telecomunicaciones concesionada por la Secretaria de Comunicaciones y Transportes en una área geográfica determinada, y que suscribe el presente contrato con tal carácter.
	
	2.	Suscriptor: La persona física o moral que celebra un contrato con el CONCESIONARIO por virtud del cual le son prestados los servicios de televisión por cable.
	
	3.	 Servicio Básico: Conjunto de canales establecidos como necesarios para la contratación del servicio.
	
	4.	Pago por Función: Servicio mediante el cual el CONCESIONARIO ofrece uno o varios canales como programación de pago especifico la cual EL CONCESIONARIO hará disponible a EL SUSCRIPTOR mediante mecanismos o sistemas para tener acceso a dicha programación y en todos los casos informara previamente a EL SUSCRIPTOR del costo de cada contratación.
	
	5.	Equipo para servicio de Televisión por Cable: Todos los equipos aparatos y accesorios incluyendo unidades de control remotos, amplificadores, cajas de control, líneas de cable, alambres o planta y en general todo aquello que sea proporcionado, suministrado e instalado por EL CONCESIONARIO a EL SUSCRIPTOR para la recepción de los servicios de televisión por cable.

<b>CLAUSULAS:</b>

I.	EL CONCESIONARIO proporcionara a EL SUSCRIPTOR el servicio de Televisión por Cable mediante el pago por parte de EL SUSCRIPTOR de las cuotas de conexión y las cuotas mensuales vigentes de acuerdo a los términos y tarifas y se encuentran registradas según sea necesario ante EL Instituto Federal de Telecomunicaciones, condiciones y modalidades de operación, de conformidad con la Ley Federa de Telecomunicaciones y demás legislación en la  Materia.

II.	CONCESIONARIO proporcionara a EL SUSCRIPTOR los servicios de televisión por cable  únicamente al numero de aparatos receptores, mediante el pago, por parte del SUSCRIPTOR, de las cuotas de contratación y mensualidad. EL CONCESIONARIO podrá proporcionar el servicio a mas receptores previa contratación que hagan las partes, dentro del domicilio señalado en el presente contrato.

III.	EL SUSCRIPTOR se obliga a efectuar el pago mensual de los servicios contratados por adelantado en los primeros 5 días de cada mes únicamente en las oficinas señaladas por el CONCESIONARIO, para que la tarifa no requiera de pago de intereses moratorios, a partir del 6 dia de pago el precio de renta de servicio incrementara en un 10%.

IV.	EL CONCESIONARIO, sin responsabilidad alguna podrá en todo momento sustituir los canales así como la alineación de los mismos, bastando aviso por cualquier medio en diez días naturales de anticipación a el SUSCRIPTOR.

V.	Tanto el CONCESIONARIO como el SUSCRIPTOR acuerdan expresamente lo siguiente:
a)	Que reconoce las facultades de la Secretaria de Telecomunicaciones y Transportes y del Instituto Federal de Telecomunicaciones para verificar y requerir información, las cuales se precisan en la condición que a continuación se menciona.

VI.	EL CONCESIONARIO podrá suspender el servicio sin ninguna responsabilidad dad cuando EL SUSCRIPTOR deje de pagar alguna mensualidad del servicio contratado. Una vez suspendido el servicio. EL SUSCRIPTOR deberá liquidar las cantidades adeudadas a EL CONCESIONARIO durante el transcurso de mes en que este le fue suspendido. Ya que caso contrario se dará por terminado el presente contrato, debiendo dar cumplimiento EL SUSCRIPTOR a lo estipulado en el mismo.

VII.	En los casos de que se proceda a la reconexión del servicio, EL CONCESIONARIO lo efectuara una vez que EL SUSCRIPTOR haya pagado la cantidad estipulada por Reconexión y de saldos vencidos.

VIII.	Cuando la red se vea afectada por daños provocados por terceros, la empresa no bonificara saldos por falta de señal,  durante el tiempo que dure la reparación de la misma.

IX.	Así como cuando existan fenómenos naturales que afecten la transmisión de la señal, la empresa tampoco podrá realizar bonificaciones. 

X.	La instalación del sistema, dependerá de las facilidades técnicas y físicas que existan alrededor del domicilio, la empresa tendrá de 15 a 20 días hábiles para realizar esta instalación.

XI.	En caso de no cumplir con lo estipulado el cliente podrá solicitar la cancelación de la instalación y se le devolverá el dinero que entrego a la empresa, siempre y cuando presente su recibo de pago.
";
		$pdf->ezText(utf8_decode("\n<b>CONTRATO DE PRESTACION DE SERVICIO DE TELEVISION POR CABLE.</b>"),12,array('justification'=>'center'));
		$pdf->ezText(utf8_decode("\n".$texto),8,array('justification'=>'full'));
		
		
		$y = 120;
		$pdf->addTextWrap (30,$y,100,8,utf8_decode("<b>NÚMERO DE CONTRATO:</b>"),'left');
		$pdf->addTextWrap (155,$y,420,8,$num_contrato,'left');
		$pdf->addTextWrap (30,$y-15,100,8,utf8_decode("<b>FECHA DEL CONTRATO:</b>"),'left');
		$pdf->addTextWrap (155,$y-15,420,8,$fecha_contrato,'left');
		$pdf->addTextWrap (30,$y-30,100,8,utf8_decode("<b>NÚMERO DEL CLIENTE:</b>"),'left');
		$pdf->addTextWrap (155,$y-30,420,8,$id_cliente,'left');
		$pdf->addTextWrap (30,$y-45,140,8,utf8_decode("<b>NOMBRE DEL SUSCRIPTOR:</b>"),'left');
		$pdf->addTextWrap (155,$y-45,420,8,$cliente,'left');
		$pdf->addTextWrap (30,$y-60,140,8,utf8_decode("<b>DOMICILIO DEL SUSCRIPTOR:</b>"),'left');
		$pdf->addTextWrap (155,$y-60,420,8,$direccion,'left');
		
		
		$pdf->ezStream(array("Content-Disposition"=>"NOTA_".date("d/m/Y").".pdf","compress"=>0));
		
		
	}
	else
	{
		echo "No se puede imprimir esta nota";
	}
		
?>