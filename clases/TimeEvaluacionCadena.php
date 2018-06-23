<?PHP 
class TimeEvaluacionCadena{
public function __construct($cadena){
$CadenaArray = explode(",",$cadena);
$CadenaHora = substr($CadenaArray[4],8,6);
$this->CadenaHora = $CadenaHora;
}
public function mostrar(){
return strtotime($this->CadenaHora);
}
}

?>