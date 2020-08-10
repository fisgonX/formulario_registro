<?php
  	if (isset($_GET["test"])) {											// ponemos modo TEST y guardamos en sesion hasta que test=n
  		if ($_GET["test"] == "s")
  			$aux = true;
  		if ($_GET["test"] == "n")
  			$aux = "";
  		$_SESSION["test"] = $aux;
  	}		
  	if (isset($_SESSION["test"]))
  		$DEPURAR = $_SESSION["test"];

  	$verCabecera = true;															// dejamos o quitamos cabecera
  	if (isset($v)) {
  		if ($v == "s")
  			$verCabecera = false;
  	} else if (isset($_GET["v"]) && $_GET["v"] == "s")
		$verCabecera = false;
  	
	$IMPRIMIR = false;															// imprimimos listado
	if (isset($_GET["print"]) && $_GET["print"] == "s") {
		$IMPRIMIR = true;
		$verCabecera = false;
	}

	$VER_TP = false;																// ocultamos cabeceras en impresion o compartir enlace
	if (isset($_GET["tp"]) AND $_GET["tp"] == "s")
		$VER_TP = true;

	//if ($VER_TP)
	//	$verCabecera = false;

	$id = "";
	if (isset($_GET["id"]) && $_GET["id"] != "")
		$id = $_GET["id"];
	elseif (isset($_POST["id"]) && $_POST["id"] != "")
		$id = $_POST["id"];
	
	$idcliente = "";
	if (isset($_GET["idcliente"]) && $_GET["idcliente"] != "")
		$idcliente = $_GET["idcliente"];
	elseif (isset($_POST["idcliente"]) && $_POST["idcliente"] != "")
		$idcliente = $_POST["idcliente"];	
	
	$tipoListado = "";
	if (isset($_GET["tipo"]) && $_GET["tipo"] != "")
		$tipoListado = $_GET["tipo"];
	elseif (isset($_POST["tipo"]) && $_POST["tipo"] != "")
		$tipoListado = $_POST["tipo"];

	$tipoEvento = "";
	if (isset($_GET["tipoEvento"]) && $_GET["tipoEvento"] != "")
		$tipoEvento = $_GET["tipoEvento"];
	elseif (isset($_POST["tipoEvento"]) && $_POST["tipoEvento"] != "")
		$tipoEvento = $_POST["tipoEvento"];
		
// REINICIAMOS BUSCADOR
	if (isset($_GET["inicio"]) && $_GET["inicio"] == "s") {
		$_SESSION["query1"] = "";
		$_SESSION["query2"] = "";
		$_SESSION["fechaini"] = "";
		$_SESSION["fechafin"] = "";
	}

// BUSCADOR
	$query1 = "";
	if (isset($_POST["query1"])) {
		$query1 = $_POST["query1"];
		$_SESSION["query1"] = $query1;
	} elseif (isset($_SESSION["query1"]))
		$query1 = $_SESSION["query1"];

	$query2 = "";
	if (isset($_POST["query2"])) {
		$query2 = $_POST["query2"];
		$_SESSION["query2"] = $query2;
	} elseif (isset($_SESSION["query2"]))
		$query2 = $_SESSION["query2"];

	$fechaINI = "";
	if (isset($_POST["fechaini"])) {
		$fechaINI = $_POST["fechaini"];
		$_SESSION["fechaini"] = $fechaINI;
	} elseif (isset($_SESSION["fechaini"]))
		$fechaINI = $_SESSION["fechaini"];
	
	$fechaFIN = "";
	if (isset($_POST["fechafin"])) {
		$fechaFIN = $_POST["fechafin"];
		$_SESSION["fechafin"] = $fechaFIN;
	} elseif (isset($_SESSION["fechafin"]))
		$fechaFIN = $_SESSION["fechafin"];

	$_SESSION["parametros"] = "";
	if ($fechaINI != "" && $fechaFIN != "")
		$_SESSION["parametros"] = "fechaini=".$fechaINI."&fechafin=".$fechaFIN;

	$baja = "";
	if (isset($_GET["baja"]) && $_GET["baja"] != "")
		$baja = $_GET["baja"];
	elseif (isset($_POST["baja"]) && $_POST["baja"] != "")
		$baja = $_POST["baja"];

	$operacion = "";
	if (isset($_GET["operacion"]) && $_GET["operacion"] != "")
		$operacion = $_GET["operacion"];
	elseif (isset($_POST["operacion"]) && $_POST["operacion"] != "")
		$operacion = $_POST["operacion"];
	
	if (isset($_GET["email"]) && $_GET["email"] != "")
		$emailUsuario = $_GET["email"];
	elseif (isset($_POST["email"]) && $_POST["email"] != "")
		$emailUsuario = $_POST["email"];
	
	$msg = "";
	if (isset($_GET["msg"]))
		$msg = $_GET["msg"];
	elseif (isset($_POST["msg"]))
		$msg = $_POST["msg"];

	if ($msg != "") {	
		$txtTipoListado = $tipoListado;
		if ($tipoListado == "Cliente")
			$txtTipoListado = "Contacto";
		switch ($msg) {
			case "in":
				$txtMsg = $txtTipoListado." CREADO correctamente";
				break;

			case "de":
				$txtMsg = $txtTipoListado." ELIMINADO correctamente";
				break;
			
			case "up":
				$txtMsg = $txtTipoListado." EDITADO correctamente";
				break;

			case "qr":
				$txtMsg = "Error en la QUERY";	
		}
	}
 	
	if (isset($DEPURAR)) {
		if ($DEPURAR) {
			$verGET = false;									// mostramos todos los GET
			if ($verGET && isset($_GET)) {
				echo "<u>GET</u><br>";
				$tags = array_keys($_GET);									
				$valores = array_values($_GET);
				for ($x=0; $x<count($tags); $x++)
					echo $x.": ".$tags[$x]. " = ".$valores[$x]."<br>";
			}	

			$verPOST = true;									// mostramos todos los POST
			if ($verPOST && isset($_POST)) {
				echo "<br><br><br><u>POST</u><br>";
				$tags = array_keys($_POST);									
				$valores = array_values($_POST);
				for ($x=0; $x<count($tags); $x++)
					echo $x.": ".$tags[$x]. " = ".$valores[$x]."<br>";
			}	

			$verSESSION = false;								// mostramos todos los SESIONES
			if ($verSESSION && isset($_SESSION)) {
				echo "<u>SESSION</u><br>";
				print_r($_SESSION);
			}

			$verCOOKIES = false;								// mostramos todos los COOKIES
			if ($verCOOKIES && isset($_COOKIE)) {
				echo "<u>COOKIES</u><br>";
				print_r($_COOKIE);
			}
		}	
	}
?>