<?PHP 
include_once("BaseDeDatos.php");
class ListaDatos{
public function __construct($cadena,$formato,$icono){
		$NuevaConexion=new BaseDeDatos();
		$NuevaConexion->conectar();
		$this->formato=$formato;
		$this->cadena=$cadena;
		$this->icono=$icono;
		$NuevaConexion->leermysql($this->cadena);
		$this->ArrayCadena = $NuevaConexion->arraymysql();
}
    
public function RecuperaLista(){
	$filax="";
	$fila="<table width='720' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#990000'>";
	$numero=mysql_num_rows($this->ArrayCadena);
	$numerocampos=mysql_num_fields($this->ArrayCadena);
	$fila.="<tr>";
	for($i=0;$i<$numerocampos;$i++)
	{
		$fila.="<td align='center' bgcolor='#990000'><div align='center' class='Estilo1'>".mysql_field_name($this->ArrayCadena,$i)."</div></td>";		
	}
	if($this->formato=='html')			$fila.="<td align='center' bgcolor='#990000'><div align='center' class='Estilo1'>Editar</div></td>";		
	$fila.="</tr>";
	while($this->lista=mysql_fetch_array($this->ArrayCadena))
	{
		$fila.="<tr>";
		for($i=0;$i<$numerocampos;$i++)
		{
			$filax.=$this->lista[$i]."\t\t\n";
			$fila.="<td align='center' bgcolor='#FBECC8'>".$this->lista[$i]."</td>";
		}
		if($this->formato=='html')		$fila.="<td align='center' bgcolor='#FBECC8'><a href=''><img src='".$this->icono."' width='16' height='16' border='0' /></a></td>";
		$fila."</tr>";
	}
	$fila.="</table>";
	if($this->formato=='html')
	{
		echo $fila;
	}
	elseif($this->formato=='txt')
	{
		echo $filax;
	}
	elseif($this->formato=='xls')
	{
		$numeroaleatorio=$numerorand=rand(1,1000);
		$this->archivo="archivos/excel".$numeroaleatorio.".xls"; //archivo excel creado
		$fp=fopen($this->archivo,"w");
		fwrite($fp,$fila);
		fclose($fp);
		echo "<input type='button' value='Exportar Excel' name='boton' onclick='exportaexcel()'>";
?>
<script>
function exportaexcel()
{
	location.href="<?=$this->archivo;?>";
}
</script>
<?
	}
}	
}
?>
<?
/*$cadena="select 
		b.Nombre as Plan,
		a.Numero as Numero,
		a.Minutos as Minuto
		from chip as a
		left join planes as b on a.idPlanes=b.idPlanes
		";
$tabla=new ListaDatos($cadena,'xls','../controlregistros/imagenes/borrar.gif');
$tabla->recuperaLista();*/
?>