<?php
session_start();
if(!$loginCorrecto)		header('Location:../index.php');
$administrador=$_SESSION['Administrador'];
$titulo=$_SESSION['titulo'];
if($loginCorrecto)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$titulo;?></title>
<link rel="stylesheet" href="menu/menu.css">

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
	FONT-SIZE: 10pt;
	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; 
}
-->
</style></head>
<script>
function menu(){}
</script>
<body onload="window.opener.borracampos();">
<table width="992" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#ff0000">
  <tr>
    <td width="988" height="21" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="40" bgcolor="#ff0000">
		<table width="973" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="108"><span class="Estilo1">Bienvenido:</span></td>
          <td width="214"><span class="Estilo1" ><?=$administrador;?></span></td>
          <td width="368" class="Estilo1">Quintum ::: Antiguo</td>
          <td width="257"><div align="center"><span class="Estilo1">Desarrollo Preferencial para Firefox: </span></div></td>
          <td width="26"><div align="center"><span class="Estilo1"><img src="imagenes/firefox2.gif" alt="Firefox" width="26" height="26" align="absmiddle" /></span></div></td>
        </tr>
      </table></td>
  </tr>
  <tr >
    <td height="216"><iframe src="iframeindex.php"
      width="988" height="550" scrolling="auto" frameborder="1" transparency name="interframe">
    <p>Texto alternativo para navegadores que no aceptan iframes.</p>
    </iframe></td>
  </tr>
  <tr>
    <td height="21" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
<!-- comments end -->

<!-- menu script itself. you should not modify this file -->
<script language="JavaScript" src="menu/menu.js"></script>
<? 
include "menu/menu_items.php";
$txt1="<script>var MENU_ITEMS=".$fila."</script>";
echo $txt1;
?>
<script language="JavaScript" src="menu/menu_tpl.js"></script>

<script language="JavaScript">
	<!--//
	// Make sure the menu initialization is right above the closing </body> tag
	// Moving it inside other tags will not affect the position of the menu on
	// the page. If you need this feature please consider Tigra Menu GOLD.

	// each menu gets two parameters (see demo files)
	// 1. items structure
	// 2. geometry structure

	new menu (MENU_ITEMS, MENU_TPL);

	// If you don't see the menu then check JavaScript console of the browser for the error messages
	// "Variable is not defined" error indicates that there's syntax error in that variable's definition
	// or the file with that variable isn't properly linked to the HTML document
	//-->
</script>
</body>
</html>
<?
}
?>
<script>
function imprimir()
{
	window.print();
}
function salir()
{
	location.href='../salir.php';
}
</script>
