<!--
C�digo de un men� desplegable. Cada bot�n principal llama a la funci�n Menu con sus respectivos par�metros y cambia la clase de su DIV correspondiente a NOMBREVisible o NOMBREOculto. �stos manejan a su vez la separaci�n con el men� superior.
�stos datos deben ser modificados en relaci�n a la cantidad de items que tenga cada men�.
-->
<html>
<style type="text/css">
<!--
.Estilo1 {color: #1A4D81}
.Estilo2 {color: #990000}
.Estilo3 {color: #2C5F93}
-->
</style>
<body>
<script language="JavaScript">

function AbrirCentrado(Url,NombreVentana,width,height,extras) {
var largo = width;
var altura = height;
var adicionales= extras;
var top = (screen.height-altura)/2;
var izquierda = (screen.width-largo)/2; nuevaVentana=window.open(''+ Url + '',''+ NombreVentana + '','width=' + largo + ',height=' + altura + ',top=' + top + ',left=' + izquierda + ',features=' + adicionales + '');
nuevaVentana.focus();
}

</script>
<form>
<p align="center"><input type="button"
value=" PULSE AQU� "
onclick="alert(' �No estar�a bien uno de estos en su p�gina? Diga aqu� lo que quiera ')"></p>
</form> 

<a href="JavaScript:alert(' �No estar�a bien uno de estos en su p�gina? Diga aqu� lo que quiera ')">C�digo</a> a incluir en e<span class="Estilo3">l cuer</span>po (entre <body> 
<span class="Estilo2">y</span> <span class="Estilo1">ss 
</span><a href="090502.cdr" target="_blank">fff
</a>
</body>


<input type="button" value="Abrir ventana" onClick="javascript:AbrirCentrado('pagina.html','Pagina','720','500','fullscreen=1,scrollbars=NO');"> 

</body>
</html>