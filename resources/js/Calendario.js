/*	Descripcion: Calendario nativo para html
	Version: 2.0
	Autor:  Jose Alejandro Aguilar Puch
	email: alex_puch@hotmail.com
	Fecha: 4-enero-2006
	Nota:  Probado para explorer 5.0 y superior
*/
if( !calendarioList ){
	var calendarioList = new Array();
}

function createCalendario( pstFieldID, pstContinerID, pstImagesDir, pstFormat, pstLanguage ){
	var index = calendarioList.length;
	var cal = new Calendario( index, pstFieldID, pstContinerID, pstImagesDir ,pstFormat, pstLanguage );
	calendarioList[index]=	cal;
	return cal;
}


function Calendario( pstCalendarIndex, pstFieldID, pstContinerID, pstImagesDir ,pstFormat, pstLanguage ){
/*    attributes   */
    this.stFormat           	= pstFormat ? pstFormat.toLowerCase() : "dd-mm-yyyy";
    this.stLanguage         	= pstLanguage ? pstLanguage.toLowerCase() : "spanish";
	this.stImagesDir			= pstImagesDir;
	this.calendarIndex			= pstCalendarIndex;
	this.obField				= document.getElementById(pstFieldID);
	this.gobFechaSelected		= new Fecha( this.stFormat, this.stLanguage );
	this.gobFechaSelected.parseDate( this.obField.value );
	this.gobFechaActual			= this.gobFechaSelected.clone();
	this.gobFechaAux			= this.gobFechaActual.clone();
	this.obContiner				= document.getElementById(pstContinerID);
	this.astDayName				= this.stLanguage == "spanish" ? this.gobFechaSelected.astDaysOfWeek : this.gobFechaSelected.astEngDaysOfWeek; 
    this.stTodayLabel       	= this.stLanguage == "spanish" ? "Hoy" : "Today";
	this.obTopLimitField		= null;
	this.obBottomLimitField		= null;
	this.obTopLimitCalendar		= null;
	this.obBottomLimitCalendar	= null;
	this.oldTopLimit			= "";
	this.oldBottomLimit			= "";
    
/*  methods */
	
	this.changeMonth 	= Calendario_changeMonth;
	this.changeYear 	= Calendario_changeYear;
	this.showCalendar 	= Calendario_showCalendar;
	this.hideCalendar 	= Calendario_hideCalendar;
	this.displayCalendar= Calendario_displayCalendar;
	this.makeSelector	= Calendario_makeSelector;
	this.makeHeader		= Calendario_makeHeader;
	this.makeFooter		= Calendario_makeFooter;
	this.makeBody		= Calendario_makeBody;
	this.cargar			= Calendario_cargar;
	this.getDayStyle	= Calendario_getDayStyle;
	this.setUpperLimit	= Calendario_setUpperLimit;
	this.setLowerLimit	= Calendario_setLowerLimit;
	this.getBottomYear	= Calendario_getBottomYear;
	this.getTopYear		= Calendario_getTopYear;
	this.getBottomMonth	= Calendario_getBottomMonth;
	this.getTopMonth	= Calendario_getTopMonth;
	this.makeSelectMonthOptions	= Calendario_makeSelectMonthOptions;
	this.makeSelectYearOptions	= Calendario_makeSelectYearOptions;
	this.updateCalendar = Calendario_updateCalendar;
	this.cleanField		= Calendario_cleanField;
	this.makeControlBar	= Calendario_makeControlBar;
}

	function Calendario_getBottomYear(){
		inYear = this.gobFechaActual.getYear();
		var bottomYear = 0;
		var fechaAux = new Fecha( this.stFormat, this.stLanguage );
		if( this.obBottomLimitField && fechaAux.parseDate( this.obBottomLimitField.value, this.obBottomLimitCalendar.stFormat )  ){
			bottomYear = fechaAux.getYear();
		}else{
			bottomYear = inYear - 70;
		}
		return bottomYear;
	}
	
	function Calendario_getTopYear(){
		inYear = this.gobFechaActual.getYear();
		var topYear = 0;
		var fechaAux = new Fecha( this.stFormat, this.stLanguage );
		if( this.obTopLimitField && fechaAux.parseDate( this.obTopLimitField.value, this.obTopLimitCalendar.stFormat )  ){
			topYear = fechaAux.getYear();
		}else{
			topYear = inYear + 30;
		}
		return topYear;
	}
	
	function Calendario_getBottomMonth(){
		inYear = this.gobFechaActual.getYear();
		var bottomMonth = 1;
		var fechaAux = new Fecha( this.stFormat, this.stLanguage );
		if( this.obBottomLimitField && fechaAux.parseDate( this.obBottomLimitField.value, this.obBottomLimitCalendar.stFormat )  ){
			if( inYear == this.getBottomYear() ) {
				bottomMonth = fechaAux.getMonth();
			}
		}
		return bottomMonth;
	}
	
	function Calendario_getTopMonth(){
		inYear = this.gobFechaActual.getYear();
		var topMonth = 12;
		var fechaAux = new Fecha( this.stFormat, this.stLanguage );
		if( this.obTopLimitField && fechaAux.parseDate( this.obTopLimitField.value, this.obTopLimitCalendar.stFormat )  ){
			if( inYear == this.getTopYear() ) {
				topMonth = fechaAux.getMonth();
			}
		}
		return topMonth;
	}
	

	function Calendario_setUpperLimit( obCalendar ){
		this.obTopLimitCalendar = obCalendar;
		this.obTopLimitField = obCalendar.obField;
		if( this.obField.value == "" && this.obTopLimitField != null){
			this.gobFechaSelected.parseDate( this.obTopLimitField.value, this.obTopLimitCalendar.stFormat );
			this.gobFechaActual		= this.gobFechaSelected.clone();
			this.gobFechaAux		= this.gobFechaActual.clone();
		}
	}
	
	function Calendario_setLowerLimit( obCalendar ){
		this.obBottomLimitCalendar = obCalendar;
		this.obBottomLimitField = obCalendar.obField;
		if( this.obField.value == "" && this.obBottomLimitField != null){
			this.gobFechaSelected.parseDate( this.obBottomLimitField.value, this.obBottomLimitCalendar.stFormat );
			this.gobFechaActual		= this.gobFechaSelected.clone();
			this.gobFechaAux		= this.gobFechaActual.clone();
		}
	}

	function Calendario_changeYear( pnuYear ){
		this.gobFechaActual.incYear( pnuYear );
		this.gobFechaAux	= this.gobFechaActual.clone();
		this.showCalendar();
	}
	function Calendario_changeMonth( pnuMeses ){
		this.gobFechaActual.incMonth( pnuMeses );
		this.gobFechaAux	= this.gobFechaActual.clone();
		this.showCalendar();
	}
	
	function Calendario_makeSelectMonthOptions(){
		inMonth 	= this.gobFechaActual.getMonth();

		var topMonth = this.getTopMonth();
		var bottomMonth = this.getBottomMonth();
		var arrMonths   = this.stLanguage == "spanish" ? this.gobFechaActual.astMonths : this.gobFechaActual.astEngMonths;

		var stOptions = "";
		for ( var i = topMonth; i >= bottomMonth; i-- ){
			var value = i - this.gobFechaActual.getMonth();
			var caption = arrMonths[i-1].toUpperCase();
			stOptions += "<option value='" + value + "' " + (value == 0 ? "selected" : "") + ">" + caption + "</option>\n"
		}
		return stOptions;
	}
	
	function Calendario_makeSelectYearOptions(){
		var stOptions = "";

		var inYear = this.gobFechaActual.getYear();
		var topYear = this.getTopYear();
		var bottomYear = this.getBottomYear();
		for ( var i = topYear; i >= bottomYear; i-- ){
			var value = i - inYear;
			stOptions += "<option value='" + value + "' " + ( value == 0 ? "selected" : "") + ">" + i + "</option>\n"
			
		}

		return stOptions;
	
	}
	

	function Calendario_makeControlBar(){
		var stControlBar = 	"<TABLE cellspacing='0' width='100%' cellpadding='0' align='center' border='0' ><TR>" +
							"<TD width='100%' class='text'>" + this.obField.value + "</TD>" +
							"<TD width='16' style='padding-left:2pt'>"+
							"</TD>" +
							"<TD width='16' style='padding-left:2pt'>"+
								"<IMG alt='Limpiar' style='cursor:hand;' SRC='" + this.stImagesDir + "borrar.gif' vspace='0' hspace='0' align='right' width=16 height=16 onMouseDown='this.src=\"" + this.stImagesDir + "borrar_pressed.gif\"' onMouseOut='this.src=\""+ this.stImagesDir + "borrar.gif\"' onMouseUp='this.src=\"" + this.stImagesDir + "borrar.gif\";calendarioList["+this.calendarIndex+"].cleanField();'>"+
							"</TD>" +
							"<TD width='16' style='padding-left:2pt'>"+
								"<IMG alt='Cerrar' style='cursor:hand;' SRC='" + this.stImagesDir + "close.gif' width=16 height=16 onMouseDown='this.src=\"" + this.stImagesDir + "close_pressed.gif\"' onMouseOut='this.src=\""+ this.stImagesDir + "close.gif\"' onMouseUp='this.src=\"" + this.stImagesDir + "close.gif\";calendarioList["+this.calendarIndex+"].hideCalendar();'>"+
							"</TD>" +
							"</tr></table>";
		return stControlBar;
	
	}
	
	function Calendario_makeSelector(){
		var inYear = this.gobFechaActual.getYear();
		var inMonth = this.gobFechaActual.getMonth();
		
		var topYear = this.getTopYear();
		var bottomYear = this.getBottomYear();
		
		var topMonth = this.getTopMonth();
		var bottomMonth = this.getBottomMonth();
		
		
		var stHeader = 	"<TABLE cellspacing='0' width='100%' cellpadding='0' align='center' border=0 ><TR>" +
						"<TD width='95' class='header' ALIGN=center><select class='selectOptionsMonth' onchange='calendarioList["+this.calendarIndex+"].changeMonth( eval(this.options[this.selectedIndex].value) );'>" + this.makeSelectMonthOptions() + "</select></TD>" +
						"<TD width='13' class='header'>"+
						"<table cellspacing='0' cellpadding='0' border='0'><tr><td width='13'>";
		if( inYear >= topYear && inMonth >= topMonth ){
			stHeader +=	"<IMG border='0' hspace='0' vspace='0' align='bottom' src='" + this.stImagesDir + "disabled.gif' width='13' height='9'>";			
		}else{
			stHeader +=	"<IMG alt='Incrementar un Mes' style='cursor:hand;' border='0' hspace='0' vspace='0' align='bottom' src='" + this.stImagesDir + "up.gif' width='13' height='9'  onMouseDown='this.src=\"" + this.stImagesDir + "up_pressed.gif\"' onMouseOut='this.src=\""+ this.stImagesDir + "up.gif\"' onMouseUp='this.src=\"" + this.stImagesDir + "up.gif\";calendarioList["+this.calendarIndex+"].changeMonth( 1 );'>";
		}
		
		stHeader +=		"</td></tr><tr><td width='13'>";
		if( inYear <= bottomYear && inMonth <= bottomMonth ){
			stHeader +=	"<IMG border='0' hspace='0' vspace='0' align='bottom' src='" + this.stImagesDir + "disabled.gif' width='13' height='9'>";			
		}else{
			stHeader +=	"<IMG alt='Decrementar un Mes' style='cursor:hand;' border='0' hspace='0' vspace='0' align='top' SRC='" + this.stImagesDir + "down.gif' width='13' height='9' onMouseDown='this.src=\"" + this.stImagesDir + "down_pressed.gif\"' onMouseOut='this.src=\""+ this.stImagesDir + "down.gif\"' onMouseUp='this.src=\"" + this.stImagesDir + "down.gif\";calendarioList["+this.calendarIndex+"].changeMonth( -1 );'>";
		}
		stHeader +=		"</td></tr></TABLE>"+
						"</TD>" +
						"<TD width='10' class='header'>&nbsp;</TD>"+
						"<TD width='25' class='header' ALIGN=center><select class='selectOptionsYear' onchange='calendarioList["+this.calendarIndex+"].changeYear( eval(this.options[this.selectedIndex].value) );'>" + this.makeSelectYearOptions() + "</select></TD>" +
						"<TD width='13' class='header'>"+
						"<table cellspacing='0' cellpadding='0' border='0'><tr><td width='13'>";
		if( topYear > inYear ){
			stHeader +=	"<IMG alt='Incrementar un Año' style='cursor:hand;' border='0' hspace='0' vspace='0' align='bottom' src='" + this.stImagesDir + "up.gif' width='13' height='9'  onMouseDown='this.src=\"" + this.stImagesDir + "up_pressed.gif\"' onMouseOut='this.src=\""+ this.stImagesDir + "up.gif\"' onMouseUp='this.src=\"" + this.stImagesDir + "up.gif\";calendarioList["+this.calendarIndex+"].changeYear( 1 );'>";
		}else{
			stHeader +=	"<IMG border='0' hspace='0' vspace='0' align='bottom' src='" + this.stImagesDir + "disabled.gif' width='13' height='9'>";
		}
		
		stHeader +=		"</td></tr><tr><td width='13'>";
		if( bottomYear < inYear ){
			stHeader +=	"<IMG alt='Decrementar un Año' style='cursor:hand;' border='0' hspace='0' vspace='0' align='top' SRC='" + this.stImagesDir + "down.gif' width='13' height='9' onMouseDown='this.src=\"" + this.stImagesDir + "down_pressed.gif\"' onMouseOut='this.src=\""+ this.stImagesDir + "down.gif\"' onMouseUp='this.src=\"" + this.stImagesDir + "down.gif\";calendarioList["+this.calendarIndex+"].changeYear( -1 );'>";
		}else{
			stHeader +=	"<IMG border='0' hspace='0' vspace='0' align='bottom' src='" + this.stImagesDir + "disabled.gif' width='13' height='9'>";
		}
		stHeader +=		"</td></tr></TABLE>"+
						"</TD></TR></TABLE>";
		return stHeader;
	}
	
	function Calendario_makeHeader(){
		var stHeader		= 		"	<TR>";
		for ( var i=0; i < this.astDayName.length; i++ ){
			var clase = ( i == 0 || i == 6 )  ? 'headerDiaWeekend' : 'headerDia';
			stHeader	+= 		"		<TD class='" + clase + "' ALIGN = center ><font id=id2>" + this.astDayName[i].substring(0,2).toUpperCase() + "</font></TD>";
		}
		stHeader		+= 		"	</TR>";
		return stHeader;
	}
	
	function Calendario_makeFooter(){
		var lobHoy = new Fecha( this.stFormat, this.stLanguage );
		var bottomDate = new Fecha( this.stFormat, this.stLanguage );
		if( this.obBottomLimitField != null ){
			bottomDate.parseDate( this.obBottomLimitField.value, this.obBottomLimitCalendar.stFormat );
		}
		var topDate 	= new Fecha( this.stFormat, this.stLanguage );
		if( this.obTopLimitField != null ){
			topDate.parseDate( this.obTopLimitField.value, this.obTopLimitCalendar.stFormat );
		}
		
		var stFooter	= 	"<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr>";
		stFooter			+= 	"<td align='center' ";
		if( lobHoy.compareTo( bottomDate )!= -1 && lobHoy.compareTo( topDate )!= 1 ){
			stFooter	+= 	"class='footer' ";
			stFooter	+= 	"onmouseup=\"calendarioList["+this.calendarIndex+"].cargar('" + lobHoy.formatDate() + "')\" ";
			stFooter	+= 	"onmouseover=\"this.className='footerOver'\" ";
			stFooter	+= 	"onmouseout=\"this.className='footer'\" ";
		}else{
			stFooter	+= 	"class='footerOutOfRange' ";
		}
		stFooter		+=	">" + this.stTodayLabel + " ( " + lobHoy.formatDate() + " )</td> ";
		stFooter		+=	"</tr></table>";
		return stFooter;
	}
	
	
	function Calendario_makeBody(){
		var stFechas			= "";
		this.gobFechaAux.setDay (1);
		var bottomDate = new Fecha( this.stFormat, this.stLanguage );
		if( this.obBottomLimitField == null || !bottomDate.parseDate( this.obBottomLimitField.value, this.obBottomLimitCalendar.stFormat )  ){
			bottomDate = this.gobFechaAux.clone();
			bottomDate.incMonth( -2 );
		}
			
		var topDate 	= new Fecha( this.stFormat, this.stLanguage );
		if( this.obTopLimitField == null || !topDate.parseDate( this.obTopLimitField.value, this.obTopLimitCalendar.stFormat )  ){
			topDate = this.gobFechaAux.clone();
			topDate.incMonth( 2 );
		}
		
		if ( this.gobFechaAux.getDayOfWeek() != 0 ){
			this.gobFechaAux.incDay( - this.gobFechaAux.getDayOfWeek() )
		}
		var lstAnoMesAux 	= this.gobFechaAux.getYear(4) + this.gobFechaAux.getMonth(2);
		var lstAnoMesAct 	= this.gobFechaActual.getYear(4) + this.gobFechaActual.getMonth(2);
		var lstLinkStyle 	= "";
		var lstCellStyle 	= "";
		
		while ( eval(lstAnoMesAux) <= eval(lstAnoMesAct) ){
			stFechas			+=	"	<TR>";
			for( var i = 0; i < 7; i++ ){
			
				lstCellStyle	= this.getDayStyle();
				if( this.gobFechaAux.compareTo( bottomDate ) != -1 && this.gobFechaAux.compareTo( topDate ) != 1 ){
				
					stFechas			+=	"<td width='14%' class='" + lstCellStyle + "'  align='center' " + 
												" onmouseover=\"this.className='" + lstCellStyle + "Over'\" " +
												" onmouseout=\"this.className='" + lstCellStyle + "'\" " +
												" onmouseup=\"calendarioList["+this.calendarIndex+"].cargar('" + this.gobFechaAux.formatDate() + "') \">" +
												this.gobFechaAux.getDay() +
											"</td>";
				}else{
					stFechas			+=	"<td width='14%' class='" + lstCellStyle + "OutOfRange'  align='center'>" + this.gobFechaAux.getDay() + "</td>";
				}
				this.gobFechaAux.incDay(1);
				var lstAnoMesAux = this.gobFechaAux.getYear(4) + this.gobFechaAux.getMonth(2);
			}
			stFechas			+=	"</TR>";
			lstAnoMesAux = this.gobFechaAux.getYear(4) + this.gobFechaAux.getMonth(2);
		}
		return stFechas;
	}
	
	
	function Calendario_getDayStyle(){
		if( this.gobFechaAux.compareTo( this.gobFechaSelected ) == 0 ){
			return "Selected";
		}
		
		var stStyle = ""
		if( this.gobFechaAux.getMonth( ) != this.gobFechaActual.getMonth( ) ){
			stStyle += "OtroMes";
		}
		if( this.gobFechaAux.getDayOfWeek() == 0 || this.gobFechaAux.getDayOfWeek() == 6 ){
			stStyle += 	"Weekend"
		}else{
			stStyle += 	"Celda"
		}
		return stStyle;
	}
	
	
	function Calendario_showCalendar(){
		this.updateCalendar();
		this.displayCalendar();
	}
	
	function Calendario_updateCalendar(){
		if( this.obBottomLimitField != null ){
			if( this.oldBottomLimit != this.obBottomLimitField.value && this.obField.value == "" ){
				this.oldBottomLimit = this.obBottomLimitField.value;
				this.gobFechaActual.parseDate( this.obBottomLimitField.value, this.obBottomLimitCalendar.stFormat );
				this.gobFechaAux		= this.gobFechaActual.clone();
			}
			var bottomDate = new Fecha( this.stFormat, this.stLanguage );
			if( bottomDate.parseDate( this.obBottomLimitField.value, this.obBottomLimitCalendar.stFormat )  ){
				bottomDate.inDay = 1;
				if( this.gobFechaActual.compareTo( bottomDate ) == -1 ){
					this.gobFechaActual = bottomDate.clone();
				}
			}
		}
		if( this.obTopLimitField != null ){
			if( this.oldTopLimit != this.obTopLimitField.value && this.obField.value == "" ){
				this.oldTopLimit = this.obTopLimitField.value;
				this.gobFechaActual.parseDate( this.obTopLimitField.value, this.obTopLimitCalendar.stFormat );
				this.gobFechaAux		= this.gobFechaActual.clone();
			}
			var topDate 	= new Fecha( this.stFormat, this.stLanguage );
			var fechaActualAux = this.gobFechaActual.clone();
			if( topDate.parseDate( this.obTopLimitField.value, this.obTopLimitCalendar.stFormat )  ){
				topDate.inDay = 1;
				fechaActualAux.inDay = 1;
				if( fechaActualAux.compareTo( topDate ) != -1 ){
					this.gobFechaActual = topDate.clone();
				}
			}
		}
		this.gobFechaAux		= this.gobFechaActual.clone();
		var calStr =	"<TABLE align='center' cellspacing=0>";
		calStr	+= 		"	<TR><TD class='bar' ALIGN=center colspan='7'>";
		calStr	+= 		this.makeControlBar();
		calStr	+= 		"	</TD></TR>";
		calStr	+= 		"	<TR><TD class='header' ALIGN=center colspan='7'>";
		calStr	+= 		this.makeSelector();
		calStr	+= 		"	</TD></TR>";
		calStr	+= 		this.makeHeader();
		calStr	+= 		this.makeBody();
		calStr	+= 		"<TR><TD colspan='7' class='footer'>"
		calStr	+=		this.makeFooter();
		calStr	+= 		"	</TD></TR>";
		calStr			+=	"</TABLE>";
		this.obContiner.innerHTML = calStr;
	}
	
	function Calendario_hideCalendar(){
		this.obContiner.style.display = "none"
		this.obField.style.display = "block"
	}

	function Calendario_displayCalendar(){
		this.obContiner.style.display = "block"
		this.obField.style.display = "none"
	}
	
	function Calendario_cleanField(){
		this.obField.value 	= "";
		this.gobFechaSelected 	= new Fecha( this.stFormat, this.stLanguage );
		this.gobFechaActual		= new Fecha( this.stFormat, this.stLanguage );
		this.gobFechaAux		= new Fecha( this.stFormat, this.stLanguage );
		this.updateCalendar();
		if( this.obTopLimitCalendar	!= null ){
			this.obTopLimitCalendar.updateCalendar();
		}
		if( this.obBottomLimitCalendar	!= null ){
			this.obBottomLimitCalendar.updateCalendar();
		}
	}
	
	function Calendario_cargar ( pstDate ){
		var selectedDate = new Fecha( this.stFormat, this.stLanguage );
		selectedDate.parseDate( pstDate );
		
		var bottomDate = new Fecha( this.stFormat, this.stLanguage );
		if( this.obBottomLimitField == null || !bottomDate.parseDate( this.obBottomLimitField.value, this.obBottomLimitCalendar.stFormat ) ){
			bottomDate = selectedDate.clone();
		}
		var topDate 	= new Fecha( this.stFormat, this.stLanguage );
		if( this.obTopLimitField == null || !topDate.parseDate( this.obTopLimitField.value, this.obTopLimitCalendar.stFormat ) ){
			topDate = selectedDate.clone();
		}
		
		if( selectedDate.compareTo( bottomDate ) >= 0 && selectedDate.compareTo( topDate ) <= 0  ){
			this.obField.value 	= pstDate;
			this.gobFechaSelected.parseDate( pstDate );
			this.gobFechaActual		= this.gobFechaSelected.clone();
			this.gobFechaAux		= this.gobFechaActual.clone();
			this.hideCalendar();
			if( this.obTopLimitCalendar	!= null ){
				this.obTopLimitCalendar.updateCalendar();
			}
			if( this.obBottomLimitCalendar	!= null ){
				this.obBottomLimitCalendar.updateCalendar();
			}
		}else{ 
			alert( "Fecha Fuera De Rango" ) 
			this.showCalendar();
		}
		return false;
	}