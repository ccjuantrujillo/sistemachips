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
//echo "Id Rol".$_POST[idoculto]."<br>";
//echo "Nombre".$_POST[nombre]."<br>";
//echo "oculto".$_POST[oculto]."<br>";
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
if(($_POST[oculto]==1) and !(empty($_POST[idoculto])) and !(empty($_POST[nombre])))
{	
	echo "<body>";
	$NuevaConexion->actualizaRegistro('rol','Nombre',"$_POST[nombre]",'idRol',"$_POST[idoculto]",'');
	$oculto = 2;
}
elseif(($_POST[oculto]==2) and !(empty($_POST[nombre])))
{
	echo "<body>";
	$sql = "INSERT INTO rol (Nombre) VALUES ("; 
	$sql .= "'".$_POST[nombre]."'";
	$sql .= ")";   
	$NuevaConexion->leermysql($sql); 
}
elseif(($_POST[oculto]==3) and !(empty($_POST[idoculto])))
{
	echo "<body>";
	$NuevaConexion->eliminaregistro('rol','idRol',"$_POST[idoculto]",'administradores','idRol');
	$oculto = 2;
}
else
{
	if($_POST[oculto]==2)
	{
		echo '<body  onload="alerta()">';

	}
	
}

if(!(empty($_GET[id])))
{
	$id = $_GET[id];
	$NuevaConexion->leermysql("select * from rol where idRol = '$id'");
	$Cadena_actualizar = mysql_fetch_array($NuevaConexion->arraymysql());
	$mensajeboton = "Actualizar Registro";
	$estado = "Actualizando Registros  de Roles";
	$oculto = 1;
}
else
{
	$mensajeboton = "Grabar Nuevo Registro";
	$estado = "Registrando de Nuevos Roles";
	$oculto = 2;
};
?>
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td bgcolor="#990000"><span class="Estilo1">&nbsp;&nbsp;<? echo $estado;?></span></td>
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
                  <input name="nombre" type="text" class="Estilocaja" id="nombre" value="<?PHP echo $Cadena_actualizar[Nombre];?>" size="43">
                </label></td>
                <td width="169" rowspan="2"><label>
                    <div align="center">
                      <input type="submit" name="Submit" value="<?PHP echo $mensajeboton;?>">
                      <input type="hidden" name="idoculto" id="idoculto" value="<?=$Cadena_actualizar[idRol];?>">
                      <input type="hidden" name="oculto" id="oculto" value="<?=$oculto;?>">
                    </div>
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
	$cadena="select * from rol";
	$tabla=new ListaDatos($cadena,'xls','');
	$tabla->recuperaLista();
	?>
	</td>
</tr>
</table>



<table width="720" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="620" bgcolor="#990000"><div align="center" class="Estilo1">Nombre</div></td>
    <td width="70" bgcolor="#990000"><div align="center" class="Estilo1">Eliminar</div></td>
  </tr>
<?
$NuevaConexion->leermysql("select * from rol");
while($lista = mysql_fetch_array($NuevaConexion->arraymysql()))
{
?>
  <tr>
    <td bgcolor="#FBECC8">&nbsp;<a href="iframeroles.php?id=<? echo $lista[idRol] ;?>"><? echo $lista[Nombre];?><img src="imagenes/b_edit.png" alt="Editar" width="16" height="16" border="0" /></a></td>
    <td bgcolor="#FBECC8"><div align="center"><a href="javascript:mensaje(<? echo $lista[idRol];?>);"><img src="imagenes/borrar.gif" width="16" height="16" border="0"></a></div></td>
  </tr>

<?PHP
}
?>
  <tr>
    <td colspan="3" bgcolor="#990000">&nbsp;</td>
  </tr>
</table>
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
