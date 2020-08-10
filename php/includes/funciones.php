<?php
	function redirigir($pagina, $top)
	{
		global $msg, $DEPURAR;
		if ($DEPURAR)
			echo "se redirige a <a href='".$pagina."'>".$pagina."</a><br>con el mensaje '".$msg."'";
		else {
			$txtTarget = "";
			if ($top == "s")
				$txtTarget = " target='_top'";
			echo "<html>";
			echo "<body onload='document.form1.submit()'>";
			echo "<form name='form1' action='".$pagina."' method='post'".$txtTarget.">";
			echo "<input type='hidden' name='msg' value='".$msg."'>";
			echo "</form>";
			echo "</body>";
			echo "<html>";
		}
	}

	function convertirFecha($fecha)
	{
		$sw = 0;
		if ($fecha != "") {
			if (strpos($fecha, "-") !== false) {
				$sw = 1;
				$aux = explode("-", $fecha);
			} elseif (strpos($fecha, "/") !== false) {
				$sw = 1;
				$aux = explode("/", $fecha);
			}
			if ($sw == 1)
				return $aux[2]."-".$aux[1]."-".$aux[0];
			else
				return $fecha;
		}
	}	

	function convertirFecha2($fecha,$tipo)
	{
		if ($fecha != "" && $fecha != "0000-00-00" && strpos($fecha, "-") !== false) {
			if (strpos($fecha, " ") !== false) {
				$aux = explode(" ", $fecha);
				$fecha = $aux[0];
			}
			$fecha = date_create($fecha);
			if ($tipo == "ing")
				$txtFecha = date_format($fecha,"Y-m-d");
			elseif ($tipo == "ing2")
				$txtFecha = date_format($fecha,"y-m-d");
			elseif ($tipo == "hora") {
				$txtFecha = date_format($fecha,"d/m/Y");
				if (isset($aux[1]))
					$txtFecha .= " ".$aux[1];
			} else 	
				$txtFecha = date_format($fecha,"d/m/Y");
			return $txtFecha;
		} else
			return "";	
	}

	function convertirTelefono($numero)
	{
		if (is_numeric($numero)) {
			$numero = str_replace(array(" ", "-"), array(""), $numero);
			if (strlen($numero) == 9) {
				$comienzo = strlen($numero);
				$resultado = "";
				while($comienzo >= 0) {
					$resultado = substr($numero, $comienzo, 3) . " " . $resultado;
					$comienzo -= 3;
				}
				return rtrim($resultado);
			} else
				return rtrim($numero);
		} else
			return $numero;
	}	

	function imprimirHTML($opcion)
	{
		if ($opcion == "cabecera") {
			echo "<html xmlns='http://www.w3.org/1999/xhtml' lang='es-ES' xml:lang='es-ES'>\n";
    		echo "<head>\n";
    		echo "<META HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=utf-8'/>\n";
    		echo "</head>\n";
 			echo "<body>\n";
 		} else {
			echo "</body>\n";
    		echo "</html>\n";
 		}
 	}

	$numPoblacion = 0;
	$numProvincia = 0;
	function mostrarCampo($nomCampo, $txtCampo, $txtValor, $ocultar, $id, $tipoCampo, $checkCampo)
	{
		global $operacion, $tipoListado, $txtSufijo, $txtCampoSM, $txtAnchoCampo, $rutaUpload, $path, $numPoblacion, $numProvincia, $FORM_ALTA, $horarioEvento, $zonaNombre, $EVITAR_CONTROL, $PERMISOS_EVENTO, $FORM_CRUD;
		//echo $txtAnchoCampo."-<br>";
		//echo $nomCampo.": ".$txtValor."<br>";
		//echo $tipoCampo."<br>";
		//echo $checkCampo."<br>";
		if ($tipoCampo == "password" && $txtValor != "")
			$txtValor = "";
		if ($txtAnchoCampo == "")
			$txtAnchoCampo = "ancho-sm";
		$txtCampo = str_replace("ID", "", $txtCampo);
		if ($ocultar == 1) {									// campo hidden														
			if ($id != "")
				$txtValor = $id;
			echo "<input name='".$nomCampo."' type='hidden' value='".$txtValor."'/>\n";
		} else {
			$swVer = true;
			if ($FORM_ALTA && $tipoCampo == "ext") 
				$swVer = false;
			
			$txtMaxLongitud = "";
			if ($nomCampo == "nombreevento" || $nomCampo == "lugarcelebracion" || $nomCampo == "notaslogo" || $nomCampo == "notashorario" || $nomCampo == "notaspago")
				$txtMaxLongitud = " maxlength='100'";
		
			if ($swVer) {
				$txtBloquear = "";
				if ($ocultar == 2 || $operacion == "consulta" || ($tipoCampo == "ext" && $operacion == "update"))
					$txtBloquear = " disabled";
				if (!$PERMISOS_EVENTO && $operacion != "insert") {
					if ($nomCampo != "nombreevento2" && $nomCampo != "notaslogo" && $nomCampo != "notaspago" && $nomCampo != "notashorario" && $nomCampo != "gestioncompleta")
						$txtBloquear = " disabled";
				}
				/*if ($nomCampo == "nif")
					$txtBloquear = " disabled";*/
					
				if ($tipoCampo == "hid") {
					if ($txtValor == "") {
						if ($nomCampo == "pais")
							$txtValor = "España";					
						if ($nomCampo == "baja")
							$txtValor = "0";					
					}
					echo "<input name='".$nomCampo."' type='hidden' value='".$txtValor."'/>\n";
				} else {
					$txtCSS = "";
					$txtCLASS = " class='form-control".$txtCampoSM."'";

					echo "<div class='form-group'>\n";
					echo "	<div class='input-group separar'".$txtBloquear.">\n";
					if ($EVITAR_CONTROL)
						$colorAsterisco = "gris";
					else
						$colorAsterisco = "rojo";
					if ($checkCampo == "s")
						$txtCSS = "		<span class='glyphicon glyphicon-asterisk ".$colorAsterisco." separar_izquierda'></span>\n";
					if ($tipoCampo == "mem") {
						echo "		<span class='input-group-addon ".$txtAnchoCampo."'>".$txtCampo.$txtCSS."</span>\n";
						echo "		<textarea id='".$nomCampo."' name='".$nomCampo."'".$txtCLASS." rows='8'".$txtBloquear.">".$txtValor."</textarea>\n";
					} else if ($tipoCampo == "html") {
						$txtEstilo = " style='width:100%;height:230px!important'";
						if ($operacion == "consulta")
							echo "		<div>".$txtValor."</div>\n";
						else {
							echo "		<span class='input-group-addon ".$txtAnchoCampo."'>".$txtCampo.$txtCSS."</span>\n";
							echo "		<textarea id='".$nomCampo."' name='".$nomCampo."'".$txtCLASS." rows='8'".$txtBloquear.$txtEstilo.">".$txtValor."</textarea>\n";
							echo "		<script>\n".
							 	  "		bkLib.onDomLoaded(function() {\n".
								  "			area1 = new nicEditor({maxHeight:240}).panelInstance('".$nomCampo."');\n".
  								  "		});\n".
								  "		</script>\n";				
						}
					} else if ($tipoCampo == "rad") {
						echo "		<span class='input-group-addon ".$txtAnchoCampo."'>".$txtCampo.$txtCSS."</span>\n";
						echo "		<span".$txtCLASS.$txtBloquear.">\n";
						if ($nomCampo == "gestioncompleta") {
							$txtRadio1 = " CHECKED";
							$txtRadio2 = "";
							$txtRadio3 = "";
							if ($txtValor == "1") {
								$txtRadio1 = "";
								$txtRadio2 = " CHECKED";
								$txtRadio3 = "";
							}
							if ($txtValor == "2") {
								$txtRadio1 = "";
								$txtRadio2 = "";
								$txtRadio3 = " CHECKED";
							}
							if ($operacion != "consulta" || ($operacion == "consulta" && ($txtValor == "0" || $txtValor == "")))							
								echo "			<input type='radio' name='".$nomCampo."' value='0'".$txtRadio1.$txtBloquear.">&nbsp;&nbsp;No\n";
							if ($operacion != "consulta" || ($operacion == "consulta" && $txtValor == "1"))							
								echo "			<input type='radio' name='".$nomCampo."' value='1'".$txtRadio2.$txtBloquear." style='margin-left:10px'>&nbsp;&nbsp;<span class='glyphicon glyphicon-road icono_amarillo separar_derecha'></span>PENDIENTE LOGO\n";	
							if ($operacion != "consulta" || ($operacion == "consulta" && $txtValor == "2"))							
								echo "			<input type='radio' name='".$nomCampo."' value='2'".$txtRadio3.$txtBloquear." style='margin-left:10px'>&nbsp;&nbsp;<span class='glyphicon glyphicon-road icono_verde separar_derecha'></span>PREPARADO\n";	
						} else {
							$txtRadio1 = "";
							$txtRadio2 = " CHECKED";
							if ($txtValor == "1") {
								$txtRadio1 = " CHECKED";
								$txtRadio2 = "";
							}
							echo "			<input type='radio' name='".$nomCampo."' value='1'".$txtRadio1.$txtBloquear.">&nbsp;&nbsp;Sí\n";	
							echo "			<input type='radio' name='".$nomCampo."' value='0'".$txtRadio2.$txtBloquear." style='margin-left:10px'>&nbsp;&nbsp;No\n";
						}
						echo "		</span>\n";
					} else if ($tipoCampo == "sel") {
						echo "		<span class='input-group-addon ".$txtAnchoCampo."'>".$txtCampo.$txtCSS."</span>\n";
						if ($nomCampo == "horainicio") {
							echo "		<select type='select-one'".$txtCLASS." name='".$nomCampo."'".$txtBloquear.">\n";
							echo "			<option value=''>Elegir horario</option>\n";
							for ($x=9; $x<=24; $x++) {
								if ($x == 24) {
									$hora1 = "00:00";
									$hora2 = "";
								} else {
									$hora1 = $x.":00";
									$hora2 = $x.":30";
								}
								$txtSELECT = "";
								if (strval($hora1) == $txtValor)
									$txtSELECT = " SELECTED";
								echo "			<option value='".$hora1."'".$txtSELECT.">".$hora1."</option>\n";
								if ($hora2 != "") {
									$txtSELECT = "";
									if (strval($hora2) == $txtValor)
										$txtSELECT = " SELECTED";
									echo "			<option value='".$hora2."'".$txtSELECT.">".$hora2."</option>\n";
								}	
							}
							echo "		</select>\n";
						}
						if ($nomCampo == "horarioevento") {
							echo "		<select type='select-one'".$txtCLASS." name='".$nomCampo."'".$txtBloquear.">\n";
							echo "			<option value=''>Elegir horario del evento</option>\n";
							for ($x=1; $x<=count($horarioEvento); $x++) {
								$txtSELECT = "";
								if (trim($horarioEvento[$x]) == trim($txtValor))
									$txtSELECT = " SELECTED";
								echo "			<option value='".$horarioEvento[$x]."'".$txtSELECT.">".$horarioEvento[$x]."</option>\n";	
							}
							echo "		</select>\n";
						}
						if ($nomCampo == "zona") {
							echo "		<select type='select-one'".$txtCLASS." name='".$nomCampo."'".$txtBloquear.">\n";
							echo "			<option value=''>Elegir zona</option>\n";
							for ($x=0; $x<count($zonaNombre); $x++) {
								$txtSELECT = "";
								//if (trim($zonaNombre[$x]) == trim($txtValor))
								if (intVal($txtValor) == $x+1)
									$txtSELECT = " SELECTED";
								echo "			<option value='".($x+1)."'".$txtSELECT.">".$zonaNombre[$x]."</option>\n";	
							}
							echo "		</select>\n";
						}
						if ($nomCampo == "numerohoras") {
							echo "		<select type='select-one'".$txtCLASS." name='".$nomCampo."'".$txtBloquear.">\n";
							echo "			<option value=''>Elegir número de horas</option>\n";
							for ($x=1; $x<=4; $x++) {
								$txtSELECT = "";
								if ($x == $txtValor)
									$txtSELECT = " SELECTED";
								echo "			<option value='".$x."'".$txtSELECT.">".$x."</option>\n";
							}
							echo "		</select>\n";
						}
						if ($nomCampo == "provincia") {
							$numProvincia = "";
							echo "		<select id='ps-prov".$numProvincia."' type='select-one'".$txtCLASS." name='".$nomCampo.$numProvincia."'".$txtBloquear."></select>\n";
							echo "		<script>\n";
							echo "		var valor = '".$txtValor."';\n";
							echo "		var provincias".$numProvincia." = document.getElementById('ps-prov".$numProvincia."');\n";
							echo "		Pselect().create(provincias".$numProvincia.");\n";
							echo "		</script>\n";
						}
					} else {
						if (strpos($nomCampo,"telefono") !== false || strpos($nomCampo,"movil") !== false)
							$txtValor = ConvertirTelefono($txtValor);
						echo "		<span class='input-group-addon ".$txtAnchoCampo."'>".$txtCampo.$txtCSS."</span>\n";
						if ($id != "") {							// campo externo (hidden ID y muestra texto)
							echo "			<input name='".$nomCampo."' type='hidden' value='".$id."'/>\n";
							echo "			<input id='".$nomCampo."_2' type='text'".$txtCLASS." name='".$nomCampo."_2' value='".$txtValor."'".$txtBloquear.$txtMaxLongitud."/>\n";
						} else { 									// campo normal
							$txtID = " id='".$nomCampo."'";	
							if ($tipoCampo == "date") {
								$txtID = " id='date_".$nomCampo."'";
								if ($txtValor != "")
									$txtValor = convertirFecha2($txtValor,"");
							}
							$txtMoneda1 = "";
							$txtMoneda2 = "";
							if ($tipoCampo == "pvp") {
								$txtMoneda1 = "<div class='input-icon'><i>€</i>";
								$txtMoneda2 = "</div>";
							}
							$txtNomCampo = $nomCampo;
							if ($FORM_ALTA) {
								if ($nomCampo == "poblacion") {
									$numPoblacion++;
									$txtNomCampo = $nomCampo.$numPoblacion;
								}
							}
							$txtNomEvento = "";
							if ($nomCampo == "cp")
								$txtNomEvento = " onChange=\"cambiarProvinciaCP(this.value)\"";
							if (($FORM_CRUD || $operacion == "update") && ($nomCampo == "nombreevento" || $nomCampo == "nombreevento2"))
								$txtNomEvento = " onChange=\"actualizarNombreEvento('".$nomCampo."')\"";
							echo $txtMoneda1."<input".$txtID." type='text'".$txtCLASS." name='".$txtNomCampo."' value='".$txtValor."'".$txtBloquear.$txtMaxLongitud.$txtNomEvento."/>".$txtMoneda2."\n";
							if ($tipoCampo == "date" && $operacion != "consulta")
								echo "<span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></span>\n";
							if ($txtBloquear != "")
								echo "<input type='hidden' name='".$nomCampo."' value='".$txtValor."'>\n";
							if ($txtSufijo != "")
								echo "<span class='sufijo'>".$txtSufijo."</span>\n";	         			
						}
					}
					echo "</div>\n";
					echo "<span class='help-block leyenda2' id='error'></span>\n"; 
					echo "</div>\n";
					if  ($operacion != "consulta" && $PERMISOS_EVENTO) {
						if ($tipoCampo == "pwd" && $operacion == "update")
							echo "<div class='leyenda derecha separar_derecha'>Por seguridad no se muestra la contraseña. Dejar en blanco si no se quiere modificar</div><br>\n";
						if ($nomCampo == "preciototal")
							echo "<div class='leyenda'><span class='glyphicon glyphicon-certificate icono_azul'></span>&nbsp;&nbsp;Poner 0 SI EL EVENTO ES GRATIS</div><br>\n";
						if ($nomCampo == "pagoreserva")
							echo "<div class='leyenda'><span class='glyphicon glyphicon-hand-right icono_amarillo'></span>&nbsp;&nbsp;Poner 0 SI SE PAGA EL DIA DEL EVENTO</div><br>\n";
						if ($nomCampo == "regalo")
							echo "<div class='leyenda'><img src='".$path."images/crud/log-pdf.png' height='16'>&nbsp;&nbsp;Poner 'VUELOS', 'AVIÓN', ALBUM', 'PENDRIVE' o 'USB' para generar los servicios personalizados en el Contrato</div><br>\n";
						if (($FORM_CRUD || $operacion == "update") && ($nomCampo == "nombreevento" || $nomCampo == "nombreevento2"))
							echo "<div class='leyenda'>Este campo se rellena en 2 sitios para mayor usabilidad</div>\n";
					
					}
				}
			}
		}
	}

	function generarPassword($length, $type = '')
	{
    // Seleccionamos el tipo de caracteres que deseas que devuelva el string
   	switch ($type) {
      	case 'num':
            // Solo cuando deseas que devuelva numeros.
            $salt = '1234567890';
            break;
        case 'lower':
            // Solo cuando deseas que devuelva letras en minusculas.
            $salt = 'abcdefghijklmnopqrstuvwxyz';
            break;
        case 'upper':
            // Solo cuando deseas que devuelva letras en mayusculas.
            $salt = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        default:
            // Para cuando deseas que la cadena este compuesta por letras y numeros
            $salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            break;
		}
		$rand = '';
		$i = 0;
		while ($i < $length) {
			$num = rand() % strlen($salt);
			$tmp = substr($salt, $num, 1);
			$rand = $rand.$tmp;
			$i++;
		}
		return $rand;
	}
?>