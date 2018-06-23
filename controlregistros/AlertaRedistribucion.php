<?
session_start();
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
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style></head>

<body>
<script>
function closed()
{
	window.close();
}
</script>
<?PHP
	function __autoload($class_name) {
		require_once "../clases/".$class_name . '.php';
	}
	
	$NuevaConexion = new BaseDeDatos();
	$NuevaConexion->conectar();
	$NuevaConexion->leermysql("select * from planes where Baja='1' and TipoPlan='Postpago'");
?>
 <p><strong>La siguientes planes requieren ser Redistribuidos por favor Selecione una opcion:</strong></p>
 <form action="iframeredistribucion.php" method="post" name="form1" target="interframe" id="form1" onsubmit="javascript:closed()">
   <label>   </label>
 <?
 	while($my = mysql_fetch_array($NuevaConexion->arraymysql()))
	{
		 
		$fecharedistribucion 	=	strtotime(str_replace("/", "-", $my['FechaRedistribucion']));
		$fechaactual 			= 	strtotime(date("d-m-Y"));
		if($fecharedistribucion<$fechaactual)
		{
 ?>
   
   <table width="248" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
     <tr>
       <td bgcolor="#990000" ><span class="Estilo1">Plan
           <? echo  $my['Nombre'] ?>
       </span></td>
     </tr>
     <tr>
       <td ><table width="244" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">

         <tr>
           <td width="196" height="27" bgcolor="#FBECC8"><label> &nbsp;Redistribuir Bolsa
             y Cargar </label></td>
           <td width="42" bgcolor="#990000"><div align="center">
             <input name="rb<? echo $my['idPlanes'];?>" type="radio" value="1" />
           </div></td>
         </tr>
         <tr>
           <td height="27" bgcolor="#FBECC8">&nbsp;Cargar Mismo Saldo de Bolsa </td>
           <td bgcolor="#990000"><div align="center">
              <input name="rb<? echo $my['idPlanes'];?>" type="radio" value="2" />
           </div></td>
         </tr>
         <tr>
           <td height="27" bgcolor="#FBECC8">&nbsp;Realizar esta tarea mas tarde</td>
           <td bgcolor="#990000"><div align="center">
              <input name="rb<? echo $my['idPlanes'];?>" type="radio" value="3" checked="checked" />
           </div></td>
         </tr>
       </table></td>
     </tr>
   </table>
   <br />
   <? 
   }
   }
   ?>
   <label>
   <div align="center">
     <input type="submit" name="Submit" value="Realizar Tarea" />
   </div>
   </label>
</form>
 <p>&nbsp; </p>
</body>
</html>
