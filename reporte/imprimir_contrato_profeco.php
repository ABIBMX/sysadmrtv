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
		
	
		
		
		
		$pdf->ezColumnsStart(array('num'=>2,'gap'=>25));

		
		$texto = "Contrato No. <b>".$num_contrato."</b>";
		$pdf->ezText(utf8_decode("\n".$texto),9,array('justification'=>'right'));

		$texto = "CONTRATO DE PRESENTACIONES DEL SERVICIO(S) DE TELEVISIÓN  (TELEVISIÓN POR CABLE) QUE CELEBRAN POR UNA PARTE MARLA SANTAELLA RODRIGUEZ EL CONCESIONARIO DE LA RED PÚBLICA DE TELECOMUNICACIONES DENOMINADO COMO <b>\"EL  CONCESIONARIO\"</b> Y POR LA OTRA <b>\"EL  SUSCRIPTOR\"</b> CUYO NOMBRE Y DIRECCIÓN SE DETALLAN EN  LA ORDEN DE SERVICIO(S) NO:_________ DE FECHA:___________ Y QUE SE ENCUENTRA ANEXA A ESTE CONTRATO LA CUAL SE TIENE POR REPRODUCIDA COMO SI A LA LETRA SE INSERTARSE QUIENES SE SUJETAN A LAS SIGUIENTES.";
		$pdf->ezText(utf8_decode("\n".$texto),9,array('justification'=>'full'));

		$texto = "<b>DECLARACIONES</b>";
		$pdf->ezText(utf8_decode("\n".$texto),9,array('justification'=>'center'));

		$texto = "EL CONCESIONARIO a través de su representante declara:

A) ser una persona física de nacionalidad mexicana con capacidad legal para celebrar el presente contrato.
B) Que cuenta con un título de concesión otorgado por la Secretaria de Comunicaciones y Transporte para Instalar Operar y Explotar una Red Pública de Telecomunicaciones, autorizo para prestar el Servicio(s) de televisión restringida por cable de fecha 17 de octubre de 2006.
C) Que su domicilio fiscal se encuentra ubicado C. Venustian Carranza, SN, Col Centro, Santa Maria Zacatepec, Oaxaca, con  número telefónico 9545559375, con correo electrónico contacto@tuvision.tv y que está inscrito en el registro federal de contribuyentes bajo el número SARM800402837 y con registro SIEM ______________.
D) Que cuenta con la capacidad, infraestructura y recursos necesarios para dar cabal cumplimiento a las obligaciones contenidas en el presente contrato.
E) Que cuenta con personal técnico y administrativo suficiente y capacitado responsables para atender dudas, aclaraciones y reclamaciones que se originen de la prestación del Servicio(s)(s) para lo cual se señala el teléfono 9545559375 y correo electrónico contacto@tuvision.tv con un horario de atención al público las 24 horas del día todos los días del año.";	
		$pdf->ezText(utf8_decode("\n".$texto),9,array('justification'=>'full'));

		$texto = "<b>CLAUSULAS</b>";
		$pdf->ezText(utf8_decode("\n".$texto),9,array('justification'=>'center'));

		$texto = "<b>PRIMERA.-</b>   EL CONCESIONARIO proporcionara el Servicio(s) de señales de televisión por cable (\"Servicio(s)\") mediante el pago por parte de EL SUSCRIPTOR de la cuota de conexión y las cuotas mensuales por Servicio(s) vigentes que se detallan en la orden de Servicio(s) anexa a este contrato, de acuerdo a los términos y tarifas que se encuentran registradas ante la Comisión Federal de Telecomunicaciones, los cuales pueden consultarse en los centros de atención de EL CONCESIONARIO o en las páginas de internet www.cofetel.gob.mx o en la página web que al efecto proporcione  EL CONCESIONARIO. Se proporcionara el número de señales contratadas única y exclusivamente al número de equipos (tv)  estipuladas en este contrato y a los que se contraten posteriormente amparados en este instrumento.
