<?PHP 
class ComboBoxArray{
public function __construct($nombre,$opciones,$valores,$estilo,$seleccionado,$onchangue,$defecto){
	$this->nombre=$nombre;
	$this->estilo=$estilo;
	$this->seleccionado=$seleccionado;
	$this->onchangue=$onchangue;
	$this->defecto=$defecto;
	$this->arropciones=explode(",",$opciones);
	$this->arrvalores=explode(",",$valores);
	$this->registros=count($this->arropciones);
	if($this->registros<>count($this->arrvalores))
	{
		echo "La cantidad de valores y sus opciones no coinciden";
	}
}
	
public function RescatarComboboxArray(){
	echo '<select onchange="'.$this->onchangue.'" name="'.$this->nombre.'" class="'.$this->estilo.'">';
	$mensaje=($this->defecto=='' ? " :: Seleccionar :: ":$this->defecto);
	echo '<option value="n"  selected="selected">';
	echo $mensaje;
	echo '</option>';
	for($j=0;$j<$this->registros;$j++)
	{
		if($this->seleccionado==$this->arropciones[$j])
		{
		echo '<option value="'
		.$this->arropciones[$j].
		'"  selected="selected">'
		.$this->arrvalores[$j].
		'</option>';
		}
		else
		{
		echo '<option value="'
		.$this->arropciones[$j].
		'">'
		.$this->arrvalores[$j].
		'</option>';
	}
		}
	echo "</select>";
	}
}
?>
<!--form name="a" method="post"-->
<?
//$NuevoCombobox1 = new ComboBoxArray("provedor","0,1,2","casa,patio,azotea","Estilocaja",$_POST['provedor'],"document.a.submit();",'Todos');	
//$NuevoCombobox1->RescatarComboboxArray();
?>
<!--/form-->