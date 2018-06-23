<?PHP 
include "ComboBoxArray.php";
class ComboHora{
public function __construct(){
	$this->arropciones1="01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23";		
	$this->arrvalores1="01,02,03,04,05,06,07,08,09,10,11,12,1,2,3,4,5,6,7,8,9,10,11";	
	$this->arropciones2="00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59";		
	$this->arrvalores2="00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59";	
}

public function recuperaHora($hora,$minuto){
	$NuevoCombobox1 = new ComboBoxArray("hora",$this->arropciones1,$this->arrvalores1,"Estilocaja",$_POST['hora'],"document.a.submit();",'Todos');	
	$NuevoCombobox1->RescatarComboboxArray();
	$NuevoCombobox2 = new ComboBoxArray("minuto",$this->arropciones2,$this->arrvalores2,"Estilocaja",$_POST['minuto'],"document.a.submit();",'Todos');	
	$NuevoCombobox2->RescatarComboboxArray();	
}
}
?>
<?
$fecha=new ComboHora();
$fecha->recuperaHora(20,40);
?>