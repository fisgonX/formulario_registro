<?php
	if ($DEPURAR)
		echo "TIPO LISTADO: ".$tipoListado." - OPERACION: ".$operacion."<br>";

// Declaramos variables
	$txtTitular = "";												// titular panel
	$txtBoton = "";												// texto boton
	$txtBoton2 = "";
	switch ($operacion) {
		case "consulta":
			$txtOcultar = 0; 
			$txtTitular = "Consulta de ".$tipoListado;
			if ($tipoListado != "Incidencia")
				$txtBoton2 = "Editar ".$tipoListado;
			$urlLink = "clientes_ficha.php?v=s&tipo=".$tipoListado."&operacion=update";
			break;

		case "update":
			if ($tipoListado == "Cliente") {
				$txtTitular = "Grabar Contacto";
				$txtBoton = "Grabar Contacto";
			} else {
				$txtTitular = "Grabar ".$tipoListado;
				$txtBoton = "Grabar ".$tipoListado;
			} 
			break;

		default:
			if (substr($tipoListado, -1) == "a")
				$txtTitular = "Nueva ".$tipoListado;
			else
				$txtTitular = "Nuevo ".$tipoListado;
			$txtBoton = "Dar de Alta";
			if ($FORM_CRUD)
				$txtBoton .= " Evento";
			elseif ($FORM_ALTA)
				$txtBoton = "Rellenar Solicitud";
			elseif ($FORM_CONTACTO)
				$txtBoton = "Enviar Solicitud";
			else
				$txtBoton .= " ".$tipoListado;
			break;
	}

	$lista = "";													// filtro campos para listados
	$sufijo = "";													// indicamos |numerocampo|campopequeño|sufijo|
	$txtAnchoCampo = "";											// ancho label (ancho-sm, ancho-lg, ancho-xl)

	include "config/campos_datos.php";

	if ($lista != "") {
		$aux = explode("|", $lista);
		$listaQuery = "";
		for ($x=0; $x<count($aux); $x++) {
			if (isset($campos[$aux[$x]])) {
				$nomCampo = limpiarCampo($campos[$aux[$x]]);
				$nomCampo = limpiarCampoExterno($nomCampo);
				if ($nomCampo != "")
					$listaQuery .= $nomCampo."|";
			}
		}
		//echo "lista: ".$listaQuery."<br>";
	}
	
	function verCampos($opcion)
	{
		global $campos, $camposTipo, $campos_alta, $camposTipo_alta, $noGrabar, $FORM_ALTA, $noGrabar1, $noGrabar2, $limiteAlta, $DEPURAR;
		$campoSQL = "";
		$valorSQL = "";
		$n1 = count($campos);
		if ($DEPURAR) {
			echo "FORM_ALTA: ".$FORM_ALTA."<br>";
			echo "noGrabar: ".$noGrabar."<br>";
			echo "noGrabar1: ".$noGrabar1."<br>";
			echo "noGrabar2: ".$noGrabar2."<br>";
			echo "limiteAlta: ".$limiteAlta."<br>";		
			echo "n1: ".$n1."<br>";
		}
		$numPoblacion = 1;
		$numProvincia = 1;
		for ($x=1; $x<=$n1; $x++) {
			if ($FORM_ALTA) {
				$nomCampo = limpiarCampo($campos_alta[$x]);
				$txtCampoTipo = $camposTipo_alta[$x];
			} else {
				$nomCampo = limpiarCampo($campos[$x]);
				$txtCampoTipo = $camposTipo[$x];
			}
			$swComillas = true;
			if (($nomCampo == "fecha" || $nomCampo == "fechaalta" || $nomCampo == "fechasolicitud") && $opcion == "insert") {
				$swComillas = false;
				$valor = "NOW()";
			} else {	
				if (substr($nomCampo,0,2) == "id")
					$swComillas = false;
				if (isset($_POST[$nomCampo]))
					$valor = $_POST[$nomCampo];
			}
			if ($nomCampo == "nombreevento") {
				if ($valor == "")
					$valor = $_POST["nombreevento2"];
			}
			
			if ($nomCampo == "fechapagoreserva" && $FORM_ALTA) {
				$swComillas = false;
				$valor = "NOW()";
			}
			if ($txtCampoTipo == "pwd") {
				if ($valor != "")
					$valor = "sha1('".$valor."')";
				$swComillas = false;
			} 	
			if ($txtCampoTipo == "date") {
				if ($valor == "" || $valor == "0000-00-00") {
					$swComillas = false;
					$valor = "null";
				} else {
					$swComillas = true;
					$valor = convertirFecha($valor);
				}
			}
			if ($FORM_ALTA) {
				if ($nomCampo == "poblacion") {
					$valor = $_POST[$nomCampo.$numPoblacion];
					$numPoblacion++;	
				}
				if ($nomCampo == "provincia") {
					$valor = $_POST[$nomCampo.$numProvincia];
					$numProvincia++;	
				}
			}
			if ($txtCampoTipo == "pvp")
				$valor = convertirDecimal($valor);
			if ($nomCampo == "baja")
				$swComillas = false;
			if ($txtCampoTipo == "rad")
				$swComillas = false;
			if ($nomCampo == "gestioncompleta")
				$swComillas = false;
			//echo $nomCampo." - ".$swComillas."<br>";
						
			if ($FORM_ALTA) {
				$noGrabar = $noGrabar1;
				if ($x > $limiteAlta)
					$noGrabar = $noGrabar2;
			}
			if ($DEPURAR)
				echo "<br>".$noGrabar."<br>";
			
			$swNoGrabar = 0;
			if ($noGrabar != "") {
				$aux = explode("|", $noGrabar);
				for ($y=0; $y<count($aux); $y++) {
					//echo $aux[$y].": ".$x."<br>";
					if ($aux[$y] == $x)
						$swNoGrabar = 1;
				}
			}
			if (!$FORM_ALTA && $camposTipo[$x] == "ext")
				$swNoGrabar = 1;
			if ($DEPURAR)
				echo $x." - swNoGrabar: ".$swNoGrabar."<br>";
			if ($swNoGrabar == 0) {
				$valor = str_replace("'", "´", $valor);
				if ($opcion == "insert") {
					if ($nomCampo == "email")
						$_SESSION["email"] = $valor;
					$campoSQL .= $nomCampo.", ";       
					if ($swComillas)
						$valorSQL .= "'".$valor."', ";       
					else
						$valorSQL .= $valor.", ";
				} else {
					if ($nomCampo != "fechaalta" && $nomCampo != "idusuario") {
						if ($swComillas)
							$campoSQL .= $nomCampo." = '".$valor."', ";
						else	
							$campoSQL .= $nomCampo." = ".$valor.", ";
					}
				}
			}
		}
		
		if ($opcion == "insert") {
			$campoSQL = substr($campoSQL,0,strlen($campoSQL)-2);
			$valorSQL = substr($valorSQL,0,strlen($valorSQL)-2);
			return $campoSQL."|".$valorSQL;
		} else {
			$campoSQL = substr($campoSQL,0,strlen($campoSQL)-2);
			return $campoSQL."|";
		}
	}
?>