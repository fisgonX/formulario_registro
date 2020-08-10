<?php
	session_start();

	$DEPURAR = true;
	
	include "includes/cabecera.php";

	$token = $_GET['token'];
	$idusuario = $_GET['idusuario'];
	
	$strSQL = "SELECT * FROM usuarios_resetpass WHERE token = '$token'";
	$rs = ejecutarQUERY($strSQL);
 
	if ($rs->num_rows > 0) {
   	$row = $rs->fetch_assoc();
		if (sha1($row['idusuario']) == $idusuario) {
?>
<br><br>
<div style="max-width: 420px;margin:0px auto">
 	<div class="well">
		<div class="text-center">
			<img src="<?=$pathImages?>config/log-<?=$nomEmpresa2?>1.png">
			<h3>Activar cuenta</h3>
		</div>
		<form id="form1" action="password_cambiar.php" method="post">
			<p></p>
			<div class="form-group">
				<label for="password"> Nueva contraseña </label>
				<input type="password" class="form-control" name="password1" included>
			</div>
			<div class="form-group">
				<label for="password2"> Confirmar contraseña </label>
				<input type="password" class="form-control" name="password2" included>
			</div>
			<input type="hidden" name="token" value="<?php echo $token ?>">
			<input type="hidden" name="idusuario" value="<?php echo $idusuario ?>">
			<div class="centrar2">
				<button class="btn btn-success btn-lg"><span class="glyphicon glyphicon-refresh"></span> Cambiar contraseña</button>
			</div>
		</form>
	</div>
</div>
<p class="text-center"><small>© Copyright <?=date("Y")?> - <?=$nomEmpresa1?></small></p>
<script>
	$(document).ready(function(){
		$("#form1").submit(function(event) {                  
			if (this.password1.value == "") {
				alert ("Por favor, introducir la NUEVA CONTRASEÑA");
				this.password1.focus();
				return false;
			}
			if (this.password2.value == "") {
				alert ("Por favor, confirmar la NUEVA CONTRASEÑA");
				this.password2.focus();
				return false;
			}
			if (this.password1.value != this.password2.value) {
				alert ("Las contraseñas introducidas NO COINCIDEN");
				this.password1.focus();
				return false;
			}
		});
	});
</script>
	<?php } else { ?>
		<?php if (!$DEPURAR) { ?>
<script>window.location = "<?=$path?>";</script>
		<?php } ?>
	<?php } ?>
<?php } else { ?>
	<?php if (!$DEPURAR) { ?>
<script>window.location = "<?=$path?>";</script>
	<?php } ?>
<?php } ?>
<?php include "includes/pie.php"; ?>
