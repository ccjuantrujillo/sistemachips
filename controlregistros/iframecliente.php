<?
session_start();
//echo $_SESSION['login'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilocaja{color:#2C3174; background-color:#FBECC8; font-weight: bold;}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: none;
	color: #000000;
}
a:active {
	text-decoration: none;
	color: #000000;
}
-->
</style>
</head>
<?PHP 
function __autoload($class_name) {
    require_once "../clases/".$class_name . '.php';
}

$NuevaConexion = new BaseDeDatos();
$NuevaConexion->conectar();
?>

<script language="JavaScript"> 
function alerta(){
		alert('Para registrar datos no puede dejar ningun campo en blanco ');
}
</script>

<p>&nbsp;</p>
<?PHP
//echo $_POST['idoculto'];
if(isset($_POST['oculto']))	   $oculto    = $_POST['oculto'];else $oculto="";
if(isset($_POST['idoculto']))	 $idoculto  = $_POST['idoculto'];else $idoculto="";
if(isset($_POST['nombres']))	 $nombres   = $_POST['nombres'];else $nombres="";
if(isset($_POST['apellidos'])) $apellidos = $_POST['apellidos'];else $apellidos="";
if(isset($_POST['login'])) 		 $login     = $_POST['login'];else $login="";
if(($oculto==1) and !(empty($idoculto)) and !(empty($nombres)) and  !(empty($apellidos)) and !(empty($login)))
{	
	echo "<body>";
	$NuevaConexion->actualizaRegistro('datoscliente','Login,Nombre,Apellido,Direccion,Telefono',"$_POST[login],$_POST[nombres],$_POST[apellidos],$_POST[direccion],$_POST[telefono]",'idDatosCliente',"$_POST[idoculto]",'');
	$oculto = 2;
}
elseif(($oculto==2) and !(empty($nombres)) and  !(empty($apellidos)) and  !(empty($login)))
{
	echo "<body>";
	$sql = "INSERT INTO datoscliente (Nombre,Apellido,Direccion,Telefono,Base,Login) VALUES ("; 
	$sql .= "'".$_POST[nombres]."'";
	$sql .= ",'".$_POST[apellidos]."'";
	$sql .= ",'".$_POST[direccion]."'";
	$sql .= ",'".$_POST[telefono]."'";
	$sql .= ",'1'";
	$sql .= ",'".$_POST[login]."'";
	$sql .= ")";   
	//echo $sql;
	$NuevaConexion->leermysql($sql); 
}
elseif(($oculto==3) and !(empty($idoculto)))
{
	echo "<body>";
	$NuevaConexion->eliminaregistro('datoscliente','idDatosCliente',"$_POST[idoculto]",'','');
	$oculto = 2;
}
else
{
	if($oculto==2)
	{
		echo '<body  onload="alerta()">';

	}
}
if(isset($_GET['id'])) 		 $id     = $_GET['id'];else $id="";
if(!(empty($id)))
{
	$id = $id;
	$NuevaConexion->leermysql("select * from datoscliente where idDatosCliente = '$id'");
	$Cadena_actualizar = mysql_fetch_array($NuevaConexion->arraymysql());
	$mensajeboton = "Actualizar Registro";
	$estado = "Actualizando Registros  de Clientes";
	$oculto = 1;
}
else
{
	$mensajeboton = "Grabar Nuevo Registro";
	$estado = "Registrando Nuevos Clientes";
	$oculto = 2;
}

?>
<table width="720" height="167" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td height="29" bgcolor="#990000"><span class="Estilo1">&nbsp;&nbsp;<? echo $estado ?></span></td>
  </tr>
  <tr>
    <td><table width="720" height="160" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="718" height="158" bgcolor="#990000"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
          <table width="100%" height="132" border="0" cellpadding="3" cellspacing="0">
            <tr>
              <td width="13%"><span class="Estilo1">Nombre(*)</span></td>
              <td width="39%"><input name="nombres" type="text" class="Estilocaja" id="nombres" value="<?PHP echo $Cadena_actualizar[Nombre] ?>" size="30" maxlength="50" /></td>
              <td width="11%"><span class="Estilo1">Telefono : </span></td>
              <td width="37%"><input name="telefono" type="text" class="Estilocaja" id="telefono" value="<?PHP echo $Cadena_actualizar[Telefono] ?>" size="25" maxlength="12" /></td>
            </tr>
            <tr>
              <td><span class="Estilo1">Apellido(*)</span></td>
              <td><input name="apellidos" type="text" class="Estilocaja" id="apellidos" value="<?PHP echo $Cadena_actualizar[Apellido] ?>" size="30" maxlength="50" /></td>
              <td><span class="Estilo1">Login(*)</span></td>
              <td><input name="login" type="text" class="Estilocaja" id="login" value="<?PHP echo $Cadena_actualizar[Login] ?>" size="25" maxlength="20" />
                <label></label>
                <input name="oculto" type="hidden" id="oculto" value="<?PHP echo $oculto ?>" />
                <input name="idoculto" type="hidden" id="idoculto" value="<?PHP echo $Cadena_actualizar[idDatosCliente] ?>" /></td>
            </tr>
            <tr>
              <td height="52"><span class="Estilo1">Direcci&oacute;n</span></td>
              <td><input name="direccion" type="text" class="Estilocaja" id="direccion" value="<?PHP echo $Cadena_actualizar[Direccion] ?>" size="30" maxlength="100" /></td>
              <td colspan="2"><div align="center">
                <input type="submit" name="Submit" value="<?PHP echo $mensajeboton ?>" />
  &nbsp;&nbsp;&nbsp; </div></td>
              </tr>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
<tr height="30" valign="middle">
	<td align="right">
	<?
	$cadena="select * from datoscliente order by Nombre";
	$tabla=new ListaDatos($cadena,'xls','');
	$tabla->recuperaLista();
	?>
	</td>
</tr>
</table>

<table width="720" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="414" bgcolor="#990000"><div align="center" class="Estilo1">Nombres y Apellidos</div></td>
    <td width="101" bgcolor="#990000"><div align="center" class="Estilo1">Telefono</div></td>
    <td width="129" bgcolor="#990000"><div align="center" class="Estilo1">Login</div></td>
    <td width="66" bgcolor="#990000"><div align="center" class="Estilo1">Eliminar</div></td>
  </tr><?PHP
  $NuevaConexion->leermysql($cadena);
while($lista = mysql_fetch_array($NuevaConexion->arraymysql()))
{
?>
  <tr>
    <td bgcolor="#FBECC8">&nbsp;<a href="iframecliente.php?id=<? echo $lista[idDatosCliente]  ?>"><? echo $lista[Nombre]." ".$lista[Apellido]; ?><img src="imagenes/b_edit.png" alt="Editar" width="16" height="16" border="0" /></a></td>
    <td bgcolor="#FBECC8"><? echo $lista[Telefono]; ?></td>
    <td bgcolor="#FBECC8">
    <div align="left"><? echo $lista[Login]; ?></div>    </td>
    <td bgcolor="#FBECC8">
	<div align="center">
		<a href="javascript:mensaje(<? echo $lista[idDatosCliente];?>);"><img src="imagenes/borrar.gif" width="16" height="16" border='0'></a>	</div>	</td>
  </tr>

<?PHP
}
  ?>
  <tr>
    <td colspan="4" bgcolor="#990000">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<script>
function mensaje(id)
{
  if(confirm("Esta seguro que desea borrar"))
  {
    document.form1.oculto.value='3';
    document.form1.idoculto.value=id;    
    document.form1.submit();
  }
}
</script>
