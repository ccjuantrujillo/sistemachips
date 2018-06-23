<?PHP
class ImagenBase{
public function __construct($estado,$identificador)
	{
		$this->estado	=	$estado;
		if($this->estado=="0")
		{
		$this->imagen="imagenes/Libre.JPG";
		}
		elseif($this->estado=="1")
		{
		$NuevaConexion = new BaseDeDatos();
		$NuevaConexion->conectar();
		
		$NuevaConexion->leermysql
		("select * from usuariochip where 	idTipoCliente = '1' and idDatosCliente='$identificador' and Estado='1' and Baja= '1' order by idUsuarioChip desc limit 1"); 
		$ChipArray = mysql_fetch_array($NuevaConexion->arraymysql());
		
		$this->idusuariochip = $ChipArray[idUsuarioChip];
		$identificador_chip = $ChipArray[Chip_idChip];
		$NuevaConexion->leermysql("select * from chip where idChip = '$identificador_chip'");
		$PlanArray = mysql_fetch_array($NuevaConexion->arraymysql());		
		
		$identificador_plan= $PlanArray[idPlanes];	
		$this->numero =	$PlanArray[Numero];
		$NuevaConexion->leermysql("select * from planes where idPlanes = '$identificador_plan'");
		$operadorArray = mysql_fetch_array($NuevaConexion->arraymysql());
		
		$identificador_op= $operadorArray[idOperador];		
		$NuevaConexion->leermysql("select * from operador where idOperador = '$identificador_op'");
		$operadores = mysql_fetch_array($NuevaConexion->arraymysql());
				
		$this->imagen="imagenes/".$operadores[Nombre].".JPG";
		}
		
	}
public function imagen()
	{
		return $this->imagen;
	}
public function numero()
	{
		return $this->numero;
	}
public function idusuario()
	{
		return $this->idusuariochip;
	}			
}
