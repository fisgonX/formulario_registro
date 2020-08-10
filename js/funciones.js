function cerrarPopover()
{
  $('[data-toggle="popover"]').popover('hide');
}

function setCookie(cname, cvalue, exdays)
{
   document.cookie = cname+"=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires="+d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function focoPrimerCampo(objForm)
{
	if (objForm.length > 0) {
		for(var i=0; i < objForm.elements.length; i++) {
			var campo = objForm.elements[i];
			if (campo.type != "hidden") {
				campo.focus();
				break;
			}
		}
	}
}

function mostrarCapa(nombre, opcion)
{           
	if (opcion == "off")
		document.getElementById(nombre).style.display = "none";                                                   
	else
		document.getElementById(nombre).style.display = "block";                                                   
}

function borrarRegistro(id, tipoListado, baja)				// indicamos baja o eliminar de secciones concretas (clientes)
{
	if (baja == 1 || tipoListado == "Usuario") {
		txtAlert = "ELIMINAR DEFINITIVAMENTE";
		txtOperacion = "delete";
	} else {
		txtAlert = "DAR DE BAJA";
		txtOperacion = "baja";
	}
	if (confirm("Se va a "+txtAlert+" el "+tipoListado+"\n¿Deseas continuar?")) {
		urlPagina = "update.php";
		window.location = urlPagina+"?baja=1&tipo="+tipoListado+"&operacion="+txtOperacion+"&id="+id;       
	}
}

function recuperarRegistro(id, tipoListado)
{
	if (confirm("Se va a RECUPERAR el "+tipoListado+"\n¿Deseas continuar?")) {
		window.location = "update.php?tipo="+tipoListado+"&operacion=recuperar&id="+id;       
	}
}

function controlQuery(objForm,opcion)
{
	if (sinContenido(objForm.elements["query"+opcion].value)) {
		alert("Por favor, introducir una cadena a buscar");
		objForm.elements["query"+opcion].focus();
		return false;
	} else
		return true;
}

function resetBuscador()
{
	objForm = document.formBuscador;
	for (x=0; x<objForm.elements.length; x++) {
		//if (objForm.elements[x].name != "fechaini" && objForm.elements[x].name != "fechafin")
			objForm.elements[x].value = "";
	}
	objForm.submit();
}

function cerrarMensaje()
{
	$("#mensaje").alert("close");
}

function editarRegistro(tipo, tipoListado)
{
	if (tipoListado == "Cliente")
		tipoListado = "Contacto";
	objForm = document.form1;
	if (tipo == "alta") {
		txtAlert = "ENVIAR LA SOLICITUD";
	} else {
		if (tipo == "insert")
			txtTipo = "DAR DE ALTA";
		else
			txtTipo = "GRABAR";
		txtArticulo = "";
		if (tipoListado.indexOf("los") < 0) {
			txtArticulo = "el";
			if (tipoListado.substr((tipoListado.length - 1), tipoListado.length) == "a")
				txtArticulo = "la";
		}
		txtAlert = txtTipo+" "+txtArticulo+" "+tipoListado;
	}
	if (!objForm.condiciones.checked) {
		alert("Por favor, marca la opción que indica que aceptas\nlas CONDICIONES de uestra POLÍTICA DE PRIVACIDAD");
		return false;
	}

	if (confirm("Se va a "+txtAlert+"\n¿Deseas continuar?")) {
		return true;
	} else
		return false;
}


var preview = "";

function abrirVentanaModal(id,tipoListado,consulta)
{
	cerrarPopover();
	if (tipoListado == "condiciones")
		urlFrame = "https://www.descom.es/aviso-legal";
	if (tipoListado == "condiciones")
		urlFrame = "https://www.descom.es/politica-de-seguridad-de-la-informacion";
	document.getElementById('frame_modal').src = urlFrame;
	$("#myModal").modal();   
}

function enviarBuscador(objForm,opcion)
{
	objForm.elements["query"+opcion].value = "";
	objForm.submit();
}

function volver()
{
	history.back();
}

function irURL(url)
{
	window.location = url;
}

$(document).ready(function() {
	$('[data-toggle="popover"]').popover();   
});

$("document").ready(function() {
   $("#checkTodos").change(function () {
      $("input:checkbox").prop('checked', $(this).prop("checked"));
  });
});

function multiRegistros(opcion, tipoListado)
{
	cont = 0;
	cadena = "";
	$("input[name=seleccion]").each(function (index) {  
		if($(this).is(':checked')) {
      	cont++;
			cadena = cadena+"|"+$(this).val();
		}
	});
	if (cont == 0) {
		alert("Por favor, MARCAR como mínimo un registro");
	} else {
		document.form1.multiTipo.value = opcion;
		document.form1.multiValor.value = cadena;
		if (opcion == "baja")
			txtAlert1 = "DAR DE BAJA";
		else if (opcion == "leido")
			txtAlert1 = "MARCAR COMO LEIDO";
		else
			txtAlert1 = "MARCAR COMO NO LEIDO";
		if (cont == 1)
			txtAlert2 = "el registro seleccionado";
		else
			txtAlert2 = "los "+cont+" registros seleccionados";
		if (confirm("Se va a "+txtAlert1+" "+txtAlert2+"\n¿Desas continuar?")) {
			document.form1.action = "update_multi.php?tipo="+tipoListado;
			document.form1.submit();
		}
	}	
}

function imprimir(link)
{	
	url = link+"&print=s&tp=s";
	window.location = url;
}


var isMobile = {
	Android: function() {
   	return navigator.userAgent.match(/Android/i);
 	},
 	BlackBerry: function() {
   	return navigator.userAgent.match(/BlackBerry/i);
 	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
	Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i);
	},
	any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	}
};

function redondear (value, decimals) {
	return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}
