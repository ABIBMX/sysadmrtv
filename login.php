<script type="text/javascript" src="jshash-2.2/md5-min.js"></script>
<script language="javascript" type="text/javascript">
	function encriptar()
	{
		document.login.md5password.value = hex_md5(document.login.tuvision_password.value);
		document.login.tuvision_password.value = "";
	}
</script>
<table align="center" width="350px" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="encabezado">
					<tr>
						<td width="5px"  background="imagenes/header_left.png"></td>
						<td width="50px" height="55px" background="imagenes/logo.png" ></td>
						
                        <td height="55px" background="imagenes/header_center2.png"  align="center"> 
                        <?php echo ENCABEZADO; ?>
						</td>
						<td width="5px" height="55px" background="imagenes/header_right.png"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="contenido" style="background:#DDDDFF;">
				<form name="login" action="index.php" method="post" onsubmit="encriptar()">
					<table align="center" style="color:#000000;" width="270px" border="0" cellspacing="0" cellpadding="0">
						<tr><td  height="20px"></td></tr>
						<?php
							if($bandera)
							{
						?>
						<tr><td align="left" class="warning">El usuario y/o password son incorrectos.</td></tr>
						<tr><td  height="15px"></td></tr>
						<?php
							}
						?>
						<tr><td align="left">Usuario:</td></tr>
						<tr><td><input id="login_user" maxlength="25" name="tuvision_usuario" type="text" /></td></tr>
						<tr><td  height="15px"></td></tr>
						<tr><td align="left">Password:</td></tr>
						<tr><td><input id="login_password" name="tuvision_password" maxlength="12" type="password"/><input type="hidden" name="md5password" /></td></tr>
						<tr><td  height="20px"></td></tr>
						<tr><td align="right" ><input type="submit" class="boton" value="Iniciar Sesi&oacute;n"/></td></tr>
						<tr><td  height="20px"></td></tr>
					</table>
				</form>
			</td>
		</tr>
		<tr><td class="footer"><?php echo PIE_PAGINA; ?></td></tr>
	</table>