<?php
	$n1 = count($campos);

	$txtREGLAS = "";
	$txtMENSAJES = "";
	$numPoblacion = 0;
	$numProvincia = 0;
	for ($x=1; $x<=$n1; $x++) {
		$txtCampo = "";
		$tipoCampo = "";
		if (isset($campos[$x]))
			$txtCampo = $campos[$x];
		$tipoCampo = $camposTipo[$x];
		$nomCampo = limpiarCampo($txtCampo);
		$txtCampo = limpiarCampoTxt($txtCampo);
		if (isset($VER_PRECIORAPIDO) && $VER_PRECIORAPIDO) {
			if (strpos($nomCampo, "poblacion") !== false) {
				$numPoblacion++;
				$nomCampo = $nomCampo.$numPoblacion;				
			}
			if (strpos($nomCampo, "provincia") !== false) {
				$numProvincia++;
				$nomCampo = $nomCampo.$numProvincia;				
			}
		}
		
		$txtRules = "";
		$txtMessages = "";

		$VER_CONTROL = true;

		if ($EVITAR_CONTROL) {
			if (strpos($nomCampo, "provincia") !== false || strpos($nomCampo, "poblacion") !== false)
				$VER_CONTROL = true;
			else
				$VER_CONTROL = false;
		}
		
		if ($VER_CONTROL) {
			if (isset($check[$x]) && $check[$x] == "s") {
				$txtRules .= "required: true, ";
				if ($tipoCampo == "sel") 
					$txtMessages .= "required: \"Por favor, elegir ".mb_strtoupper($txtCampo,"utf-8")."\", ";
				else
					$txtMessages .= "required: \"Por favor, introducir ".mb_strtoupper($txtCampo,"utf-8")."\", ";
			}
		}
		
		if ($VER_CONTROL) {
			if ($nomCampo == "nif") {
				$txtRules .= "validNIF: true, ";
				$txtMessages .= "validNIF: \"Por favor, introducir un NIF VÁLIDO\", ";	
			}
			if ($nomCampo == "cp") {
				$txtRules .= "validCP: true, ";
				$txtMessages .= "validCP: \"Por favor, introducir un CP VÁLIDO\", ";	
			}
			if (strpos($nomCampo, "telefono") !== false) {
				$txtRules .= "validPhone: true, ";
				$txtMessages .= "validPhone: \"Por favor, introducir un TELÉFONO VÁLIDO\", ";
			}
			if (strpos($nomCampo, "email") !== false) {
				$txtRules .= "validEmail: true, ";
				$txtMessages .= "validEmail: \"Por favor, introducir un E-MAIL VÁLIDO\", ";
			}
		}
		if ($tipoCampo == "pvp") {
			$txtRules .= "validPVP: true, ";
			$txtMessages .= "validPVP: \"Por favor, introducir un PRECIO VÁLIDO\", ";
		}

		if ($txtRules != "") {
			$txtRules = substr($txtRules,0,strlen($txtRules)-2)." ";	
			$txtMessages = substr($txtMessages,0,strlen($txtMessages)-2)." ";	
			$txtREGLAS .= "			".$nomCampo.": { ".$txtRules."},\n";
			$txtMENSAJES .= "			".$nomCampo.": { ".$txtMessages."},\n";
		}
	}		
	if ($txtREGLAS != "") {
		$txtREGLAS = substr($txtREGLAS,0,strlen($txtREGLAS)-2)."\n";
		$txtMENSAJES = substr($txtMENSAJES,0,strlen($txtMENSAJES)-2)."\n";
	}
?>
<script>
<?php	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"safari") !== false) { ?>

<?php } else { ?>
$('document').ready(function()
{ 		 
<?php if (!$EVITAR_CONTROL) { ?>
// Validar campo alfanumérico
	var n1 = /^[a-zA-Z ]+$/;
	$.validator.addMethod("validTexto", function( value, element ) {
		return this.optional( element ) || n1.test( value );
	}); 

// Validar campo numérico
	var n2 = /^[0-9]/;
	$.validator.addMethod("validNumero", function( value, element ) {
		return this.optional( element ) || n2.test( value );
	}); 

// Validar email
	var n3 = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	$.validator.addMethod("validEmail", function( value, element ) {
		return this.optional( element ) || n3.test( value );
	});

// Validar telefono
	//var n4 = /^(\+34|0034|34)?[\s|\-|\.]?[6|7|9][\s|\-|\.]?([0-9][\s|\-|\.]?){8}$/;
	var n4 = /^[0-9+\(\)#\.\s\/ext-]+$/;
	$.validator.addMethod("validPhone", function( value, element ) {
		return this.optional( element ) || n4.test( value );
	});

// Validar CP
	var n5 = /^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/;
	$.validator.addMethod("validCP", function( value, element ) {
		return this.optional( element ) || n5.test( value );
	});
<?php } ?>

// Validar PVP
	var n6 = /^[0-9]+([,])?([0-9]+)?$/;
	$.validator.addMethod("validPVP", function( value, element ) {
		return this.optional( element ) || n6.test( value );
	});

<?php if (!$EVITAR_CONTROL) { ?>
// Validar NIF
	function checkNIF (value)
	{
		var validChars = 'TRWAGMYFPDXBNJZSQVHLCKET';
		var nifRexp = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKET]$/i;
		var nieRexp = /^[XYZ][0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKET]$/i;
		var str = value.toString().toUpperCase();

		if (!nifRexp.test(str) && !nieRexp.test(str)) return false;

		var nie = str
			.replace(/^[X]/, '0')
			.replace(/^[Y]/, '1')
			.replace(/^[Z]/, '2');

		var letter = str.substr(-1);
		var charIndex = parseInt(nie.substr(0, 8)) % 23;

		if (validChars.charAt(charIndex) === letter) return true;
		return false;
	}
	$.validator.addMethod('validNIF', function (value, element) {
		return this.optional(element) || checkNIF(value);
	});
<?php } ?>
	$("#register-form").validate({
		rules: {
<?=$txtREGLAS?>
		},
		messages: {
<?=$txtMENSAJES?>
		},
		errorPlacement : function(error, element) {
			$(element).closest('.form-group').find('.help-block').html(error.html());
		},
		highlight : function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).closest('.form-group').removeClass('has-error').addClass('form-group');
			$(element).closest('.form-group').find('.help-block').html('');
		},
		submitHandler: function(form) {
			if (editarRegistro('<?=$txtOperacion?>','<?=$tipoListado?>'))
				form.submit();
		}
	}); 
})
<?php } ?>
</script>