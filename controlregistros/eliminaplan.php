<?
session_start();
function __autoload($class_name) {
  require_once "../clases/".$class_name . '.php';
}
$NuevaConexion= new BaseDeDatos();
$NuevaConexion->conectar();
$NuevaConexion1= new BaseDeDatos();
$NuevaConexion1->conectar();
$planes=$_GET['planes'];
$accion=$_GET['accion'];
if($accion=='eliminar')
{
	//Recupero en un array todos los chips de ese plan
	$cadena="select * from chip where baja='1' and idPlanes='".$planes."' group by Numero";
	$NuevaConexion->leermysql($cadena);
	while($row=mysql_fetch_array($NuevaConexion->arraymysql()))
	{
		$numero=$row[Numero];
		$cadenax="select idChip from chip where Numero='".$numero."' order by idChip desc limit 1";
		$idChip[]=$NuevaConexion1->recuperaRegistro($cadenax,idChip);
	}
	
	//Muestra los id del chip
	for($i=0;$i<count($idChip);$i++)
	{
		$estado=$NuevaConexion->recuperaRegistro("select * from chip where idChip='".$idChip[$i]."'",estado);
		echo $estado."<br>";
		if($estado=='0' or $estado=='2')
		{
			$eliminaplan="N";
			break;
		}   
	}
	if($eliminaplan=="N")
	{
		?>
		<script>
		alert("El plan no se puede eliminar \n existen chips en base o alquilados a un cliente");
		window.close();
		</script>
		<?	
	}
	else
	{
		//Eliminamos los chips del plan
		for($i=0;$i<count($idChip);$i++)
		{
			$sql1="update chip set baja='0' where idChip='".$idChip[$i]."'";
			$NuevaConexion->leermysql($sql1);
		}
		$sql2="update planes set Baja='0' where idPlanes='".$planes."'";
		$NuevaConexion->leermysql($sql2);
		?>
		<script>
		window.opener.recargar();
		window.close();
		</script>
		<?
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo2 {
	color: #FFFFFF;
	font-size: 16px;
	font-weight: bold;
}
.Estilo3 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo4 {color: #000000}
-->
</style></head>

<body>
<br>
<form name="form1" id="form1" method="get">
<table width="419" border="0" align="center" cellpadding="2" cellspacing="3">
  <tr>
    <td width="409" height="33" bgcolor="#990000"><div align="center" class="Estilo3">Opcion : Eliminar Plan </div></td>
  </tr>
  <tr>
    <td height="73" bgcolor="#FFCC66"><div align="center" class="Estilo2 Estilo4">Esta opci&oacute;n eliminar&aacute; el plan y los chips que lo conforman<br />
  &iquest;Est&aacute; seguro que desea eliminar todo el plan?</div></td>
  </tr>
  <tr>
    <td height="47" bgcolor="#990000"><label>
      <div align="center">
        <input type="submit" name="Submit" value="Eliminar" />
		<input type="hidden" value="eliminar" name="accion" id="accion">
        <input type="hidden" value="<?=$planes;?>" name="planes" id="planes" />
        &nbsp;&nbsp;
        <input type="button" name="Submit2" value="Cancelar" onclick="javascript:window.close();">
      </div>
    </label></td>
  </tr>
</table>
</form>
<p>&nbsp;</p>
</body>
</html>
