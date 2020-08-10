<?php
	$numAlta = 0;

	$nomTabla = "clientes";
	$nomVista = "";
	$whereSQL = "";
	$ordenSQL = "";
		
	$campos[1] = "Fecha Alta";													
	$campos[2] = "*NIF";
	$campos[3] = "*Nombre";
	$campos[4] = "*Apellidos";
	$campos[5] = "Dirección";
	$campos[6] = "*Población";
	$campos[7] = "*CP";
	$campos[8] = "*Provincia";
	$campos[9] = "País";
	$campos[10] = "*Email";
	$campos[11] = "*Teléfono";
	
	for ($x=1;$x<=count($campos);$x++)
		$camposTipo[$x] = "txt";
	$camposTipo[2] = "nif";
	$camposTipo[8] = "sel";
	$camposTipo[10] = "email";
	$camposTipo[11] = "tel";

	$check[0] = "";												
	for ($x=1; $x<=count($campos); $x++) {						// campos obligatorios
		if (isset($campos[$x])) {
			if (strpos($campos[$x], "*") !== false)
				$check[$x] = "s"; 
		}
	}
?>