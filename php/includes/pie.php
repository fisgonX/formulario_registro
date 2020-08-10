<?php if ($verCabecera) { ?>
	<?php if (strpos($_SERVER["REQUEST_URI"], "acceso_form.php") === false && strpos($_SERVER["REQUEST_URI"], "password_") === false) { ?>
	<div class="text-right panel-footer">
		<div class="row">
			<div class="col-sm-3 usuario" style="text-align:left"></div>
			<div class="col-sm-9">@<?=$nomEmpresa1?> <?=date("Y")?></div>
		</div>
	</div>
</div>
	<?php } ?>
<?php } ?>
</div>
</body>
</html>
<?php mysqli_close($conn); ?> 