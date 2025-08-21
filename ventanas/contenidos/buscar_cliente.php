<style type="text/css">
	
	#lista_titles
	{
		display:block;
		border:1px 1px 0px 1px solid #BE7B16;
		padding:0px 2px 0px 0px;
		width:100%;
		height:20px;
		font-size:8px;
		background:#F0B355;
		color:#FFF;
	}
	#lista_titles>div
	{
		display:inline-block;
		padding:5px 5px 5px 5px;
		font-family:Verdana, Geneva, sans-serif;
	}
	#lista_titles .id
	{
		width:12%;
		border-right:1px solid #F7B66F;
	}
	
	#lista_titles .sucursal
	{
		width:12%;
		text-align:center;
		border-right:1px solid #F7B66F;
	}
	
	#lista_clientes
	{
		display:block;
		width:100%;
		height:190px;
		overflow-y:scroll;
		overflow-x:none;
		border:1px solid #CCC;
	}
	#lista_clientes>div
	{
		padding:5px 0px 5px 0px;
		border-bottom:#EEE 1px solid;
		cursor:pointer;
	}
	
	#lista_clientes>div:hover
	{
		background:#FCE8CD;
	}
	
	#lista_clientes>div>div
	{
		display:inline-block;
		padding:0px 5px 0px 5px;
		font-size:8px;
		font-family:Verdana, Geneva, sans-serif;
		overflow:hidden;
	}
	
	#lista_clientes>div:hover div
	{
		border-color:#F7B66F;
		color:#AB6607;
	}
	#lista_clientes .id
	{
		width:12%;
		border-right:1px solid #CCC;
	}
	
	#lista_clientes .sucursal
	{
		width:12%;
		text-align:center;
		border-right:1px solid #CCC;
	}
</style>
<form onsubmit="return false;">
	<div id="modulo" style="display:none;">1</div>
	<table width="100%" cellpadding="2px">
    	<tr> 
        	<td>Nombre o Clave:</td><td><input type="text" name="cliente" style="width:240px;font-size:12px;" id="cliente" /></td><td><button name="buscar_cliente" id="buscar_cliente" style="font-size:12px;">Buscar</button></td></tr>
        </tr>
       	<tr>
        	<td colspan="3">
            	<div id="lista_titles"><div class="id">CLAVE</div><div class="sucursal">SUCURSAL</div><div class="nombre">NOMBRE</div></div>
            	<div id="lista_clientes"><div><center>Para ver resultados realize una b&uacute;squeda.</center></div></div>
            </td>
        </tr>    
    </table>
</form>