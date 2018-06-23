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
.Estilo1 {color: #FFFFFF;font-weight: bold;}
.Estilo2 {font-family:Verdana;font-size:13px;font-style:normal;color:#000000;}
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
if(isset($_POST['oculto']))	   $oculto   = $_POST['oculto'];else $oculto="";
if(isset($_POST['idoculto']))	 $idoculto = $_POST['idoculto'];else $idoculto="";
if(isset($_POST['nombres']))	 $nombres  = $_POST['nombres'];else $nombres="";
if(isset($_POST['apellidos'])) $apellidos  = $_POST['apellidos'];else $apellidos="";
if(($oculto==1) and !(empty($idoculto)) and !(empty($nombres)) and  !(empty($apellidos)))
{	
	echo "<body>";
	$NuevaConexion->actualizaRegistro('provedor','Nombres,Apellidos,Comentario',"$_POST[nombres],$_POST[apellidos],$_POST[comentario]",'idProvedor',"$_POST[idoculto]",'');
	$oculto = 2;
}
elseif(($oculto==2) and !(empty($nombres)) and  !(empty($apellidos)))
{
	echo "<body>";
	$sql = "INSERT INTO provedor(Nombres,Apellidos,Comentario) VALUES ("; 
	$sql .= "'".$_POST[nombres]."'";
	$sql .= ",'".$_POST[apellidos]."'";
	$sql .= ",'".$_POST[comentario]."'";
	$sql .= ")";   
	$NuevaConexion->leermysql($sql); 
}
elseif(($oculto==3) and !(empty($idoculto)))
{
	echo "<body>";
	$NuevaConexion->eliminaregistro('provedor','idProvedor',"$_POST[idoculto]",'planes','idProvedor');
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
	$id = $_GET['id'];
	$NuevaConexion->leermysql("select * from provedor where idProvedor = '$id'");
	$Cadena_actualizar = mysql_fetch_array($NuevaConexion->arraymysql());
	$mensajeboton = "Actualizar Registro";
	$estado = "Actualizando Registros  de Provedores";
	$oculto = 1;
}
else
{
	$mensajeboton = "Grabar Nuevo Registro";
	$estado = "Registrando Nuevos Provedores";
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
        <td width="718" bgcolor="#990000"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <table width="718" border="0" align="center" cellpadding="3" cellspacing="3">
              <tr>
                <td width="98" height="36"><span class="Estilo1">Nombre(*)</span></td>
                <td width="412"><label>
                  <input name="nombres" type="text" class="Estilocaja" id="nombres" value="<?PHP echo $Cadena_actualizar['Nombres'] ?>" size="45" />
                </label></td>
				
                <td width="169" rowspan="4" valign='bottom'><label>
                    <div align="center" >
                      <input type="submit" name="Submit" value="<?PHP echo $mensajeboton ?>">
                    </div>
                  </label></td>
              </tr>
              <tr>
                <td height="33"><span class="Estilo1">Apellido(*)</span></td>
                <td><label>
                  <input name="apellidos" type="text" class="Estilocaja" id="apellidos" value="<?PHP echo $Cadena_actualizar['Apellidos'] ?>" size="45" />
                </label></td>
              </tr>
              <tr>
                <td height="64" valign="top"><span class="Estilo1">Comentario</span></td>
                <td><label>
                  <textarea name="comentario" cols="45" rows="3" class="Estilocaja" id="comentario"><?PHP echo $Cadena_actualizar['Comentario'] ?></textarea>
                </label>
                  <input name="oculto" type="hidden" id="oculto" value="<?PHP echo $oculto ?>" />
                  <input name="idoculto" type="hidden" id="idoculto" value="<?PHP echo $Cadena_actualizar['idProvedor'] ?>" /></td>
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
	$cadena="select * from provedor order by Nombres";
	$tabla=new ListaDatos($cadena,'xls','');
	$tabla->recuperaLista();
	?>
	</td>
</tr>
</table>

<table width="780" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="155" bgcolor="#990000"><div align="center" class="Estilo1">Nombre</div></td>
    <td width="487" bgcolor="#990000"><div align="center" class="Estilo1">Comentario</div></td>
    <td width="70" bgcolor="#990000"><div align="center" class="Estilo1">Eliminar</div></td>
  </tr><?PHP
  $NuevaConexion->leermysql("select * from provedor order by Nombres");
while($lista = mysql_fetch_array($NuevaConexion->arraymysql()))
{
?>
  <tr>
    <td bgcolor="#FBECC8" valign="top" class="Estilo2">&nbsp;<a href="iframeprovedor.php?id=<? echo $lista['idProvedor']  ?>"><? echo $lista['Nombres']." ".$lista['Apellidos']; ?><img src="imagenes/b_edit.png" alt="Editar" width="16" height="16" border="0" /></a></td>
    <td bgcolor="#FBECC8">
    <div align="left" valign="top" class="Estilo2"><? echo $lista['Comentario']; ?></div>    </td>
    <td bgcolor="#FBECC8">
	<div align="center">
		<a href="javascript:mensaje(<? echo $lista['idProvedor'];?>);"><img src="imagenes/borrar.gif" width="16" height="16" border='0'></a>
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
