// items structure
// each item is the array of one or more properties:
// [text, link, settings, subitems ...]
// use the builder to export errors free structure if you experience problems with the syntax

var MENU_ITEMS = [
	['Archivo', null, null,
	 	['Inicio', null, null,],
		['Imprimir', null, null,],
		// this is how custom javascript code can be called from the item
		// note how apostrophes are escaped inside the string, i.e. 'Don't' must be 'Don\'t'
		['Salir', null, null,]
	],
	['Administrar', null, null,
		// this is how item scope settings are defined href="demo-iframe-b.php" target="interno"
		['Operadores', 'iframeoperador.php', {'tw':'interframe', 'tt':'Operadores', 'sb':'Operadores'}],
		// this is how multiple item scope settings are defined
		['Provedores', 'iframeprovedor.php', {'tw':'interframe', 'tt':'Provedores', 'sb':'Provedores'}],
		['Planes', 'iframeplanes.php', {'tw':'interframe', 'tt':'Planes', 'sb':'Planes'}],
		['Chips', 'iframechips.php', {'tw':'interframe', 'tt':'Chips', 'sb':'Chips'}],
		['Bases', 'iframebases.php', {'tw':'interframe', 'tt':'Bases', 'sb':'Bases'}],
		['Clientes', 'http://www.softcomplex.com/products/tigra_menu/docs/compare_menus.html'],
		['Ajuste Chips', '../demo2/index.html']
	],
	['Configuracion', null, null,
		['Administradores', '../demo1/index.html'],
		['Password', '../demo2/index.html'],		
		['Password System', '../demo2/index.html']
	],
	['Kardex y Reportes', null, null,
		['Reporte x Fecha', '../demo1/index.html'],
		['Reporte x Base', '../demo2/index.html'],
		['Reporte Totalizado', '../Entorno.php', {'tw':'interframe', 'tt':'Operadores', 'sb':'Operadores'}],
		['Estado Chips', '../demo3/index.html'],
		['Variaciones', '../demo4/index.html']
	],
	['Pendientes', null, null,
		['Tcikets', '../demo6/index.html']
	],
	['Ayuda', null, null,
		['ayuda', '../demo1/index.html'],
		['Acerca de', '../demo2/index.html'],
		['Contactenos', '../demo6/index.html']
	],
	['         ', 'http://www.softcomplex.com/support.html'],
	['         ', 'http://www.softcomplex.com/support.html']
];

