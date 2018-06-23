	<?PHP 
	class MinutosSegundos{
	public function __construct(){

	}
	public function ConversionTiempo($segundos){
		$minutos=$segundos/60;
		$horas=floor($minutos/60);
		$minutos2=$minutos%60;
		$segundos_2=$segundos%60%60%60;
		if($minutos2<10)
		$minutos2='0'.$minutos2;
		if($segundos_2<10)
		$segundos_2='0'.$segundos_2;
		if($segundos<60)
			{ /* segundos */
				return $resultado= '00:'.round($segundos);
			}
		elseif($segundos>60 && $segundos<3600)
			{/* minutos */
				return $resultado= $minutos2.':'.$segundos_2;
			}
		else
			{/* horas */
				return $resultado= $horas.':'.$minutos2.':'.$segundos_2.' Horas';
			}
		$this->resultado=$resultado;
		
	}

}
		?>