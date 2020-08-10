$(document).ready(function(){
	$("#form1").submit(function(event) {                  // formulario acceso
		with (this.email) {
			if (sinContenido(value) || !cadenaValida(value,TC_EMAIL)) {
				alert ("Por favor, introducir un EMAIL válido");
				this.email.focus();
				return false;
			}
		}
		with (this.password) {
			if (sinContenido(value)) {
				alert ("Por favor, introducir una CONTRASEÑA");
				this.password.focus();
				return false;
			}  
		}
	// Captcha
		if (window.location.host.indexOf("localhost") != 0) {
			if (!grecaptcha.getResponse(widgetId1)) {
				alert ("Por favor, indícanos que no eres un ROBOT");
				return false;
			}
		}
	});

	$("#form2").submit(function(event) {                   // formulario renovar clave
		urlPagina = "password_enviar.php";
		with (this.email) {
			if (sinContenido(value) || !cadenaValida(value,TC_EMAIL)) {
				alert ("Por favor, introducir un EMAIL válido");
				this.email.focus();
				return false;
			}  
		}  
	// Captcha
		if (window.location.host.indexOf("localhost") != 0) {
			if (!grecaptcha.getResponse(widgetId1)) {
				alert ("Por favor, indícanos que no eres un ROBOT");
				return false;
			}
		}
		window.location = "/control/";
	});
});

$("#myBtn").click(function() {                        // abrir ventana modal
	window.location = "password_form.php";
});
