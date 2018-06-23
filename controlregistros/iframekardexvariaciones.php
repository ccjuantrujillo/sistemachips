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
-->
</style></head>
<script type="text/javascript" src="resources/js/Fecha.js" ></script>
<script type="text/javascript" src="resources/js/Calendario.js" ></script>
<link rel="STYLESHEET" type="text/css" href="resources/css/calendario.css"></link>
<body>
<table width="690" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#990000">
  <tr>
    <td width="625" height="35"><form id="form1" name="form1" method="get" action="">
      <table width="690" border="0" align="center" cellpadding="3" cellspacing="2">

        <tr>
          <td colspan="5" bgcolor="#990000"><div align="center"><span class="Estilo2"><strong>Comparativo de consumo de bases</strong></span></div></td>
          </tr>
		<tr>
          <td width="144" bgcolor="#FBECC8"><strong>Fecha de inicio: </strong></td>
          <td width="145" bgcolor="#FBECC8"><span style="display:inline;width:100;">
          <input readonly='true' type='Text' id="idfecha1" name="fecha1" value="<? echo $_GET[fecha1] ?>" size="10" onFocus='idfecha1Calendar.showCalendar();'>
            </span>
           <div id="idfecha1CalendarContiner" style='display:none;' class='calendario' ></div>
          <script> 
		idfecha1Calendar = createCalendario( "idfecha1", "idfecha1CalendarContiner", "resources/img/", "yyMMdd", "spanish" );
         </script>		 </td>
          <td width="24" bgcolor="#FBECC8">&nbsp;</td>
          <td width="165" bgcolor="#FBECC8"><strong>Fecha de Fin: </strong></td>
          <td width="168" bgcolor="#FBECC8">
		  <span style="display:inline;width:100;">
          <input readonly='true' type='Text' id="idfecha2" name="fecha2" value="<? echo $_GET[fecha2] ?>" size="10" onFocus='idfecha2Calendar.showCalendar();'>
            </span>
           <div id="idfecha2CalendarContiner" style='display:none;' class='calendario' ></div>
          <script> 
		idfecha2Calendar = createCalendario( "idfecha2", "idfecha2CalendarContiner", "resources/img/", "yyMMdd", "spanish" );
         </script>		<input name="oculto" type="hidden" id="oculto" value="valor" /></td>
        </tr>


        <tr>
          <td bgcolor="#FBECC8">&nbsp;</td>
          <td colspan="3" bgcolor="#FBECC8"><label>
            <div align="center">
              <input type="submit" name="Submit" value="Calcular Llamadas Realizadas" />
              </div>
          </label></td>
          <td bgcolor="#FBECC8">&nbsp;</td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
<p align="center">
<? 
if(!(empty($_GET[oculto])))
{
if(!(empty($_GET[fecha1])) and !(empty($_GET[fecha2])))
	{
		$fecha1 = $_GET[fecha1];
		$fecha2 = $_GET[fecha2];
		$hora1 = $_GET[ihora].":".$_GET[iminuto].":00";
		$hora2 = $_GET[fhora].":".$_GET[fminuto].":00";
		$FechaTime1 = strtotime($fecha1);
		$FechaTime2 = strtotime($fecha2);
		
		/*echo $fecha1;
		echo "<br>";
		echo $fecha2;
		echo "<br>";
		echo $hora1;
		echo "<br>";
		echo $hora2;*/
		//if($FechaTime1<$FechaTime2){
			//("090503.cdr","18:00:00","090503.cdr","18:54:00")
			include("kardexvariacionescontrolador.php");
		//}
		/*else
		{
			echo "La fecha Final no puede ser menor que la inicial";
		}*/
	}
	else
	{
	echo "Error, Por favor ingrese Los datos en todos los campos";
	}	
}	
?></p>
</body>
</html>
