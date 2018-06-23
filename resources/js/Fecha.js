/*	Descripcion: Pseudoclase para el manejo de fechas
	Version: 2.0
	Autor:  Jose Alejandro Aguilar Puch
	email: alex_puch@hotmail.com
	Fecha: 4-enero-2006
	Nota:  Probado para explorer 5.0 y superior
*/

	function Fecha( pstFormat, pstLanguage ){
//															Atributos
		this.inMonth			= 0;
		this.inDay				= 0;
		this.inYear				= 0;
		this.stLanguage			= pstLanguage ? pstLanguage.toLowerCase() : "spanish";
		this.stFormat			= pstFormat ? pstFormat.toLowerCase() : "dd-mm-yyyy";
		this.astMonths			= ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
		this.astEngMonths		= ["january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december"];
		this.ainMaxDaysOfMonth  = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
		this.astDaysOfWeek		= ["domingo", "lunes", "martes", "miercoles", "jueves", "viernes", "sabado"];
		this.astEngDaysOfWeek	= ["sunday", "monday", "tuesday", "wenesday", "thursday", "friday", "saturday"];
		this.SUNDAY				= 0;
		this.MONDAY				= 1;
		this.TUESDAY			= 2;
		this.WENESDAY			= 3;
		this.THURSDAY			= 4;
		this.FRIDAY				= 5;
		this.SATURDAY			= 6;
		this.DOMINGO			= 0;
		this.LUNES				= 1;
		this.MARTES				= 2;
		this.MIERCOLES			= 3;
		this.JUEVES				= 4;
		this.VIERNES			= 5;
		this.SABADO				= 6;

//															Metodos
		this.setFormat				= Fecha_setFormat;
		this.getFormat				= Fecha_getFormat;
		this.setLanguage			= Fecha_setLanguage;
		this.getLanguage			= Fecha_getLanguage;
		this.setYear				= Fecha_setYear;
		this.getYear				= Fecha_getYear;
		this.setMonth				= Fecha_setMonth;
		this.getMonth				= Fecha_getMonth;
		this.getMonthName			= Fecha_getMonthName;
		this.getShortMonthName		= Fecha_getShortMonthName;
		this.setDay					= Fecha_setDay;
		this.getDay					= Fecha_getDay;
		this.getDayOfWeek			= Fecha_getDayOfWeek;
		this.getDayOfWeekName		= Fecha_getDayOfWeekName;
		this.getShortDayOfWeekName	= Fecha_getShortDayOfWeekName;
		this.isLeapYear				= Fecha_isLeapYear;
		this.toString				= Fecha_toString;
		this.clone					= Fecha_clone;
		this.parseDate				= Fecha_parseDate;
		this.setDate				= Fecha_setDate;
		this.formatDate				= Fecha_formatDate;
		this.incYear				= Fecha_incYear;
		this.incMonth				= Fecha_incMonth;
		this.incDay					= Fecha_incDay;
		this.compareTo				= Fecha_compareTo;
//															Constructor
		var obHoy				= new Date();
		this.setYear( obHoy.getFullYear() );
		this.setMonth( obHoy.getMonth() + 1 );
		this.setDay( obHoy.getDate() );			
		
	}

	
	function Fecha_setFormat( stFormat ){
		if( !/\S/.test( stFormat ) ){
			return false;
		}
		this.stFormat = stFormat.toLowerCase();
		return true;
	}
	
	function Fecha_getFormat(){
		return this.stFormat;
	}
	
	function Fecha_setLanguage( stLanguage ){
		if( !/\S/.test( stLanguage ) ){
			stLanguage = stLanguage.toLowerCase()
			if ( stLanguage == "spanish" || stLanguage == "english" ){
				this.stLanguage = stLanguage;
				return true;
			}
		}
		return false;
	}
	
	function Fecha_getLanguage( stLanguage ){
		return this.stLanguage;
	}
	
	
	function Fecha_getDayOfWeek(){
		var obTempDate	= new Date( this.getYear(), this.getMonth() - 1, this.getDay() )
		return obTempDate.getDay();
	}
	
	function Fecha_getDayOfWeekName(){
		if ( this.stLanguage == "spanish" ){
			return this.astDaysOfWeek[ this.getDayOfWeek() ];
		}else{
			return this.astEngDaysOfWeek[ this.getDayOfWeek() ];
		}
	}
	
	function Fecha_getShortDayOfWeekName(){
		this.getDayOfWeekName().substring(0,3)
	}
