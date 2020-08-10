<?php
	session_start();

	$DEPURAR = false;
	
	include "includes/cabecera.php";

	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$idusuario = $_POST['idusuario'];
	$token = $_POST['token'];
?>
<br><br>
<div style="max-width: 420px;margin:0px auto">
	<div class="well">
		<div class="text-center">
			<img src="<?=$pathImages?>config/log-<?=$nomEmpresa2?>1.png">
			<h3>Activar cuenta</h3>
		</div>
		<br><br>	
<?php
	if ($password1 != "" && $password2 != "" && $idusuario != "" && $token != "") {
		$strSQL = "SELECT * FROM usuarios_resetpass WHERE token = '".$token."'";
		$rs = ejecutarQUERY($strSQL);
		if ($rs->num_rows > 0) {
			$usuario = $rs->fetch_assoc();
			if (sha1($usuario['idusuario'] === $idusuario)) {
				if ($password1 === $password2) {
					$strSQL = "UPDATE clientes SET password = '".sha1($password1)."' WHERE id = ".$usuario["idusuario"];
					$rs = ejecutarQUERY($strSQL);
					if ($rs) {
						$strSQL = "DELETE FROM usuarios_resetpass WHERE token = '".$token."'";
						$rs = ejecutarQUERY($strSQL);
?>
	  <p class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> La contraseña se actualizó con exito</p>
			<?php } else { ?>
		<p class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span> Ocurrió un error al actualizar la contraseña, intentalo más tarde </p>
			<?php } ?>
		<?php } else { ?>
		<p class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span> Las contraseñas no coinciden</p>
		<?php } ?>
	<?php } else { ?>
		<p class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span> El token no es válido</p>
	<?php }
		} else {
?>
		<p class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span> El token no es válido </p>
<?php
		}
?>
		<br><br>
		<div class="centrar2">
			<button id="btn_volver" type="button" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-chevron-left"></span> Volver</button>
		</div>
	</div>
</div>
<p class="text-center"><small>© Copyright <?=date("Y")?> - <?=$nomEmpresa1?></small></p>
<script>
	$(document).ready(function () {
		$('#btn_volver').click(function () {
			window.location = "<?=$path?>";
		});
	});
</script>
<?php
	} else {
		header('Location:'.$path);
	}
	include "includes/pie.php";
?>