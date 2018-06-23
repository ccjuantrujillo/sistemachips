<?
session_start();
//echo $_SESSION['login'];
$idAdministrador=$_SESSION['idAdministrador'];
$contrasena=$_SESSION['contrasena'];
//echo "$idAdministrador $contrasena";
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
//echo "Id Oculto".$_POST[idoculto]."<br>";
//echo "Nombre".$_POST[passwd]."<br>";
//echo "oculto".$_POST[nuevopasswd]."<br>";
//echo "oculto".$_POST[nuevopasswd1]."<br>";
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
//echo $_POST['oculto'];
if(($_POST[oculto]==1) and !(empty($_POST[passwd])) and !(empty($_POST[nuevopasswd])) and !(empty($_POST[nuevopasswd1])))
{	
	echo "<body>";
	$NuevaConexion->leermysql("select count(*) from administradores where login='".$_SESSION['login']."' and contrasena='".md5($_POST['passwd'])."'");
	$row1=mysql_fetch_array($NuevaConexion->arraymysql());
	//echo "Cantidad registros".$row1['0'];
	if($row1['0']==1)
	{
		if($_POST['nuevopasswd']==$_POST['nuevopasswd1'])
		{
			$nuevaContrasena=md5($_POST[nuevopasswd1]);
			$NuevaConexion->actualizaRegistro('administradores','contrasena',$nuevaContrasena,'idAdministrador',$idAdministrador,'');
			$txt4="<script>alert('Se cambio el password del sistema correctamente')</script>";
			$txt4.="<script>location.href='iframeindex.php'</script>";
			echo $txt4;
		}
		else
		{
			$txt2="<script>alert('Los campos nuevo password no coinciden')</script>";
			echo $txt2;
		}
	}
	else
	{
		$txt1="<script>alert('El password actual del usuario no es correcto')</script>";
		echo $txt1;
	}
	$oculto = 2;
}
elseif($_POST[oculto]==1 and ((empty($_POST[passwd])) || (empty($_POST[nuevopasswd])) || (empty($_POST[nuevopasswd1]))))
{
	$txt5="<script>alert('Debe llenar TODOS campos')</script>";
	echo $txt5;
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

	$oculto = 1;
}
else
{
	$mensajeboton = "Grabar Nuevo Registro";

	$oculto = 1;
};
?>
<body onload="document.form1.passwd.focus();"> 
<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td bgcolor="#990000"><span class="Estilo1">&nbsp;&nbsp;Cambio de Password</span></td>
  </tr>
  <tr>
    <td><table width="720" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="196" bgcolor="#990000">
		        <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <table width="709" border="0" align="center" cellpadding="3" cellspacing="3">
                    <tr>
                      <td height="41"><span class="Estilo1">Password</span></td>
                      <td><input name="passwd" type="password" class="Estilocaja" id="passwd" value="<?PHP echo $Cadena_actualizar[Nombre];?>" size="30" /></td>
                      <td width="210" rowspan="4" valign="bottom"><label>
                        <div align="center">
                          <input type="submit" name="Submit" value="Cambiar">
                          <input type="hidden" name="idoculto" id="idoculto" value="<?=$idAdministrador;?>">
                          <input type="hidden" name="oculto" id="oculto" value="<?=$oculto;?>">
                        </div>
                      </label></td>
                    </tr>
                  <tr>
                    <td height="41"><span class="Estilo1">Nuevo Password </span></td>
                    <td><input name="nuevopasswd" type="password" class="Estilocaja" id="nuevopasswd" value="<?PHP echo $Cadena_actualizar[Nombre];?>" size="30" /></td>
                  </tr>
                <tr>
                <td width="135" height="48"><span class="Estilo1">Reescriba Password </span></td>
                <td width="334"><label>
                  <input name="nuevopasswd1" type="password" class="Estilocaja" id="nuevopasswd1" value="<?PHP echo $Cadena_actualizar[Nombre];?>" size="30" />
                </label></td>
                </tr>
            </table>
        </form>
		
		</td>
      </tr>
      <tr>
        <td width="718" height="23" bgcolor="#990000"></td>
      </tr>
    </table></td>
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
