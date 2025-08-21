<?php
	function insertarCaja($sucursal,$cantidad,$tipo_operacion, $suma_resta, $concepto,$id_cliente,$referencia)
	{
		date_default_timezone_set('America/Mexico_City');
		$fecha = date('Y-m-d');
		$hora = date('H:i:s');
		global $conexion;
		
		if($suma_resta==0)
			$suma_resta = "-";
		else
			$suma_resta = "+";
			
		if($id_cliente==NULL)
			$id_cliente = "NULL";
		else
			$id_cliente = "'".addslashes($id_cliente)."'";
			
		$query = "insert into cajas (id_caja,id_sucursal,id_tipo_operacion,cantidad,caja_anterior,caja_actual,fecha_operacion, hora_operacion, concepto, id_cliente, referencia)
		 select 0,'".addslashes($sucursal)."', '".addslashes($tipo_operacion)."' as tipo_operacion, '".addslashes($cantidad)."' as cantidad,
(select ifnull((select  caja_actual from cajas where id_sucursal='".addslashes($sucursal)."' order by fecha_operacion desc, id_caja desc limit 1),0.00)) as saldo_anterior,
((select ifnull((select  caja_actual from cajas where id_sucursal='".addslashes($sucursal)."' order by fecha_operacion desc, id_caja desc limit 1),0.00)) ".$suma_resta." '".addslashes($cantidad)."' )as saldo_actual,
'$fecha', '$hora' ,'".addslashes($concepto)."',".$id_cliente.",'".addslashes($referencia)."'";
		
		mysqli_query($conexion,$query);
		
	}
	
	function eliminarDirectorioCompleto($ruta)
	{
		
		$directorio = @opendir($ruta);
		
		while($archivo = @readdir($directorio))
		{
			if( $archivo !='.' && $archivo !='..' )
			{
				
				//comprobamos si es un directorio o un archivo
				if ( is_dir( $ruta.$archivo ) )
				{
					
					//si es un directorio, volvemos a llamar a la funci�n para que elimine el contenido del mismo
					eliminarDirectorioCompleto( $ruta.$archivo.'/' );
					@rmdir($ruta.$archivo); //borrar el directorio cuando est� vac�o
				}
				else
				{
					//si no es un directorio, lo borramos
					@unlink($ruta.$archivo);
				}
			} 
		}
		@closedir($directorio);
		if(@rmdir($ruta))
			return true;
		else
			return false;
	}
///////////////////////////////////////////////////////////////////////////////
		
	function convertirNumero($numero)
	{
		$cadena = strval($numero);
		$posicion = strpos($cadena, '.');
		$letraE = strpos($cadena,'E');
		$letrae = strpos($cadena,'e');
		if($letraE || $letrae)
		{
			return number_format($numero);
		}
		else
		{
		if($posicion == false)
			return number_format($numero);
		else
			return number_format($numero,2,'.',',');
		}
	}
	function convertirPrecio($numero)
	{
		$cadena = strval($numero);
		$posicion = strpos($cadena, '.');
		$letraE = strpos($cadena,'E');
		$letrae = strpos($cadena,'e');
		if($letraE || $letrae)
		{
			return '$ '.number_format($numero);
		}
		else
		{
		if($posicion == false)
			return '$ '.number_format($numero);
		else
			return '$ '.number_format($numero,2,'.',',');
		}
	}
	
