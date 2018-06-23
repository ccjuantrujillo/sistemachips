 <?
 ////////////////////////////////////////////////////////////////////////////
//Calculamos el numero de días del intervalo pedido
$fecha1 = $_GET[fecha1];
$fecha2 = $_GET[fecha2];
$hora1 = $_GET[hora1];
$hora2 = $_GET[hora2];		
function dateformato($fecha)
{
	$ano="20".substr($fecha,0,2);
	$mes=substr($fecha,2,2);
	$dia=substr($fecha,4,2);
	$fecha=$ano."-".$mes."-".$dia;
	return $fecha;
}
function dateformato1($fecha,$hora)
{
	$ano=substr($fecha,0,2);
	$mes=substr($fecha,2,2);
	$dia=substr($fecha,4,2);
	$arrhora=explode(":",$hora);
	$hora=$arrhora[0];
	$minuto=$arrhora[1];
	$fecha=$dia."/".$mes."/".$ano." ".$hora.":".$minuto;
	return $fecha;
}
function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0)
{
    $date_r = getdate(strtotime($date)); 
    $date_result = date("Y-m-d", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
    return $date_result;
}
function fx($fecha)
{
	$nombre=array("En","Feb","Mar","Abr","May","Jun","Jul","Agos","Set","Oct","Nov","Dic");
	$array=explode("-",$fecha);
	$numeromes=$array['1']-1;
	$mes=$nombre[$numeromes];
	$f=$array['2']."-".$mes;
	return $f;
}
function fx1($fecha)
{
	$arrayfecha=explode("-",$fecha);
	$ano=substr($arrayfecha['0'],2,2);
	$mes=$arrayfecha['1'];
	$dia=$arrayfecha['2'];
	$fechax=$ano."".$mes."".$dia;
	return $fechax;
}
function fx2($fecha)
{
	$arrfecha=explode("/",$fecha);
	
}
?>