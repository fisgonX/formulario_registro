<?php
// Muestra alert con resolución para test responsive
	$TEST_RESPONSIVE = false;

// Grabar LOG
	$GRABAR_LOG = true;

// Averiguamos si es LOCAL o ONLINE
	$LOCALHOST = false;
	if (strpos($_SERVER['HTTP_HOST'], "localhost") !== false || strpos($_SERVER['HTTP_HOST'], ".local") !== false)
		$LOCALHOST = true;
	
// Averiguamos si es formulario de alta online
	$FORM_ALTA = false;
	if (strpos($_SERVER['PHP_SELF'], "alta_") !== false)
		$FORM_ALTA = true;

// Averiguamos si es formulario de alta online
	$FORM_CONTACTO = false;
	if (strpos($_SERVER['PHP_SELF'], "contacto_") !== false)
		$FORM_CONTACTO = true;

// Averiguamos si es formulario upload fotos
	$SUBIR_FOTOS = false;
	if (strpos($_SERVER['PHP_SELF'], "subirfotos") !== false)
		$SUBIR_FOTOS = true;

// Vemos si el alta viene del CRUD	
	$FORM_CRUD = false;
	if (isset($_GET["crud"]))
		$FORM_CRUD = true;
	
// Ruta aplicacion
	if ($LOCALHOST) {
		//$path = "/control/";
		$path = "../";
	} else
		$path = "/";
	
// Ruta imagenes
	$pathImages = $path."images/";
	
// Rutas html para emails e informes
	$rutaHTML1 = "http://".$_SERVER["HTTP_HOST"]."/formulario-registro/";				
	$rutaHTML2 = "http://".$_SERVER["HTTP_HOST"]."/formulario-registro/images/";				

// Ruta upload
	if ($LOCALHOST) {
		$ds = DIRECTORY_SEPARATOR;
		$rutaUpload = str_replace("php","",getcwd());
		$rutaUpload .= "/images/upload/";
		//$rutaUpload = str_replace("/", $ds, dirname(__FILE__).$rutaUpload);
	} else {	
		$rutaUpload = substr($path,1)."/images/upload/";
		$rutaUpload = $_SERVER['DOCUMENT_ROOT'].$rutaUpload;
	}
	//echo $rutaUpload."<br>";
	
// Ruta logs
	if ($LOCALHOST)
		$rutaLog = "../../../";
	else
		$rutaLog = $_SERVER['DOCUMENT_ROOT'];

// valores globales
	$alto = 600;	

// mostramos errores en pantalla
	ini_set('display_errors', 1);
	
// definimos horario
	date_default_timezone_set("Europe/Madrid");

?>