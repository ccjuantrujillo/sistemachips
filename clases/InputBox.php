<?PHP 
include_once("BaseDeDatos.php");
class InputBox{
	public function __construct($tabla,$valor,$estilo,$evento,$accion,$atributos){
		$this->tabla 		= $tabla;		
		$this->valor		= $valor;
		$this->estilo		= $estilo;	
		$this->evento		= $evento;	
		$this->accion		= $accion;	
		$this->atributos	= $atributos;	
		$NuevaConexion = new BaseDeDatos();
		$NuevaConexion->conectar();
		$NuevaConexion->leermysql("select $this->valor,$this->opcion from ".$this->tabla.$this->where);
		$this->ArrayCadena = $NuevaConexion->arraymysql();
	}
	public function RescatarInputbox(){
		echo "<input type='text' name='".$this->tabla."' id='".$this->tabla."' class='".$this->estilo."' value='".$this->valor."' ".$this->evento."='".$this->accion."' ".$this->atributos.">";
	}
}

//$NuevoCombobox1 = new InputBox("cliente","Hernan","Estilocaja","onFocus","enviar();",'');	
//$NuevoCombobox1 ->RescatarInputbox();
?>