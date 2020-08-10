<?php
	$provincia = "";
	$campoSQL = "";														// Recogemos campos clientes y eventos
	$valorSQL = "";
	$tags = array_keys($_POST);									
	$valores = array_values($_POST);
	for ($x=0; $x<count($tags);$x++) {
		$campo = $tags[$x];
		$valor = trim($valores[$x]);
		if ($campo != "baja" && $campo != "g-recaptcha-response" && $campo != "condiciones" && $campo != "nombreevento2") {
			if (strpos($campo,"poblacion") !== false || strpos($campo,"provincia") !== false) {
				$campo = str_replace("1", "", $campo);
				$campo = str_replace("2", "", $campo);
			}
			switch ($campo) {
				case "fechaevento":
				case "fechapagoreserva":
				case "fecha2pago":
					if ($valor == "" || $valor == "0000-00-00")
						$valor = "null";
					else {
						$valor = str_replace("'","",$valor);
						if ($campo == "fechaevento")
							$fechaevento = $valor;
						$valor = convertirFecha($valor,"");
					}
					break;
				case "poblacion":
					$poblacion = str_replace("'","",$valor);
					break;
				case "provincia":
					$provincia = str_replace("'","",$valor);
					break;
				case "nombre":
					$nomCliente = str_replace("'","",$valor);
					break;
				case "apellidos":
					$apeCliente = str_replace("'","",$valor);
					break;
				case "telefono":
					$telefono = str_replace("'","",$valor);
					break;
			}
			$campoSQL .= $campo."|";
			$valor = str_replace("'", "´", $valor);
			if ($campo == "iva" || $campo == "gestioncompleta" || $valor == "null")
				$valorSQL .= $valor."|";
			else
				$valorSQL .= "'".$valor."'|";
		}	
	}
	$aux2 = "";
	$aux3 = explode("|",$campoSQL);
	$aux4 = explode("|",$valorSQL);

// Definimos rangos (ojo! que coincida con el orden en campos_datos.php)
	$n1 = 4;							// nif (primero)			
	$n2 = 13;							// telefono (ultimo)

	$idUsuario = 1;
	if ($FORM_CRUD) {
		if (isset($_COOKIE["id"]) && $_COOKIE["id"] != "")
			$idUsuario = $_COOKIE["id"];
	}
	if ($DEPURAR) {
		if (isset($_COOKIE["id"]))
			echo "COOKIE: ".$_COOKIE["id"]."<br>";
	}

// Controlamos que no exista el cliente (NIF o EMAIL)	
	$swCliente = 0;
	$idCliente = "";

	$controlDuplicados = false;			// saltamos control
	if ($controlDuplicados) {
		for ($x=0; $x<count($aux2); $x++) {
			if (isset($campos_alta[$aux2[$x]])) {
				$campoControl = strtolower(trim(str_replace("*", "", $campos_alta[$aux2[$x]])));
				for ($y=$n1; $y<=$n2; $y++) {
					$campo = strtolower(trim($aux3[$y]));
					if ($DEPURAR)
						echo $y.": ".$campo."<br>";
					$valor = strtolower(trim(str_replace("'", "", $aux4[$y])));
					if ($DEPURAR)
						echo "idCliente: ".$idCliente." - ".$campoControl." - ".$campo." = ".$valor."<br>";
					if ($campoControl == $campo && $valor != "" && $idCliente == "") {
						$verControl = true;
						if (($campo == "nif" && $valor == "x") || ($campo == "email" && $valor == "x@x.com"))
							$verControl = false;
						if ($campo == "nif" && $valor == "")
							$verControl = false;
						if ($verControl) {
							$strSQL = "SELECT * FROM clientes WHERE nif is not null AND ".$campo." = '".$valor."'";
							$rs = ejecutarQUERY($strSQL);
							$id = 0;
							if ($rs->num_rows > 0) {
								while ($row = $rs->fetch_assoc())
									$id = $row["id"];
							}
							if ($id != 0) {
								$swCliente = 1;
								$idCliente = $id;
							}		
						}
					}
				}	
			}
		}
	}
	
	$cadena1 = "";
	$cadena2 = "";
	
	if ($swCliente == 0) {												// INSERT en clientes
		$emailCliente = "";
		for ($x=$n1; $x<=$n2; $x++) {
			$campo = trim($aux3[$x]);
			$valor = trim($aux4[$x]);
			if ($campo == "email")
				$emailCliente = $valor;
			$cadena1 .= $campo.", ";
			$cadena2 .= $valor.", ";
		}
		$cadena1 = substr($cadena1, 0, -2);
		$cadena2 = substr($cadena2, 0, -2);
		$strSQL = "INSERT INTO clientes (fechaalta,".$cadena1.") "
			 		."VALUES (NOW(),".$cadena2.")";
	} else {																	// UPDATE en clientes
		for ($x=$n1; $x<=$n2; $x++) {
			$campo = trim($aux3[$x]);
			$valor = trim($aux4[$x]);
			$cadena1 .= $campo." = ".$valor.", ";
		}
		$cadena1 = substr($cadena1, 0, -2);
		$strSQL = "UPDATE clientes SET ".$cadena1.", baja = 0 WHERE id = ".$id;
	}	
	$rs = ejecutarQUERY($strSQL);
	
	if ($DEPURAR) {
		setcookie ("campo", $campoSQL, time()+365*24*60*60); 
		setcookie ("valor", $valorSQL, time()+365*24*60*60); 
	} else {
		setcookie ("campo","",time()-100);
		setcookie ("valor","",time()-100);
	}	

// enviamos email
	$ENVIAR_EMAIL = true;
	if ($ENVIAR_EMAIL)
		include "includes/mail/usuario_enviarPassword.php";

	$swCliente = 0;			// forzamos que siempre se de alta y no haya aviso
	$txtLink = "alta_OK.php?respuesta=".$swCliente;
	if ($DEPURAR)
		echo $txtLink;
	else
		redirigir($txtLink,"s");
?>