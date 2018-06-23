<?php
class ValidaCampo
{
	public function __construct($formulario)
	{
		$this->formulario=$formulario;
	}

	public function validar($tipo,$nombrecampo)
	{	
	$this->tipo=$tipo;
	$this->nombrecampo=$nombrecampo;
		if($this->tipo=='email')
		{
			$Correo="var longitud=document.".$this->formulario.".".$this->nombrecampo.".value.length;";
			$Correo.="var caracter=document.".$this->formulario.".".$this->nombrecampo.".value.indexOf ('@', 0);";
			$Correo.="if(longitud<5 || caracter==-1){";
			$Correo.="alert('Escriba una dirección de correo válida en el campo Dirección de correo');";
			$Correo.="document.".$this->formulario.".".$this->nombrecampo.".value='';";
			$Correo.="}";
			echo $Correo;
		}
		if($this->tipo=='combobox')
		{
			$txt="document.a.submit();";
			$txt.="alert('mirame')";
			echo $txt;
		}
	}
}
?>
<?
$Objeto1=new ValidaCampo('a');
?>
<form name="a">
	<input type="text" name="correo" id="correo" onblur="<? $Objeto1->validar('email','correo');?>"><br>
	<select name="personal" id="personal" onchange="<? $Objeto1->validar('combobox','personal');?>">
		<option value=''>:::::::</option>
		<option value='1'>Case</option>
	</select>
</form>
