<?php
	session_start();

	$DEPURAR = true;

	include "includes/bd.php";
	include "includes/funciones.php";
	include "includes/parametros.php";
 	include "includes/mail.php";
 	 	
	if ($DEPURAR)
		imprimirHTML("cabecera");

	$tipoListado = "Cliente";
	include "includes/crud/campos.php";
	include "includes/crud/update_alta.php";

	if ($DEPURAR)
 		imprimirHTML("pie");
?>
