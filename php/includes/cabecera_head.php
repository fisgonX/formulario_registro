<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES" xml:lang="es-ES">
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
	<meta http-equiv="Pragma" content="no-cache">
	<meta name="robots" content="noindex"/>
	<script>ruta = "<?=$path?>";</script>
	<script src="<?=$path?>bower_components/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
	<script src="<?=$path?>bower_components/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?=$path?>js/funciones.js" type="text/javascript"></script>
	<script src="<?=$path?>bower_components/jquery/jquery.validate.min.js"></script>
	<script src="<?=$path?>bower_components/pselect/pselect.js" type="text/javascript"></script>
	<link href="<?=$path?>bower_components/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>      
	<link href="<?=$path?>css/estilo.css" rel="stylesheet" type="text/css"/>  
	<link href="<?=$path?>css/estilo_config.php" rel="stylesheet" type="text/css"/>  
	<link href="<?=$path?>css/input_checkbox.css" rel="stylesheet" type="text/css"/>  
	<link rel="shortcut icon" href="<?=$pathImages?>config/favicon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$nomEmpresa1?> - Formulario de Alta</title>
<?php if ($TEST_RESPONSIVE) { ?>
	<script>alert (window.innerWidth);</script>
<?php } ?>  
<style type="text/css">
   body { Background: transparent; }
</style>
</head>
<body>
<?php if (strpos($_SERVER["REQUEST_URI"], "password_") === false) { ?>
<div class="container-fluid">
	<?php if (strpos($_SERVER["REQUEST_URI"], "acceso_form.php") === false && $verCabecera) { ?>
	<br>
	<div class="panel panel-default">
	<?php } ?>  
<?php } ?>
	