El Servicio(s) se podrá proporcionar de forma empaquetada o bien, en caso de que EL  CONCESIONARIO cuente con la opción de ofrecer Servicio(s)s por separado, podrá prestarlos de esa manera, para lo cual deberá informar al EL SUSCRIPTOR  los precios o tarifas de estos.
EL CONCESIONARIO deberá instalar el Servicio(s) en el domicilio que proporcione  EL SUSCRIPTOR a más tardar dentro de los siguientes 10 días naturales a la celebración del presente contrato.
<b>SEGUNDA.-</b> Las líneas, aparatos y accesorios del equipo terminal para conexión a los dispositivos del EL SUSCRIPTOR, colocados por EL CONCESIONARIO en el domicilio del EL SUSCRIPTOR son de exclusiva propiedad del EL CONCESIONARIO el cual se entrega a EL SUSCRIPTOR en calidad de comodato
TERCERA.- una vez instalado el equipo terminal y que el Servicio(s) comience a prestarse, EL CONCESIONARIO podrá comenzar a cobrarlo.
El pago de las mensualidades a que se encuentre obligado  EL SUSCRIPTOR, deberá hacerlo en los primero cinco días de cada mes en el domicilio del EL CONCESIONARIO o mediante depósito en la cuenta bancario que al efecto designe este.
Cuando  EL SUSCRIPTOR así lo autorice, el pago podrá efectuarse a través de cargo automático a la tarjeta de crédito o débito de EL SUSCRIPTOR,  para lo cual deberá enviar al domicilio del EL SUSCRIPTOR de manera mensual un estado de cuenta detallado de los Servicio(s) prestados al menos 10 días naturales previos a la fecha de pago.
EL CONCESIONARIO podrá suspender el Servicio(s) sin ninguna responsabilidad para este cuando  EL SUSCRIPTOR deje de cubrir su mensualidad en la fecha en que debería hacerlo o  EL CONCESIONARIO no reciba el pago pactado por cualquier motivo ajeno a este último.
Si EL SUSCRIPTOR durante el mes en que le fuere suspendido el Servicio(s) no liquida el adeudo correspondiente el EL CONCESIONARIO podrá rescindir el presente contrato sin responsabilidad para este
EL CONCESIONARIO deberá reconectar el Servicio(s) dentro de los 5 días hábiles siguientes a la fecha en que se hubiere liquidado el adeudo pendiente y haber cubierto la cuota por reconexión respectiva.
El  CONCESIONARIO no será responsable de la calidad o funcionamiento de los equipos propiedad del EL SUSCRIPTOR, tales como televisiones así como por el uso inadecuado por parte del EL SUSCRIPTOR de los equipos terminales y accesorios que se le hubieran proporcionado con motivo del presente contrato.
<b>CUARTA-</b>  EL CONCESIONARIO dará aviso cuando menos 24 horas previas, a interrupciónes del Servicio(s) derivadas de reparaciones normales, de trabajos de mantenimiento, y o de modificaciones que sean necesarias en las instalaciones de  EL CONCESIONARIO, este no cobrara a el EL SUSCRIPTOR el Servicio(s) por el tiempo que se suspenda el mismo derivado de las reparaciones antes señaladas.
<b>Quinta.-</b>  EL SUSCRIPTOR podrá contratar Servicio(s) adicionales especiales o conexos a los contratados, para lo cual deberá autorizar de manera expresa dicha aceptación, por escrito, vía electrónica o por cualquier otro medio con el que cuente  EL CONCESIONARIO.
En este caso  EL SUSCRIPTOR podrá dar por terminado en cualquier momento los Servicio(s) adicionales, especiales y o conexos contratados, para lo cual deberá expresar dicha terminación por escrito, vía electrónica o por los medio en los que fueron contratados. EL CONCESIONARIO en un plazo de máximo 5 días naturales a partir de  dicha manifestación, deberá cancelarlos, sin que esto implique  la cancelación del Servicio(s) principal.
Para el caso de Servicio(s) adicionales, especiales o conexos, estos se cobraran, por tiempo, evento o cualquier otra modalidad según el tipo de Servicio(s) contratado.
EL CONCESIONARIO en ningún momento podrá obligar a EL SUSCRIPTOR a la contratación de Servicio(s) adicionales al Servicio(s) contratado.
<b>SEXTA.-</b> EL SUSCRIPTOR deberá comunicar en forma inmediata EL CONCESIONARIO las fallas o interrupciones del Servicio(s). Cuando la suspensión exceda de 12 horas consecutivas, incluso por casos fortuitos o de fuerza mayor,  EL CONCESIONARIO hará la compensación por la parte proporcional del periodo en que se dejó de prestar el Servicio(s) en la cuenta de EL SUSCRIPTOR.
<b>SEPTIMA.-</b>  EL CONCESIONARIO podrá solicitar el acceso a  los operarios y empleados de EL CONCESIONARIO, al domicilio de EL SUSCRIPTOR y a las instalaciones dentro del domicilio de este, previa presentación de su credencial o tarjeta de identificación para los efectos de inspección, modificación o reparación de las instalaciones en su caso
<b>OCTAVA.-</b> En virtud de que  EL CONCESIONARIO no es propietario de los canales ni tiene control alguno sobre el contenido de la programación ofrecida, podrán efectuarse cambio en los mismo, en dicho caso  EL CONCESIONARIO deberá notificar fehacientemente a  EL SUSCRIPTOR dicha situación, al menos 15 días naturales previos a que se lleven a cabo dichas modificaciones.
<b>NOVENA.-</b> EL SUSCRIPTOR no podrá traspasar, ceder o anejar a terceros parcial o totalmente los derechos y obligaciones derivados del presente contrato, sin el previo consentimiento por escrito del  EL CONCESIONARIO.
Será causa de recisión del presente contrato si  <b>EL SUSCRIPTOR sin consentimiento previo por escrito por parte del EL CONCESIONARIO</b>, cede, traspasa o enajena parcial o totalmente a un tercero ajeno al presente instrumento, los derechos u obligaciones derivados del presente contrato o si hace uso inadecuado de los equipos o contenidos o programación proporcionados.
Decima.- Las partes convienen en notificarse cualquier cambio en sus domicilios, en el entendido de que si el nuevo domicilio de EL SUSCRIPTOR queda fuera del área de cobertura de prestación del Servicio(s) a cargo de EL CONCESIONARIO, será causa automática de terminación del contrato, sin responsabilidad para las partes EL SUSCRIPTOR por consiguiente, devolverá a  EL CONCESIONARIO el equipo y accesorios que con motivo del presente contrato le hubiere sido proporcionados por  EL CONCESIONARIO.
<b>DECIMA PRIMERA.-</b> la vigencia del presente contrato será indefinida,   EL SUSCRIPTOR  podrá darlo por terminado mediante simple aviso dado  por escrito a EL CONCESIONARIO y este tendrá un plazo de 5 días naturales para cancelar el contrato y suspender el uso del Servicio(s).
En caso de existir imposibilidad técnica para recibir los Servicio(s), se dará por terminado el presente contrato, sin responsabilidad para las partes, para lo cual   EL CONCESIONARIO se obliga a reintegrar las cantidades de dinero otorgadas por anticipado, dentro de un  plazo de 5 días naturales a que se presente dicho supuesto. 
La cancelación del Servicio(s) por parte de  \"EL SUSCRIPTOR\"  no lo exime del pago de las cantidades adeudadas a  \"EL CONCESONARIO\". Este deberá cubrirlas al 100% al momento de la cancelación y devolver los equipos terminales dados en comodato y permitir el retiro de las instalaciones realizadas en el domicilio de este.
<b>DECIMA SEGUNDA.-</b>  serán causas de rescisión del presente contrato, el incumplimiento de las partes a cualquiera de las obligaciones derivadas del mismo, especialmente la falta de pago por parte de \"EL EL SUSCRIPTOR\"  de dos o más de las mensualidades a que se refiere la cláusula tercera.    Siempre  y cuando por causas imputables a  \"EL CONCESIONARIO\"  no se preste el Servicio(s) de telecomunicaciones en la forma y términos convenidos,  este dejara de cobrar a \"EL SUSCRIPTOR\" la parte proporcionar del precio del Servicio(s) que se dejó de prestar, y deberá bonificar el 20% del monto del periodo de afectación.                                     
<b>DECIMA TERCERA.-</b> Toda deficiencia en el Servicio(s) (s) o falla en los equipos terminales deberá informarse de inmediato a \"EL CONCESONARIO\" para que esté realice las labores  tendientes a corregirlas, dentro un plazo máximo de 24 horas hábiles, posteriores a que hizo el aviso respectivo. En caso de que las fallas del equipo  sean imputables a \"EL  CONCESIONARIO\", este deberá abstenerse de cobrar cantidad alguna durante el periodo de afectación.
<b>DECIMA CUARTA.-</b> \"EL  CONCESIONARIO\" pone a disposición de \"EL EL SUSCRIPTOR\", ya sea en los centros de atención de \" EL CONCESIONARIO\",  o en la página web (www.tuvision.tv) que al efecto proporcione  \"EL  CONCESIONARIO\",  los planes o paquetes disponibles,  las áreas o regiones geográficas con cobertura, tarifas, cuotas de reconexión y cualquier otra información  relacionado con la presentación del Servicio(s).                            
<b>DECIMA QUINTA.-</b> En caso de que \"EL  SUSCRIPTOR\" tenga alguna queja respecto a las fallas en el Servicio(s), este podrá llamar al centro de atención a clientes al número 018008367465 las 24 horas del día, todos los días del año.        \"EL SUSCRIPTOR\" podrá presentar una solicitud de aclaración, inconformidad y/o queja, por fallas en el Servicio(s) dentro los 2 días naturales posteriores contados a partir de la fecha que les haya dado origen, por escrito, vía electrónica  o por cualquier otro medio con el que cuente  EL CONCESIONARIO, en el Centro de Atención Telefónica o Centro de Atención a Clientes, detallando los motivos, razones y/o eventos que hayan dado origen a dicha solicitud, señalando un domicilio para envió de correspondencia, un teléfono o una dirección de correo electrónico para recibir respuesta; por cada solicitud se deberá proporcionar un número de folio y/o clave dentro de los siguientes 10 días naturales se deberá dar respuesta a EL SUSCRIPTOR.
<b>DECIMA SEXTA.-</b> Para todo lo relativo a la interpretación, cumplimiento y ejecución del presente contrato, las partes se someten a la jurisdicción de la Procuraduría Federal del Consumidor en la vía administrativa en razón de su materia, sin perjuicio de lo anterior, se someten a la competencia de los tribunales competentes que por razón de domicilio correspondan al domicilio señalado por EL SUSCRIPTOR, renunciando al fuero que por cualquier razón pudiera corresponderles en el presente o futuro.";
		$pdf->ezText(utf8_decode("\n".$texto),9,array('justification'=>'full'));

		$texto = "Leído por las partes el contenido del presente contrato y sabedores de su alcance legal lo firma por duplicado en la ciudad de __________________________________________________, del estado de Oaxaca, a los ____________ días del mes de ________________ del año ______________.";
		$pdf->ezText(utf8_decode("\n".$texto),9,array('justification'=>'full'));

		$texto = "EL SUSCRIPTOR SI (    )  NO (    ) acepta que  EL CONCESIONARIO ceda o transmita a terceros con fines mercadotécnicos o publicitarios la información proporcionada por el con motivo del presente contrato y SI (   ) NO (   ) acepta que el EL CONCESIONARIO le envié publicidad sobre bienes y Servicio(s).";		
		$pdf->ezText(utf8_decode("\n".$texto),9,array('justification'=>'full'));

		$texto = "EL CONCESIONARIO

<u>MARLA SANTAELLA RODRIGUEZ</u>


EL SUSCRIPTOR






<b>".$cliente."</b>
________________________________
NOMBRE Y FIRMA";
		$pdf->ezText(utf8_decode("\n".$texto),9,array('justification'=>'center'));

		$texto = "Este contrato fue aprobado y registrado por la Procuraduría Federal del Consumidor bajo el número 6612-2012 de fecha 19 de diciembre del 2012, cualquier variación del presente contrato en perjuicio del  EL SUSCRIPTOR frente al contrato de adhesión registrado se tendrá por no puesta.";
		$pdf->ezText(utf8_decode("\n".$texto),9,array('justification'=>'full'));
				
		$pdf->ezStream(array("Content-Disposition"=>"NOTA_".date("d/m/Y").".pdf","compress"=>0));
		
	}
	else
	{
		echo "No se puede imprimir esta nota";
	}
		
?>