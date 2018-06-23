<?PHP
class CausaDesconexion{
public function __construct($valor){
	$this->valor=$valor;
}
public function MostrarMensaje(){
	if($this->valor==16)
	{
		return "llamada cancelada por el usuario";
	}
	elseif($this->valor==34)
	{
		return "Canal no encontrado";
	}
	else
	{
		return "Llamada concretada";
	}
}
}
?>