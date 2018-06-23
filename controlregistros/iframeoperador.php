<?
session_start();
//if(!$loginCorrecto)		header('Location:../index.php');
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
//echo "Oculto".$_POST['oculto']."<br>";
//echo "IdOculto".$_POST['idoculto']."<br>";
//echo "Logo".$_FILES['logo']['name']."<br>";
if(isset($_POST['txtlogo'])) $txtlogo=$_POST['txtlogo'];else $txtlogo="";//Imagen antigua
if(isset($_POST['oculto']))	  $oculto   = $_POST['oculto'];else $oculto="";
if(isset($_POST['idoculto']))	$idoculto = $_POST['idoculto'];else $idoculto="";
if(isset($_POST['nombre']))	  $nombre   = $_POST['nombre'];else $nombre="";
if($_FILES['logo']['name']=="")		
{
	//echo "No envio imagen<br>";
	$rutalogo=$txtlogo;
}
else
{
	//echo "Envio imagen nuevo<br>";
	$rutalogo="imagenes/".$_FILES['logo']['name'];
	$tipofile=$_FILES['logo']['type'];
	if($tipofile="image/gif" || $tipofile="image/png" || $tipofile="image/jpeg")
	{
		copy($_FILES['logo']['tmp_name'],$rutalogo);
	}
}
if(($oculto==1) and !(empty($idoculto)) and !(empty($nombre)))
{	
	echo "<body>";
	$NuevaConexion->actualizaRegistro('operador','Nombre,logo',"$_POST[nombre],$rutalogo",'idOperador',"$_POST[idoculto]",'');
	$oculto = 2;
}
elseif(($oculto==2) and !(empty($nombre)))
{
	echo "<body>";
	$sql = "INSERT INTO operador(Nombre,Logo) VALUES ("; 
	$sql .= "'".$_POST[nombre]."'";
	$sql .= ",'".$rutalogo."'";
	$sql .= ")";   
	$NuevaConexion->leermysql($sql); 
}
elseif(($oculto==3) and !(empty($idoculto)))
{
	echo "<body>";
	$NuevaConexion->eliminaregistro('operador','idOperador',"$_POST[idoculto]",'','');
	$oculto = 2;
}
else
{
	if($oculto==2)
	{
		echo '<body  onload="alerta()">';
	}
}
if(!(empty($_GET['id'])))
{
	$id = $_GET[id];
	$NuevaConexion->leermysql("select * from operador where idOperador = '$id'");
	$Cadena_actualizar = mysql_fetch_array($NuevaConexion->arraymysql());
	$mensajeboton = "Actualizar Registro";
	$estado = "Actualizando Registros  de Operadores";
	$oculto = 1;
}
else
{
	$mensajeboton = "Grabar Nuevo Registro";
	$estado = "Registrando Nuevos Operadores";
	$oculto = 2;
}

?>
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td bgcolor="#990000"><span class="Estilo1">&nbsp;&nbsp;<? echo $estado ?></span></td>
  </tr>
  <tr>
    <td><table width="720" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="718" bgcolor="#990000">
		<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <table width="709" border="0" align="center" cellpadding="3" cellspacing="3">
              <tr>
                <td width="98" height="41"><span class="Estilo1">Nombre</span></td>
                <td width="412"><label>
                  <input name="nombre" type="text" class="Estilocaja" id="nombre" value="<?PHP echo $Cadena_actualizar[Nombre] ?>" size="45" />
                </label></td>
                <td width="169" rowspan="2"><label>
                    <div align="center">
                      <input type="submit" name="Submit" value="<?PHP echo $mensajeboton ?>">
                    </div>
                  </label></td>
              </tr>
              <tr>
                <td height="38"><span class="Estilo1">Logo</span></td>
                <td><label>
                  <input name="logo" type="file" class="Estilocaja" id="logo" value="<?PHP echo $Cadena_actualizar[Logo] ?>">
				  <input name="txtlogo" type="hidden" id="txtlogo" value="<?PHP echo $Cadena_actualizar[Logo] ?>" />
				  <input name="oculto" type="hidden" id="oculto" value="<?PHP echo $oculto ?>" />
                  <input name="idoculto" type="hidden" id="idoculto" value="<?PHP echo $Cadena_actualizar[idOperador] ?>" />
                </label></td>
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
	$cadena="select * from operador order by Nombre";
	$tabla=new ListaDatos($cadena,'xls','');
	$tabla->recuperaLista();
	?>
	</td>
</tr>
</table>


<table width="720" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="487" bgcolor="#990000"><div align="center" class="Estilo1">Nombre</div></td>
    <td width="155" bgcolor="#990000"><div align="center" class="Estilo1">Logo</div></td>
    <td width="70" bgcolor="#990000"><div align="center" class="Estilo1">Eliminar</div></td>
  </tr>
<?PHP
$NuevaConexion->leermysql("select idOperador,Nombre,Logo from operador order by Nombre");
while($lista = mysql_fetch_array($NuevaConexion->arraymysql()))
{
$cadena1="select Nombre from planes where idOperador='".$lista['idOperador']."' and Baja='1'";
$tabla=new ListaDatos($cadena1,'txt','');
?>
  <tr>
    <td bgcolor="#FBECC8" title="<?=$tabla->recuperaLista();?>">&nbsp;<a href="iframeoperador.php?id=<? echo $lista['idOperador'];?>"><? echo $lista['Nombre']; ?><img src="imagenes/b_edit.png" alt="Editar" width="16" height="16" border="0" /></a></td>
    <td bgcolor="#FBECC8">
    <div align="center"><img src="<? echo $lista[Logo]; ?>" border="0" width="20" height="20"></div></td>
    <td bgcolor="#FBECC8">
	<div align="center">
		<a href="javascript:mensaje(<? echo $lista[idOperador];?>);"><img src="imagenes/borrar.gif" width="16" height="16" border="0"></a>
	</div>
	</td>
  </tr>
<?PHP
}
  ?>
  <tr>
    <td colspan="3" bgcolor="#990000">&nbsp;</td>
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
