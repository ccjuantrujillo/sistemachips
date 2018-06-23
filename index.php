<html>
<script language="javascript" src="jshash/md5.js"></script>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.Estilo3 {
	font-size: 18px;
	font-weight: bold;
}
-->
</style>
<body onLoad="document.a.user.focus();">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center">QUINTUM ::: ANTIGUO</p>
<table width="393" height="181" border="6" align="center" cellpadding="3" cellspacing="0" bgcolor="#ff0000">
  <tr>
    <td width="375" height="157">
	<form method="post" name="a" id="a">
<table width="350" height="160" border="0" align="center" cellpadding="4" cellspacing="2" bordercolor="#990000">
<tr>
	<td height="44" colspan="2" align="center"><span class="Estilo3">ACCESO AL SISTEMA <img src="controlregistros/imagenes/candado.gif" width="16" height="17"></span></td>
</tr>
<tr>
	<td width="105"><div align="right"><strong>Usuario : </strong></div></td>
	<td width="223"><input name="user" type="text" id="user" size="28"></td>
</tr>
<tr>
	<td><div align="right"><strong>Password : </strong></div></td>
	<td><input name="password" type="password" id="password" size="28" onKeyDown="enter(event);">
	<input name="numero" type="hidden" id="numero" size="28" value="<?=$numero;?>">
	</td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="button" value="Ingresar" onclick="enviar();"></td>
</tr>
</table>
</form>
	</td>
  </tr>
</table>
<br>
</body>
</html>
<script>
function redirigir()
{
	location.href="../salir.php";
}
function mensaje(valor)
{
	alert(valor);
}
function llenarnumero()
{
	document.a.numero.value='';
}
function borracampos()
{
	document.a.user.value='';
	document.a.password.value='';
}
</script>
<script language="javascript">
function enviar()
{
	var usuario=document.a.user.value;
	var contrasena=document.a.password.value;
	//alert(contrasena);
	var url="controlregistros/user.php?user="+usuario+"&password="+hex_md5(contrasena);
	nuevaVentana=window.open(url,'',"width='1300',height='908','fullscreen=1,scrollbars=NO,Status=NO'");
	nuevaVentana.focus();
}
function enter(e)
{
	var k=null;
	(e.keyCode) ? k=e.keyCode : k=e.which;
	if(k==13)
	{
		//alert("usted presiona la techa enter");
		enviar();
	}
}
</script>
