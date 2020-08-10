<?php
	if (!isset($ruta))
		$ruta = "";

	include $ruta."config/variables.php";							// Valores generales y rutas
	include $ruta."config/variables_datos.php";						// Valores personalizados

// Preparamos cadena de conexion
	if ($LOCALHOST) {
		$hostBBDD = $hostLOCAL;
		$userBBDD = $userLOCAL;
		$pwdBBDD = $pwdLOCAL;
		$nomBBDD = $bbddLOCAL;
	} else {
		$hostBBDD = $hostONLINE;
		$userBBDD = $userONLINE;
		$pwdBBDD = $pwdONLINE;
		$nomBBDD = $bbddONLINE;
	} 
	//echo "host: <b>".$hostBBDD."</b> - user: <b>".$userBBDD."</b> - password: <b>".$pwdBBDD."</b> - bbdd: <b>".$nomBBDD."</b><br>";
	$conn = new mysqli($hostBBDD, $userBBDD, $pwdBBDD, $nomBBDD);

// Funciones de base de datos
	function ejecutarQUERY($query)
	{
		global $conn, $DEPURAR;
		if ($conn->connect_error) {
			die("<br><font color=red>Conexión fallida: <b>".$conn->connect_error."</b><br>");
			return false;
		} else {
			if ($DEPURAR)
				echo "<br><u>strSQL</u><br><font color=grey><i>".$query."</i></font><br><br>";
			$sw = 0;
			if ($DEPURAR) {                // no ejecutamos insert, update o delete si está en modo depuración
				$filtro = substr(strtolower($query),0,6);
				if ($filtro === "insert" || $filtro === "update" || $filtro === "delete")
					$sw = 1;  
				//echo "sw: ".$sw."-<br>";
			}   
			if ($sw == 0) {
				$acentos = $conn->query("SET NAMES 'utf8'");       
				return mysqli_query($conn,$query);
			}
			mysqli_set_charset($conn,"utf8");
		}
	} 

	function verTotalRegistros($query, $limite)
	{
		global $hostBBDD, $userBBDD, $pwdBBDD, $nomBBDD, $DEPURAR;
		$conn = new mysqli($hostBBDD, $userBBDD, $pwdBBDD, $nomBBDD);
		if ($conn->connect_error)
			die("<br><font color=red>Conexión fallida: <b>".$conn->connect_error."</b><br>");
		else {
			if ($DEPURAR)
				echo "<br><u>strSQL</u><br><font color=grey><i>".$query."</i></font><br><br>";
			$rs = $conn->query($query);
			$num = $rs->fetch_array();
			return $num[0];
		}  
	}

	function verBusqueda($query, $campos, $prefijo)
	{
		global $tipoListado, $DEPURAR, $SUPER_ADMIN;
		if ($query != "") {
			$query = trim(quitarAcentos($query));
			$aux1 = explode(" ", $query);
			$cadenaBUS = "";
			for ($x=0; $x<count($aux1); $x++) {
				if ($DEPURAR)
					echo $aux1[$x]."<br>";
				$cadenaBUS .= "(";
				if ($DEPURAR)
					echo $campos."<br>";
				$aux2 = explode("|", $campos);
				$cadena = "";
				for ($y=0; $y<count($aux2); $y++) {
					$sw = 0;
					$nomCampo = $aux2[$y]; 
					if ($nomCampo == "" || strpos($nomCampo, "fecha") !== false || substr(strtolower($nomCampo),0,2) == "id")
						$sw = 1;
					if ($sw == 0) {
						$busquedaAUX = $aux2[$y];
						$cadena.= "lower(".$prefijo.$busquedaAUX.") LIKE '%".strtolower($aux1[$x])."%' OR ";
					}
					if ($tipoListado == "Incidencia" && $nomCampo == "idcliente")
						$cadena.= "lower(nombre_apellidos_c) LIKE '%".strtolower($aux1[$x])."%' OR ";
				}
				$cadena = substr($cadena,0,strlen($cadena)-4);
				if ($DEPURAR)
					echo $cadena."<br><br>";
				$cadenaBUS .= $cadena.")\n AND ";
			}
			if ($DEPURAR)
				echo "<b>".$cadenaBUS."</b><br>";
			$cadenaBUS = substr($cadenaBUS,0,strlen($cadenaBUS)-5);
			/*if ($tipoListado == "Cliente" || $tipoListado == "Evento") {
				if (!$SUPER_ADMIN)
					$cadenaBUS = "(".$cadenaBUS.") AND baja <> 1";
			}*/
			return $cadenaBUS;
		} else
		return "";
	}

	function obtenerCampos($query)
	{
		global $DEPURAR;
		$rs = ejecutarQUERY($query);
		$num = 1;
		while ($row = $rs->fetch_assoc()) {
			if ($row["Field"] != "id") {
				$aux[$num] = $row["Field"];
				$num++;
			}
		}
		return $aux;
	}

	function obtenerValores($query)
	{
		global $campos;
		$numCampos = count($campos);
		$rs = ejecutarQUERY($query);
		$num = 1;
		$aux = array();
		while ($row = $rs->fetch_assoc()) {
			for ($x=1; $x<=$numCampos; $x++) {
				$aux[$num] = $row[$campos[$x]];
				$num++;
			}
		}
		return $aux;
	}

	function verValores($query, $nomCampo)
	{
		$rs = ejecutarQUERY($query);
		$num = 0;
		$aux = array();
		while ($row = $rs->fetch_assoc()) {
			$aux[$num] = $row[$nomCampo];
			$num++;
		}
		return $aux;
	}

	function verValor($query, $nomCampo)
	{
		$rs = ejecutarQUERY($query);
		//echo $query."<br>";
		$cadena = false;
		while ($row = $rs->fetch_assoc()) {
			if (strpos($nomCampo, "|") !== false) {
				$cadena = "";
				$aux = explode("|", $nomCampo);  
				for ($x=0; $x<count($aux); $x++)
					$cadena .= "|".$row[$aux[$x]];
			} else
				$cadena = $row[$nomCampo];
		}
		return $cadena;
	}

	function verDataTable($nomTabla, $whereSQL)
	{
		global $DEPURAR;
		echo "<div class='table-responsive'>";
		echo "<table class='table table-striped'>";

		$campos = obtenerCampos("SHOW columns FROM ".$nomTabla);        // mostramos campos
		echo "  <thead>";
		for ($x=1; $x<=count($campos); $x++)
			echo "<th>".$campos[$x]."</th>";
		echo "  <thead>";

		$strSQL = "SELECT * FROM ".$nomTabla;                           // mostramos valores
		if ($whereSQL != "")
			$strSQL .= " ".$whereSQL; 
		//echo $strSQL."<br>";
		$rs = ejecutarQUERY($strSQL);
		echo "  <tbody>";
		while ($row = $rs->fetch_assoc()) {
			echo "<tr>";
			for ($x=1; $x<=count($campos); $x++)
				echo "<td>".$row[$campos[$x]]."</td>";
		}
		echo "  </tbody>";
		echo "</table>";
		echo "</div>";
	}

	function limpiarCampo($cadena)
	{
		$tipo = "2";
		if ($tipo == "1") {
			$charset = "UTF-8";
			$cadena = iconv($charset, 'ASCII//TRANSLIT', $cadena);
			$cadena = preg_replace("/[^A-Za-z0-9 ]/", '', $cadena);
		} else {
			$cadena = strtolower($cadena);
			$cadena = str_replace("á", "a", $cadena);
			$cadena = str_replace("é", "e", $cadena);
			$cadena = str_replace("í", "i", $cadena);
			$cadena = str_replace("ó", "o", $cadena);
			$cadena = str_replace("ú", "u", $cadena);
			$cadena = str_replace(" ", "", $cadena);
			$cadena = str_replace("*", "", $cadena);
			if (strpos($cadena, "anyo") === false)
				$cadena = str_replace("y", "_", $cadena);
			$cadena = str_replace("cif/nif", "cif", $cadena);
			$cadena = str_replace("º", "", $cadena);
		}
		return $cadena;
	}

	function limpiarCampoExterno($cadena)
	{
		switch (strtolower($cadena)) {
			case "idcliente":
				$cadena = "nombre_c|apellidos_c";
				break;
			case "idusuario":
				$cadena = "nombre_u|apellidos_u";
				break;
		}
		return $cadena;
	}

	function limpiarCampoTxt($cadena)
	{
		$cadena = str_replace("*", "", $cadena);
		$cadena = str_replace("_", " ", $cadena);
		$cadena = str_replace("anyo", "año", $cadena);
		$cadena = ucwords(strtolower($cadena));
		$cadena = str_replace("Cif", "CIF", $cadena);
		$cadena = str_replace("nif", "NIF", $cadena);
		$cadena = str_replace("Url", "URL", $cadena);
		$cadena = str_replace("Nif", "NIF", $cadena);
		$cadena = str_replace("Cp", "CP", $cadena);
		$cadena = str_replace(" Y ", " y ", $cadena);
		$cadena = str_replace("Iva", "IVA", $cadena);
		$cadena = str_replace("Email2", "Email 2", $cadena);
		if (strrpos($cadena, "º") === false)
			$cadena = str_replace(" 2", "", $cadena);
		if (strtolower(substr($cadena,0,2)) == "id")
			$cadena = substr($cadena,2,strlen($cadena));
		return $cadena;
	}

	function verMilisegundos()
	{
	   return strval(date("YmdHis",mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))));
	}

	function quitarAcentos($cadena)
	{
		$cadena = mb_strtolower($cadena, "utf-8");
		$cadena = str_replace("á", "a", $cadena);
		$cadena = str_replace("é", "e", $cadena);
		$cadena = str_replace("í", "i", $cadena);
		$cadena = str_replace("ó", "o", $cadena);
		$cadena = str_replace("ú", "u", $cadena);
		$cadena = str_replace("ñ", "n", $cadena);
		$cadena = str_replace("ú", "u", $cadena);
		return $cadena;
	}

	function numberOfWeek($dia, $mes, $any)
	{
		$fecha = mktime (0, 0, 0, $mes, 1, $any);
		$numberOfWeek = ceil (($dia + (date ("w", $fecha)-1)) / 7);
		return $numberOfWeek;
	}

	function dayOfWeek($dia, $mes, $any)
	{
		global $semana;
		$fecha = mktime (0, 0, 0, $mes, $dia, $any);
		$dayOfWeek = $semana[date("w", $fecha)];
		return $dayOfWeek;
	}
?>