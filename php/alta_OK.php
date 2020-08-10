<?php 
	session_start();

	$v = "s";
	include "includes/cabecera.php";
?>
<br><br>
<div style="max-width: 420px;margin:0px auto">
	<div class="well">
		<div class="text-center">
			<img src="<?=$pathImages?>config/log-<?=$nomEmpresa2?>1.png">
			<h3>Formulario de Alta</h3><br>
<?php if ($_GET["respuesta"] == "0") { ?>
			<div class="alert alert-success text-center" role="alert">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				Tu solicitud <b>ha sido recibida correctamente</b><br><br>
				Por favor, revisa tu email para confirmar la inscripción y poder generar una contraseña<br><br>
				Muchas gracias por confiar en nosotros
			</div>
<?php } else { ?>
			<div class="alert alert-danger text-center" role="alert">
				<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
				Ya tenemos tus datos en nuestra Base de Datos<br><br>
				El NIF o el EMAIL indicado <b>ya existe</b><br><br>
			</div>
			<form>
				<button type="button" class="btn btn-info btn-lg" onClick="history.go(-1)"><span class='glyphicon glyphicon-arrow-left'></span> Volver al formulario</button>
			</form>
<?php } ?>
		</div>
	</div>
	<p class="text-center"><small>© Copyright <?=date("Y")?> - <?=$nomEmpresa1?></small></p>
</div>
<?php include "includes/pie.php"; ?>
