<?PHP 
include_once("BaseDeDatos.php");
class Chips{
public function __construct($idPlan,$formato){
		$this->idPlan=$idPlan;
		$this->formato=$formato;
		$NuevaConexion=new BaseDeDatos();
		$NuevaConexion->conectar();
		$NuevaConexion->leermysql("select * from chip where idPlanes='$this->idPlan' and baja='1' and (estado='1' or estado='2' or estado='0')");
		$this->ArrayCadena = $NuevaConexion->arraymysql();
}
    
public function recuperaChips(){
if($this->formato=='html'){
	$fila="<table border='1' cellpadding='2' cellspacing='2' width='200'>";
	while($this->lista=mysql_fetch_array($this->ArrayCadena))
	{
		$fila.="<tr>";
		$fila.="<td align='center'>".$this->lista['Numero']."</td>";
		$fila.="<td align='right'>".$this->lista['Minutos']."</td>";
		$fila."</tr>";
	}
	$fila.="</table>";
}
elseif($this->formato=='text'){
	$fila="";
	$nRegistros=mysql_num_rows($this->ArrayCadena);
	if($nRegistros!='0')
	{
		while($this->lista=mysql_fetch_array($this->ArrayCadena))
		{
			$fila.=$this->lista['Numero']."\r\t";
		}
	}
	else
	{
		$fila="No existen chips";
	}
}
return $fila;
}	
}
?>
<?
//$tabla=new Chips('5','text');
//$tabla->recuperaChips();
?>
