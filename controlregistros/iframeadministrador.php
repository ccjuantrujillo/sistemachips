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
//echo "Apellidos".$_POST[apellidos]."<br>";
//echo "oculto".$_POST[oculto]."<br>";
//echo $_POST['rol'];
function __autoload($class_name) {
    require_once "../clases/".$class_name . '.php';
}

$NuevaConexion = new BaseDeDatos();
$NuevaConexion->conectar();
?>

<script language="JavaScript"> 
function alerta()
{
   alert('Para registrar datos no puede dejar ningun campo en blanco ');
}
</script>

<p>&nbsp;</p>
<?PHP
if(($_POST[oculto]==1) and !(empty($_POST[idoculto])) and !(empty($_POST[nombre])) and !(empty($_POST[apellidos])) and $_POST[rol]!='n' and !(empty($_POST[contrasena])) and !(empty($_POST[login])))
{	
	echo "<body>";
	if($_POST[contrasena]!=$_POST[contrasenax])
	{
		$contrasenamd5=md5($_POST[contrasena]);
		$NuevaConexion->actualizaRegistro('administradores','nombre,apellidos,idRol,login,contrasena',"$_POST[nombre],$_POST[apellidos],$_POST[rol],$_POST[login],$contrasenamd5",'idAdministrador',"$_POST[idoculto]",'');
	}
	else
	{
		$NuevaConexion->actualizaRegistro('administradores','nombre,apellidos,idRol,login',"$_POST[nombre],$_POST[apellidos],$_POST[rol],$_POST[login]",'idAdministrador',"$_POST[idoculto]",'');		
	}
	$oculto = 2;
}
elseif(($_POST[oculto]==2) and !(empty($_POST[nombre])) and !(empty($_POST[apellidos])) and $_POST[rol]!='n' and !(empty($_POST[login])) and !(empty($_POST[contrasena])))
{
	echo "<body>";
	$sql = "insert into administradores (nombre,apellidos,idRol,login,contrasena) VALUES ("; 
	$sql .= "'".$_POST[nombre]."',";
	$sql .= "'".$_POST[apellidos]."',";
	$sql .= "'".$_POST[rol]."',";
	$sql .= "'".$_POST[login]."',";
	$sql .= "'".md5($_POST[contrasena])."'";
	$sql .= ")";	
	$NuevaConexion->leermysql($sql); 
}
elseif(($_POST[oculto]==3) and !(empty($_POST[idoculto])))
{
	//Elimina registros
	echo "<body>";
	$NuevaConexion->eliminaregistro('administradores','idAdministrador',"$_POST[idoculto]",'','');
	$oculto = 2;
}
else
{
	if($_POST[oculto]==2)
	{
		echo '<body  onload="alerta()">';
	}
}
//echo "<br>Id".$_GET[id];
if(!(empty($_GET[id])))
{
	$id = $_GET[id];
	$NuevaConexion->leermysql("select * from administradores where idAdministrador = '$id'");
	$Cadena_actualizar = mysql_fetch_array($NuevaConexion->arraymysql());
	$rs5=mysql_query("select * from rol where idRol='$Cadena_actualizar[idRol]'");
	$row5=mysql_fetch_array($rs5);
	$n_Rol=$row5['Nombre'];
	$mensajeboton = "Actualizar Registro";
	$estado = "Actualizando Registros  de Administradores";
	$oculto = 1;
}
else
{
	$mensajeboton = "Grabar Nuevo Registro";
	$estado = "Registrando de Nuevos Administradores";
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
            <table width="709" height="186" border="0" align="center" cellpadding="3" cellspacing="3">
              <tr>
                <td width="98" height="28"><span class="Estilo1">Nombre</span></td>
                <td width="412"><label>
                  <input name="nombre" type="text" class="Estilocaja" id="nombre" value="<?PHP echo $Cadena_actualizar[nombre];?>" size="43">
                </label></td>
		<td width="169" rowspan="5" valign="bottom"><div align="center">
                    <input type="submit" name="Submit" value="<?PHP echo $mensajeboton;?>" />
                    <input type="hidden" name="idoculto" id="idoculto" value="<?=$Cadena_actualizar[idAdministrador];?>" />
                    <input type="hidden" name="oculto" id="oculto" value="<?=$oculto;?>" />
                        </div>
                  <label></label></td>
              </tr>
              <tr>
                  <td width="98" height="28"><span class="Estilo1">Apellidos</span></td>
                  <td width="412"><label><input name="apellidos" type="text" class="Estilocaja" id="apellidos" value="<?PHP echo $Cadena_actualizar[apellidos];?>" size="43"></label></td>              
                </tr>
              <tr>
                <td height="25"><span class="Estilo1">Rol</span></td>
                <td><?
                  $NuevoCombobox1 = new ComboBoxChangue("rol","","idRol","Nombre","Estilocaja",$Cadena_actualizar[idRol],"");	
				  $NuevoCombobox1->RescatarCombobox();    
                ?></td>
                </tr>
              <tr>
                <td height="28"><span class="Estilo1">Login</span></td>
                <td><input name="login" type="text" class="Estilocaja" id="login" value="<?PHP echo $Cadena_actualizar[login];?>" size="43" /></td>
                </tr>
              <tr>
                <td width="98" height="28"><span class="Estilo1">Contrasena</span></td>
                <td width="412">
                <label>
                <input name="contrasena" type="password" class="Estilocaja" id="contrasena" value="<?PHP echo $Cadena_actualizar[contrasena];?>" size="43" />
				<input style="display:none;" name="contrasenax" type="password" class="Estilocaja" id="contrasenax" value="<?PHP echo $Cadena_actualizar[contrasena];?>" size="43" />
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
	$cadena="select * from administradores";
	$tabla=new ListaDatos($cadena,'xls','');
	$tabla->recuperaLista();
	?>
	</td>
</tr>
</table>



<table width="720" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="333" bgcolor="#990000"><div align="center" class="Estilo1">Nombre y Apellidos</div></td>
    <td width="155" bgcolor="#990000"><div align="center" class="Estilo1">Rol</div></td>
    <td width="141" bgcolor="#990000"><div align="center"><span class="Estilo1">Login</span></div></td>
    <td width="81" bgcolor="#990000"><div align="center" class="Estilo1">Eliminar</div></td>
  </tr>
<?
$NuevaConexion8 = new BaseDeDatos();
$NuevaConexion8->conectar();
$NuevaConexion8->leermysql("select * from administradores");
while($lista = mysql_fetch_array($NuevaConexion8->arraymysql()))
{
$rs4=mysql_query("select nombre from rol where idRol='$lista[idRol]'");
$row4=mysql_fetch_array($rs4);
$nombreRol=$row4['nombre'];
?>
  <tr>
    <td bgcolor="#FBECC8">&nbsp;
	<a href="iframeadministrador.php?id=<? echo $lista[idAdministrador] ;?>"><? echo "$lista[nombre] $lista[apellidos]" ;?>
	<img src="imagenes/b_edit.png" alt="Editar" width="16" height="16" border="0" /></a></td>
    <td bgcolor="#FBECC8" align="left"><?=$nombreRol;?></td>
    <td bgcolor="#FBECC8" align="left"><?=$lista[login];?></td>
    <td align="center" valign="middle" bgcolor="#FBECC8">
		<a href="javascript:mensaje(<? echo $lista[idAdministrador];?>);">
		<img src="imagenes/borrar.gif" width="16" height="16" border="0">		</a></td>
  </tr>

<?PHP
}
?>
  <tr>
    <td colspan="4" bgcolor="#990000">&nbsp;</td>
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
