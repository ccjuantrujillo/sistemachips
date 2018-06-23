<?PHP
class Pagina{	
	public function __construct($total,$porhoja){
		$this->pagina=$_SELF;
		$this->hojas=ceil(($total/$porhoja));
	}
	public function muestraPaginas(){
		for($j=1;$j<=$this->hojas;$j++)
		{
			echo "<a href='".$this->pagina."?pagina=".$j."'><font color='".($_GET[pagina]==$j ? '#990000':'#000000')."'>".$j."</font></a>&nbsp;&nbsp;";
		}
		echo "<a href='".$this->pagina."?pagina=n'><font color='".($_GET[pagina]=='n' ? '#990000':'#000000')."'>Todos</font></a>";
	}
}	
?>
<?
//$paginacion=new Pagina(20,4);
//$paginacion->muestraPaginas();
?>