/*
 	funcion que compara dos objetos del tipo Fecha
 		int Fecha :: compareTo( Fecha obFechaComp ) 
 	Parametros:
 		obFechaComp	fecha para comparar
 	Retorna
 		1 	si el parametro es menor
 		-1	si el parametro es mayor
 		0	en caso de ser iguales
 */
	function Fecha_compareTo( obFechaComp ){
		var inSelf		= eval ( this.getYear(4) + this.getMonth(2) + this.getDay(2) );
		var inDate		= eval ( obFechaComp.getYear(4) + obFechaComp.getMonth(2) + obFechaComp.getDay(2) );
        var value       = inSelf - inDate;
        var dividendo   = value == 0 ? 1 : Math.abs( value );
		return value / dividendo;
	}
	
	/*
	 	Funcion que parsea la cadena fecha que tiene el formato de fecha
	 */
	function Fecha_parseDate( pstDate, pstFormat ){
		if( !pstDate ){
			return false;
		}
		
		pstFormat 		= pstFormat ? pstFormat.toLowerCase() :this.getFormat();
		pstDate   		= ( "" + pstDate ).toLowerCase();
		var yearIndex 	= -1;
		var monthIndex	= -1;
		var dayIndex	= -1;
		
		var stYear		= "none";
		var stMonth		= "none";
		var stDay		= "none";
        
        
		if( pstFormat.indexOf( "mmm" ) != -1 ){
			for ( var i = 0; i < 12; i++ ){
				if( pstDate.indexOf( this.astMonths[i].substring(0,3) ) != -1 || 
					pstDate.indexOf( this.astEngMonths[i].substring(0,3) ) != -1 ){
					stMonth = i + 1;
					break;
				}
			}
		}else if( ( monthIndex = pstFormat.indexOf( "mm" ) ) != -1 ){
			stMonth = pstDate.substring( monthIndex, monthIndex + 2 );
		}else if( pstFormat.indexOf( "mes" ) != -1 ){
			for ( var i = 0; i < 12; i++ ){
				if( pstDate.indexOf( this.astMonths[i] ) != -1 || 
					pstDate.indexOf( this.astEngMonths[i] ) != -1 ){
                    pstDate = pstDate.replace( this.astMonths[i], "mes" )
                    pstDate = pstDate.replace( this.astEngMonths[i], "mes" )
					stMonth = i + 1;
					break;
				}
			}
		}
		if( /\D/.test( stMonth ) ){
			return false;
		}
        
        
        
		if( ( yearIndex = pstFormat.indexOf( "yyyy" ) ) != -1 ){
			stYear = pstDate.substring( yearIndex, yearIndex + 4 );
		}else if( (yearIndex = pstFormat.indexOf( "yy" )) != -1 ){
			stYear = pstDate.substring( yearIndex, yearIndex + 2 );
		}
		if( /\D/.test( stYear ) ){
			return false;
		}

        
        
		dayIndex = pstFormat.indexOf( "dd" );
		if( dayIndex != -1 ){
			pstFormat = pstFormat.replace( /d/g, ""  );
			stDay = pstDate.substring( dayIndex, dayIndex + 2 );
		}
        
		if( /\D/.test( stDay ) ){
			return false;
		}
		

		
		if( stYear == "none" || stMonth == "none" || stDay == "none" ){
			return false;
		}
		var tempFecha = new Fecha();
		if( !tempFecha.setDate( stDay, stMonth, stYear ) ){
			return false;
		}
        this.setDate( stDay, stMonth, stYear );
		return true;
	}

	
	function Fecha_setMonth( pinMonth ){
		if( /\D/.test( "" + pinMonth ) ){
			return false;
		}
		pinMonth = eval( pinMonth );
		if ( pinMonth < 1 || pinMonth > 12 ){
			return false;
		}
		this.inMonth = pinMonth;
		if( this.inDay > this.ainMaxDaysOfMonth[ pinMonth - 1 ] ){
			this.inDay = this.ainMaxDaysOfMonth[ pinMonth - 1 ];
		}
		return true;
	}
	

	function Fecha_getMonth(  pinNumberOfDigits ){
		if( pinNumberOfDigits ){
			stMonth = "" + this.inMonth;
			while( stMonth.length < pinNumberOfDigits ){
				stMonth = "0" + stMonth;
			}
			return stMonth.substring( stMonth.length - pinNumberOfDigits, stMonth.length )
		}
		return this.inMonth;
	}
	
	function Fecha_getMonthName(){
		if ( this.stLanguage == "spanish" ){
			return this.astMonths[this.inMonth - 1];
		}
		else{
			return this.astEngMonths[ this.inMonth - 1 ];
		}
	}
	
	function Fecha_getShortMonthName(){
		return this.getMonthName().substring(0,3);
	}
	

	
	
	function Fecha_setDay( pinDay ){
		if( /\D/.test( "" + pinDay ) ){
			return false;
		}
		pinDay = eval( pinDay );
		if ( pinDay < 1 || pinDay > this.ainMaxDaysOfMonth[ this.getMonth() - 1 ] ){
			return false;
		}
		this.inDay = pinDay;
		return true;
	}
	
	
	function Fecha_getDay( pinNumberOfDigits ){
		if( pinNumberOfDigits ){
			stDay = "" + this.inDay;
			while( stDay.length < pinNumberOfDigits ){
				stDay = "0" + stDay;
			}
			return stDay.substring( stDay.length - pinNumberOfDigits, stDay.length )
		}
		return this.inDay;
	}
	
	
	function Fecha_isLeapYear(){
		return ( ( this.getYear() % 4 ) == 0 && ( ( this.getYear() % 100 ) !=0 || ( this.getYear() % 400 ) == 0 ) );
	}
	
	
	function Fecha_setYear( pinYear ){
		if( /\D/.test( "" + pinYear ) ){
			return false;
		}
		pinYear = eval( pinYear );
		if ( pinYear < 100 ){
			pinYear		= pinYear > 40 ? pinYear + 1900 : pinYear + 2000;
		}
		this.inYear = pinYear;
		if( this.isLeapYear() ){
			this.ainMaxDaysOfMonth[1] = 29;
		}else{
			this.ainMaxDaysOfMonth[1] = 28;
		}
		return true;
	}
	
	
	function Fecha_getYear( pinNumberOfDigits ){
		if( pinNumberOfDigits ){
			var stYear = "" + this.inYear;
			while ( stYear.length < pinNumberOfDigits ){
				stYear = "0" + stYear;
			}
			return stYear.substring( stYear.length - pinNumberOfDigits, stYear.length );
		}
		return this.inYear;
	}
	
	
	function Fecha_toString(){
		return this.formatDate();
	}
	
	function Fecha_clone(){
		var obCopy	= new Fecha( this.getFormat(), this.getLanguage() );
		obCopy.setDate( this.getDay(), this.getMonth(), this.getYear() );
		return obCopy;
	}
	
	function Fecha_incYear( pinYears ){
		if( !pinYears || !/\-?\d+$/.test( "" + pinYears ) ){
			return false;
		}
		pinYears	= eval( pinYears );
		this.inYear	+= pinYears;
		if (this.isLeapYear()){
			this.ainMaxDaysOfMonth[1] = 29;
		}else{
			this.ainMaxDaysOfMonth[1] = 28;
		}
		if ( this.inDay > this.ainMaxDaysOfMonth[ this.inMonth - 1 ] ){
			this.inDay = this.ainMaxDaysOfMonth[ this.inMonth - 1 ]
		}
		return true;
	}
	
	function Fecha_incMonth( pinMonths ){
		if( !pinMonths || !/\-?\d+$/.test( "" + pinMonths ) ){
			return false;
		}
		pinMonths	= eval( pinMonths )
		this.inMonth 	+= pinMonths;
		var tempYear	= 0;
		if ( this.inMonth < 1 ){
			while( this.inMonth < 1 ){
				this.inMonth += 12;
				tempYear--;
			}
		}else if( this.inMonth > 12 ){
			while( this.inMonth > 12 ){
				this.inMonth -= 12;
				tempYear++;
			}
		}
		this.incYear( tempYear );
		if ( this.inDay > this.ainMaxDaysOfMonth[ this.inMonth - 1 ] ){
			this.inDay = this.ainMaxDaysOfMonth[ this.inMonth - 1 ]
		}
	}
	
	
	function Fecha_incDay( pinDays ){
		if( !pinDays || !/\-?\d+$/.test( "" + pinDays ) ){
			return false;
		}
		var dayAux	= this.inDay + eval( pinDays );
		if ( dayAux < 1 ){
			while( dayAux < 1 ){
				this.incMonth( -1 );
				dayAux += this.ainMaxDaysOfMonth[ this.getMonth() - 1 ];
			}
		}else if( dayAux > this.ainMaxDaysOfMonth[ this.getMonth() - 1 ] ){
			while( dayAux > this.ainMaxDaysOfMonth[ this.getMonth() - 1 ] ){
				dayAux -= this.ainMaxDaysOfMonth[ this.getMonth() - 1 ];
				this.incMonth( 1 );
			}
		}
		this.inDay = dayAux
		return true;
	}
	
	
	
	function Fecha_setDate( pinDay, pstMonth, pinYear ){
		var tempFecha = new Fecha();
		if( tempFecha.setYear( pinYear ) && 
				tempFecha.setMonth( pstMonth ) && 
				tempFecha.setDay( pinDay ) ){
			this.setYear( tempFecha.getYear() );
			this.setMonth( tempFecha.getMonth() );
			this.setDay( tempFecha.getDay() );
			return true;
		}
		return false;
	}
	
	function Fecha_formatDate( stFormato ){
		var cadenaFecha = stFormato ? stFormato.toLowerCase() : this.getFormat();
		cadenaFecha = cadenaFecha.replace( /yyyy/g,this.getYear(4) );
		cadenaFecha = cadenaFecha.replace( /yy/g,this.getYear(2) );
		cadenaFecha = cadenaFecha.replace( /mmm/g,this.getShortMonthName() );
		cadenaFecha = cadenaFecha.replace( /mes/g,this.getMonthName() );
		cadenaFecha = cadenaFecha.replace( /mm/g,this.getMonth(2) );
		cadenaFecha = cadenaFecha.replace( /dd/g,this.getDay(2) );
		cadenaFecha = cadenaFecha.replace( /\[d\]/g,this.getDay() );
		cadenaFecha = cadenaFecha.replace( /\[m\]/g,this.getMonth() );
		return cadenaFecha;
	}