<?
session_start();
//Esto lo unico que hace es borrar el cookie
setcookie("usPass","x",time()-3600); 
setcookie("usNick","x",time()-3600); 
setcookie ("usPass");
session_unset();
$txt1="<script>";
$txt1.="window.opener.llenarnumero();";
$txt1.="window.close()";
$txt1.="</script>";
echo $txt1;
?>
<!--style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.Estilo3 {	font-size: 18px;
	font-weight: bold;
}
-->
<!--/style><center>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="393" height="181" border="6" align="center" cellpadding="3" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td width="375" height="157"><div align="center" class="Estilo3">Su sesion se ha cerrado correctamente</div></td>
  </tr>
</table>
<p>&nbsp;</p>
</center-->
