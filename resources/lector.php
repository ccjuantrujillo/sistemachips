
<?php
class ficheros {
	public function __construct($archivo){
		if(file_exists($archivo)){			
			$archivo_nuevo = file($archivo);
			$this->ruta = $archivo;
			$this->archivo_nuevo = $archivo_nuevo;
			$numero_de_filas = $this->numero_filas($this->ruta);
			$this->numero_de_filas = $numero_de_filas;
			}
		else
			{
			echo "La fecha elegida no tiene registros activos";
			exit();	
			}
	}
	
	private function numero_filas($file)	{
	$cuenta = fopen ($file, "r");
	$i =0;
	while (!feof ($cuenta)) {
		$buffer = fgets($cuenta, 4096);
		$i++;
		}
	fclose ($cuenta);
	return $i;
	}
	
	
	public function mostrar_filas(){
	echo $this->numero_de_filas;
	for($i=0;$i<$this->numero_de_filas;$i++){
		echo str_replace(" ", "",$this->archivo_nuevo[$i]);
		//echo $this->archivo_nuevo[$i]; 			
		
	}
}
}
$chenko = new ficheros("090430.cdr");
$chenko->mostrar_filas();

?>
