<?php
	ob_start();
	session_start();

	$DEPURAR = false;
	$v = "s";
	$operacion = "insert";
	$FORM_ALTA = true;
	$EVITAR_CONTROL = false;

	include "includes/cabecera.php";
	if ($verCabecera)
		include "includes/cabecera_menu.php";
	 
	$tipoListado = "Cliente";
	if (!isset($campos))
		include "includes/crud/campos.php";

// Filtramos si el formulario se muestra limpio o con cabecera
	$VER_CABECERAFORM = true;
	if (isset($_GET["cabForm"]) && $_GET["cabForm"] == "n")
		$VER_CABECERAFORM = false;

// Recogemos campos del email de invitación	
	if (isset($_GET["campo"]))
		$_COOKIE["campo"] = $_GET["campo"];
	
	if (isset($_GET["valor"]))
		$_COOKIE["valor"] = $_GET["valor"];

// Cogemos valores de las cookies	
	if (isset($_COOKIE["campo"])) {
		$aux1 = explode(",", $_COOKIE["campo"]);
		if ($DEPURAR)
   			echo "cookie 'campo': ".$_COOKIE["campo"]."<br>";
	}
	if (isset($_COOKIE["valor"])) {
   		$aux2 = explode(",", $_COOKIE["valor"]);
		if ($DEPURAR)
			echo "cookie 'valor': ".$_COOKIE["valor"]."<br>";
	}
?>
<?php if (!$FORM_CRUD) { ?>
<br>
<div style="max-width: 600px;margin:0px auto">
	<div<?php if ($VER_CABECERAFORM) { ?> class="well"<?php }?>>
		<div class="text-center">
<?php if ($VER_CABECERAFORM) { ?>			
			<img src="<?=$pathImages?>config/log-<?=$nomEmpresa2?>1.png">
			<h3>Formulario de Alta</h3>
			<div style="text-align:left">
				Por favor, rellena tus <b>Datos de Contacto</b>. Al terminar el alta, <b>se enviará por email</b> una invitación para crear la contraseña.
			</div>	
<?php } ?>
			<br/>
<?php } ?>
<?php include "includes/crud/form.php"; ?>
<?php include "includes/crud/form_check.php"; ?>
<?php if (!$FORM_CRUD) { ?>
		</div>
	</div>
</div>
<?php } ?>
<?php if (isset($_COOKIE["campo"])) { ?>
	<?php 
		$numPoblacion = 1;
		$numProvincia = 1;
		$cadena = "";
		for ($i=0; $i<count($aux1); $i++) { 
			$campo = trim($aux1[$i]);
			$valor = trim($aux2[$i]);
			$cadena .= "	objForm.".$campo.".value = ".$valor.";\n";
		}	
	?>			
<script>
	objForm = document.form1;
	<?=$cadena?>
</script>
<?php } ?>	

<?php include "includes/modal/modal_form.php"; ?>
<?php include "includes/pie.php"; ?>
<?php ob_end_flush(); ?>