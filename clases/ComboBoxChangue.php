<?PHP 
include_once("BaseDeDatos.php");
class ComboBoxChangue{
	public function __construct($tabla,$where,$valor,$opciones,$estilo,$seleccionado,$onchangue){
		$arropciones=explode(",",$opciones);
		if(count($arropciones)!=1)	
		{
			$opciones1=substr_replace($opciones,",' ',",strrpos($opciones, ","),1);
			$opcion="concat(".$opciones1.")";
		}
		else
		{
			$opcion=$opciones;
		}
		$this->tabla 		= $tabla;		
		$this->valor		= $valor;
		$this->opcion		= $opcion;
		$this->estilo		= $estilo;
		$this->seleccionado	= $seleccionado;
		$this->onchangue 	= $onchangue;
		if($where =="")
		$this->where	= $where;			
		else
		$this->where	= " where ".$where;		
		$NuevaConexion = new BaseDeDatos();
		$NuevaConexion->conectar();
		$NuevaConexion->leermysql("select $this->valor,$this->opcion from ".$this->tabla.$this->where);
		$this->ArrayCadena = $NuevaConexion->arraymysql();
	}
		public function RescatarCombobox(){
	echo '<select onchange="'.$this->onchangue.'" name="'.$this->tabla.'" class="'.$this->estilo.'">';
	echo '<option value="n"  selected="selected"> :: Seleccionar :: </option>\n';
	while($listaopciones = mysql_fetch_array($this->ArrayCadena))
		{
			if($this->seleccionado==$listaopciones[$this->valor])
			{
			echo '<option value="'
			.$listaopciones[$this->valor].
			'"  selected="selected">'
			.$listaopciones['1'].
			'</option>';
			}
			else
			{
			echo '<option value="'
			.$listaopciones[$this->valor].
			'">'
			.$listaopciones['1'].
			'</option>';
			}
		}
	echo "</select>";
	}
}

//$NuevoCombobox1 = new ComboBoxChangue("provedor","","idProvedor","Nombres,Apellidos","Estilocaja",$_GET[idprovedor],"javascript:activar()");	
//$NuevoCombobox1->RescatarCombobox();
?>