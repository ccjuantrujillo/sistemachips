<?
session_start();
function __autoload($class_name) {
    require_once "../clases/".$class_name . '.php';
}
$NuevaConexion = new BaseDeDatos();
$NuevaConexion->conectar();
$NuevaConexion2 = new BaseDeDatos();
$NuevaConexion2->conectar();
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
}
.Estilo1 {color: #FFFFFF}
-->
</style></head>
<script type="text/javascript" src="resources/js/Fecha.js" ></script>
<script type="text/javascript" src="resources/js/Calendario.js" ></script>
<link rel="STYLESHEET" type="text/css" href="resources/css/calendario.css"></link>
<body>
<table width="690" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="625" height="35">
	<form id="form1" name="form1" method="get" action="">
      <table width="690" border="0" align="center" cellpadding="3" cellspacing="2">

        <tr>
          <td colspan="5" bgcolor="#990000"><div align="center"><span class="Estilo2 Estilo1"><strong>Inventario  de Chips </strong></span></div></td>
          </tr>
		<tr>
		  <td width="144" bgcolor="#FBECC8"><strong>Operador : </strong></td>
		  <td width="145" bgcolor="#FBECC8">

		  <?PHP 
			  $NuevoCombobox1 = new ComboBoxChangue("operador","","idOperador","Nombre","Estilocaja",$_GET[operador],"");	
			  $NuevoCombobox1->RescatarCombobox();
		  ?>		    </td>
		  <td width="24" bgcolor="#FBECC8">&nbsp;</td>
		  <td width="165" bgcolor="#FBECC8"><strong>Provedor:</strong></td>
		  <td width="168" bgcolor="#FBECC8">
		  <?PHP 
			  $NuevoCombobox1 = new ComboBoxChangueValor("provedor","","idProvedor","Nombres,Apellidos","Estilocaja",$_GET[provedor],""," :: TODOS :: ");	
			  $NuevoCombobox1->RescatarCombobox();
		  ?>	  
		  </td>
		  </tr>
        <tr>
          <td bgcolor="#FBECC8">&nbsp;</td>
          <td colspan="3" bgcolor="#FBECC8"><label>
            </label></td>
          <td bgcolor="#FBECC8"><div align="center">
            <input type="button" name="Submit" value="Visualizar resultado" onclick="validar();" />
          </div></td>
        </tr>
      </table>
      </form>
    </td>
  </tr>
</table>
<p align="center">
<? 
if(!(empty($_GET[operador])) and !(empty($_GET[provedor])))
{
	include("kardexinventario.php");
}
?>
</p>
</body>
</html>
<script>
function validar()
{
	if(document.form1.operador.value=='n')
	{
		alert("Debe ingresar el nombre del operador");
	}
	else
	{
		document.form1.submit();
	}
}
</script>
