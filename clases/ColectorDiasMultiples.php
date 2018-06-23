<?PHP
class ColectorDiasMultiples{
	//private $this->mes;	 
	/**
	*El formato de ingreso de Fecha tiene que ser:
	*	dd/mm/aaaa
	**/
	public function __construct($fechainicio,$fechafin){		
		
		$this->diainicio	=	substr($fechainicio,0,2);
		$this->mesinicio	=	substr($fechainicio,3,2);
		$this->anioinicio	=	substr($fechainicio,6,4);
		
		$this->diafin		=	substr($fechafin,0,2);
		$this->mesfin		=	substr($fechafin,3,2);
		$this->aniofin		=	substr($fechafin,6,4);
		
		$this->CalculoDeFechas();
	}
	//formato aaaa
	private function FormatoCadenas($cadena){
	if(1==strlen($cadena))return "0".$cadena;
	elseif(2==strlen($cadena))return $cadena;
	}
	private function NombreMes($nombre){
	if($nombre==1)return "Enero";
	elseif($nombre==2)return "Febrero";
	elseif($nombre==3)return "Marzo";
	elseif($nombre==4)return "Abril";
	elseif($nombre==5)return "Mayo";
	elseif($nombre==6)return "Junio";
	elseif($nombre==7)return "Julio";
	elseif($nombre==8)return "Agosto";
	elseif($nombre==9)return "Septiembre";
	elseif($nombre==10)return "Octubre";
	elseif($nombre==11)return "Noviembre";
	elseif($nombre==12)return "Diciembre";
	}
	private function Dias_mes($anio){
	//asignacion de la cantidad de dias por mes
	$this->mes[1] 		=	31;
	//exepcion en febrero segun el calendario gregoriano la regla es
	//Un año es bisiesto si es divisible por 4, excepto el último de cada siglo 
	//(aquel divisible por 100), salvo que éste último sea divisible por 400.
	if($anio%4==0 or $anio%100==0)
	{
		$this->mes[2] 	=	29;
	}
	else
	{
		$this->mes[2] 	=	28;
	}	
	$this->mes[3] 		=	31;
	$this->mes[4]  		=	30;
	$this->mes[5] 		=	31;
	$this->mes[6] 		=	30;
	$this->mes[7]  		=	31;
	$this->mes[8] 		=	31;
	$this->mes[9] 		=	30;
	$this->mes[10] 		=	31;
	$this->mes[11] 		=	30;
	$this->mes[12] 		=	31;
	
	}
	//Est calculo nos ayudara a obtener el numero de dia usando
	//arrays anidados y la matris mes[]
	private function CalculoDeFechas(){	
	$this->MyArrayFechas = array();
	if($this->aniofin>$this->anioinicio)
		{
			$this->Dias_mes($this->anioinicio);
			for($i=$this->mesinicio;$i<=12;$i++)
			{
				$i = (int)$i;				
				//echo $this->NombreMes($i);
				if($primermes==1)						
				{
					for($j=1;$j<=$this->mes[$i];$j++)
						{//formato 090503
					$this->MyArrayFechas[] = substr($this->anioinicio,2,2).$this->FormatoCadenas($i).$this->FormatoCadenas($j);				
						}
				}
				else
				{
					for($j=$this->diainicio;$j<=$this->mes[$i];$j++)
						{
					$this->MyArrayFechas[] = substr($this->anioinicio,2,2).$this->FormatoCadenas($i).$this->FormatoCadenas($j);
							$primermes=1;
						}
				}
				
			}	
			if($i==13)
			{
			//
			$this->Dias_mes($this->aniofin);
			for($k=1;$k<=$this->mesfin;$k++)
				{
					$k = (int)$k;				
					//echo $this->NombreMes($k);
					if($k<$this->mesfin)
					{											
					for($l=1;$l<=$this->mes[$k];$l++)
						{//formato 090503
					$this->MyArrayFechas[] = substr($this->aniofin,2,2).$this->FormatoCadenas($k).$this->FormatoCadenas($l);				
						}
					}
					else
					{
					for($l=1;$l<=$this->diafin;$l++)
						{
					$this->MyArrayFechas[] =  substr($this->aniofin,2,2).$this->FormatoCadenas($k).$this->FormatoCadenas($l);
						}
					}
				}
			//
			}
		}
		elseif($this->aniofin==$this->anioinicio and $this->mesinicio<>$this->mesfin)
		{
			$this->Dias_mes($this->anioinicio);
			for($m=$this->mesinicio;$m<=$this->mesfin;$m++)
				{
					$m = (int)$m;				
					//echo $this->NombreMes($m);
					//Manipulamos la cadena para que solo muestre los dias requerido del mes incial
					if($m==$this->mesinicio)
					{
					for($l=$this->diainicio;$l<=$this->mes[$m];$l++)
						{
					$this->MyArrayFechas[] =  substr($this->anioinicio,2,2).$this->FormatoCadenas($m).$this->FormatoCadenas($l);				
						}
					}
					//Manipulamos la cadena para que solo muestre los dias requerido del mes final
					elseif($m==$this->mesfin)
					{
					for($l=1;$l<=$this->diafin;$l++)
						{
					$this->MyArrayFechas[] =  substr($this->anioinicio,2,2).$this->FormatoCadenas($m).$this->FormatoCadenas($l);					
						}
					}
					//Manipulamos la cadena para que muestre los dias completos de los demas meses
					else
					{											
					for($l=1;$l<=$this->mes[$m];$l++)
						{
					$this->MyArrayFechas[] =  substr($this->anioinicio,2,2).$this->FormatoCadenas($m).$this->FormatoCadenas($l);					
						}
					}
				}
			}		
			elseif($this->aniofin == $this->anioinicio and $this->mesinicio == $this->mesfin)	
			{
					$this->Dias_mes($this->anioinicio);
					$m=$this->mesinicio;
					$m = (int)$m;				
					//echo $this->NombreMes($m);
					//Manipulamos la cadena para que solo muestre los dias requerido del mes incial
					for($l=$this->diainicio;$l<=$this->diafin;$l++)
						{
					$this->MyArrayFechas[] =  substr($this->anioinicio,2,2).$this->FormatoCadenas($m).$this->FormatoCadenas($l);				
						}
			}
		}

	public function RescatarArray(){
		return $this->MyArrayFechas;
	}
	public function RescatarCantidad(){
		return count($this->MyArrayFechas);
	}
}

//Esta clase maneja la informacion asi:
//$newFechas = new ColectorDiasMultiples("02/05/2009","04/05/2009");
//echo $r = var_dump($newFechas->RescatarArray());  //<-- Nos devuelve un array con todas las fechas var_dump
//echo $newFechas->RescatarCantidad();// <-- Nos devuelve la cantidad de objetos que tiene el array
// Este objeto soporta solo hasta  730 dias Probados

?>