;(function(root, factory) {
  if (typeof define === 'function' && define.amd) {
    define([], factory);
  } else if (typeof exports === 'object') {
    module.exports = factory();
  } else {
    root.Pselect = factory();
  }
}(this, function() {
var pselectDataProvinces = [{
	"id": "01",
	"nm": "Alava / Araba"
}, {
	"id": "02",
	"nm": "Albacete"
}, {
	"id": "03",
	"nm": "Alicante / Alacant"
}, {
	"id": "04",
	"nm": "Almería"
}, {
	"id": "33",
	"nm": "Asturias"
}, {
	"id": "05",
	"nm": "Avila"
}, {
	"id": "06",
	"nm": "Badajoz"
}, {
	"id": "07",
	"nm": "Balears, Illes"
}, {
	"id": "08",
	"nm": "Barcelona"
}, {
	"id": "09",
	"nm": "Burgos"
}, {
	"id": "39",
	"nm": "Cantabria"
}, {
	"id": "10",
	"nm": "Cáceres"
}, {
	"id": "11",
	"nm": "Cádiz"
}, {
	"id": "51",
	"nm": "Ceuta"
}, {
	"id": "12",
	"nm": "Castellón / Castelló"
}, {
	"id": "13",
	"nm": "Ciudad Real"
}, {
	"id": "14",
	"nm": "Córdoba"
}, {
	"id": "15",
	"nm": "Coruña, A"
}, {
	"id": "16",
	"nm": "Cuenca"
}, {
	"id": "17",
	"nm": "Girona"
}, {
	"id": "18",
	"nm": "Granada"
}, {
	"id": "19",
	"nm": "Guadalajara"
}, {
	"id": "20",
	"nm": "Guipuzcoa / Gipuzkoa"
}, {
	"id": "21",
	"nm": "Huelva"
}, {
	"id": "22",
	"nm": "Huesca"
}, {
	"id": "23",
	"nm": "Jaén"
}, {
	"id": "24",
	"nm": "León"
}, {
	"id": "25",
	"nm": "Lleida"
}, {
	"id": "26",
	"nm": "La Rioja"
}, {
	"id": "27",
	"nm": "Lugo"
}, {
	"id": "28",
	"nm": "Madrid"
}, {
	"id": "29",
	"nm": "Málaga"
}, {
	"id": "52",
	"nm": "Melilla"
}, {
	"id": "30",
	"nm": "Murcia"
}, {
	"id": "31",
	"nm": "Navarra"
}, {
	"id": "32",
	"nm": "Ourense"
}, {
	"id": "34",
	"nm": "Palencia"
}, {
	"id": "35",
	"nm": "Palmas, Las"
}, {
	"id": "36",
	"nm": "Pontevedra"
}, {
	"id": "38",
	"nm": "Santa Cruz de Tenerife"
}, {
	"id": "37",
	"nm": "Salamanca"
}, {
	"id": "40",
	"nm": "Segovia"
}, {
	"id": "41",
	"nm": "Sevilla"
}, {
	"id": "42",
	"nm": "Soria"
}, {
	"id": "43",
	"nm": "Tarragona"
}, {
	"id": "44",
	"nm": "Teruel"
}, {
	"id": "45",
	"nm": "Toledo"
}, {
	"id": "46",
	"nm": "Valencia / València"
}, {
	"id": "47",
	"nm": "Valladolid"
}, {
	"id": "48",
	"nm": "Vizcaya / Bizkaia"
}, {
	"id": "49",
	"nm": "Zamora"
}, {
	"id": "50",
	"nm": "Zaragoza"
}, {
	"id": "99",
	"nm": "OTRA"
}];

var psProto = {
	create: create,
	init: init,
}

function Pselect(options) {
	return Object.create(psProto).init(options);
}

function init(options) {
	options = options ? options : {};
	this.provinces = options.provinces || pselectDataProvinces;
	this.provinceDefaultText = options.provText || 'Elegir Provincia';
	return this;
}

function create(provincesElement, municipesElement) {
	var self = this;
	_addOption(provincesElement, this.provinceDefaultText, '', true);

	this.provinces.forEach(function (province) {
		//_addOption(provincesElement, province.nm, province.id);
		_addOption(provincesElement, province.nm, province.nm );
	});
}

function _addOption(parent, text, value, disabled) {
	var opt = document.createElement('option');
	opt.value = value;
	opt.innerHTML = text;
	if (disabled) {
		opt.setAttribute('selected', '');
		opt.setAttribute('disabled', '');
	}
	if (valor == value)
		opt.setAttribute('selected', '');
			
	parent.appendChild(opt);
}

return Pselect;
}));


var cpProvincia = new Array();

cpProvincia[1] = "Alava / Araba";
cpProvincia[2] = "Albacete";
cpProvincia[3] = "Alicante / Alacant";
cpProvincia[4] = "Almería";
cpProvincia[33] = "Asturias";
cpProvincia[5] = "Avila";
cpProvincia[6] = "Badajoz";
cpProvincia[7] = "Balears, Illes";
cpProvincia[8] = "Barcelona";
cpProvincia[9] = "Burgos";
cpProvincia[39] = "Cantabria";
cpProvincia[10] = "Cáceres";
cpProvincia[11] = "Cádiz";
cpProvincia[51] = "Ceuta";
cpProvincia[12] = "Castellón / Castelló";
cpProvincia[13] = "Ciudad Real";
cpProvincia[14] = "Córdoba";
cpProvincia[15] = "Coruña, A";
cpProvincia[16] = "Cuenca";
cpProvincia[17] = "Gerona / Girona";
cpProvincia[18] = "Granada";
cpProvincia[19] = "Guadalajara";
cpProvincia[20] = "Guipuzcoa / Gipuzkoa";
cpProvincia[21] = "Huelva";
cpProvincia[22] = "Huesca";
cpProvincia[23] = "Jaén";
cpProvincia[24] = "León";
cpProvincia[25] = "Lérida / Lleida";
cpProvincia[26] = "La Rioja";
cpProvincia[27] = "Lugo";
cpProvincia[28] = "Madrid";
cpProvincia[29] = "Málaga";
cpProvincia[52] = "Melilla";
cpProvincia[30] = "Murcia";
cpProvincia[31] = "Navarra";
cpProvincia[32] = "Ourense";
cpProvincia[34] = "Palencia";
cpProvincia[35] = "Palmas, Las";
cpProvincia[36] = "Pontevedra";
cpProvincia[38] = "Santa Cruz de Tenerife";
cpProvincia[37] = "Salamanca";
cpProvincia[40] = "Segovia";
cpProvincia[41] = "Sevilla";
cpProvincia[42] = "Soria";
cpProvincia[43] = "Tarragona";
cpProvincia[44] = "Teruel";
cpProvincia[45] = "Toledo";
cpProvincia[46] = "Valencia / València";
cpProvincia[47] = "Valladolid";
cpProvincia[48] = "Vizcaya / Bizkaia";
cpProvincia[49] = "Zamora";
cpProvincia[50] = "Zaragoza";

function cambiarProvinciaCP(cp) {
	var provincia = cpProvincia[parseInt(cp.substr(0, 2))];
	//alert ("CP: "+cp+"\nPROVINCIA: "+provincia);
	if (provincia != null)
		document.getElementById("ps-prov").value = provincia;
}