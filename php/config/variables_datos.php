<?php
	include "bd_datos.php";

// Valores de la empresa
	$nomEmpresa1 = "Descom";										// Nombre visual
	$nomEmpresa2 = "descom";										// Nombre para archivos

	$dominioEmpresa = "www.descom.es";
	$emailEmpresa = "info@descom.es";
	
// Definimos email recepcion formularios temporal. Debe ser igual que emailEmpresa
	$emaiEmpresa2 = $emailEmpresa;

	$fromEmpresa = "Descom.es";

// Datos SMTP para localhost
	$datosHOST1 = "localhost|25";

// Definimos objeto de envio mail (1 = mail de PHP / 2 = PHPMailer)
	$TIPO_EMAIL = 1;

// Key Captcha de Google
	$keyCAPTCHA = "";	

// definimos primera URL
	$linkInicio = $path."php/alta_form.php";
?>