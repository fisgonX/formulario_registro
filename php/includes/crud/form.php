 <?php
	$valor[0] = ""; 
	$VER_BOTONPDF = true;
	$VER_BOTONIMPRIMIR = false;
	$VER_CABECERACAJA = false;
	if (!$FORM_ALTA && !$FORM_CONTACTO)
		$VER_CABECERACAJA = false;

	$idCliente = "";
	$txtOcultar = 1;                          // valor 1 para ocultar campo hidden o mostrarlo (modo consulta)
	if ($operacion == "update" || $operacion == "consulta") {
		if (isset($_GET["id"]))
			$id = $_GET["id"];
	
		if ($operacion == "update" && $tipoListado == "Cliente")
			$nomTabla = $nomTabla;
		else {
			if ($nomVista != "")
				$nomTabla = $nomVista;
		}
		$strSQL = "SELECT * FROM ".$nomTabla." WHERE id = ".$id;
		if ($USER_DELEGADO && ($tipoListado == "Evento" || $tipoListado == "Cliente"))
			$strSQL .= " AND idusuario = ".$_COOKIE["id"];
		//echo $strSQL;
		$rs2 = ejecutarQUERY($strSQL);
		$num = 1;
		$baja = false;
		$pdfContrato = "";
		
		$campoSQL = "";
		$valorSQL = "";
		while ($row = $rs2->fetch_assoc()) {
			for ($x=1; $x<=count($campos); $x++) {
				if (isset($campos[$x])) {
					//echo $x.": ".$campos[$x]."<br>";
					$txtCampo = $campos[$x];
					$txtCampo = limpiarCampo($txtCampo);
					$valor[$num] = $row[$txtCampo];
					if ($valor[$num] == "NOW()")
						$valor[$num] = "";
					if ($txtCampo == "telefono")
						$telefono = $valor[$num];
					$num++;
				}		
			}
		}
		$msg = "";
		if ($num == 1)  
			redirigir($linkInicio, "");
			//header("Location: ".$linkInicio);
	} else
		$operacion = "insert";  
	$txtAction = "update.php";
	$txtOperacion = $operacion;
	if ($FORM_ALTA) {
		$txtAction = "alta_update.php";
		if ($FORM_CRUD) {
			$txtAction .= "?crud=s";
			$tipoListado = "Evento";
		} else
			$txtOperacion = "alta";
	}
	if ($operacion == "consulta" && $tipoListado == "Contacto") {
		$strSQL = "UPDATE ".$nomTabla." SET leido = 1 WHERE id = ".$id;
		$rs2 = ejecutarQUERY($strSQL);
	}
?>
<div id="ficha" class="panel panel-default">
<?php	if ($VER_CABECERACAJA) { ?>
	<div class="panel-heading cabecera_caja"><?=$txtTitular?></div>
<?php } ?>
	<div class="panel-body">
		<form name="form1" method="POST" role="form" id="register-form" action="<?=$txtAction?>" autocomplete="off">
			<a name="CONTACTO"></a>
			<h4 style="text-align:left">Datos de Contacto</h4>
			<input type="hidden" name="id" value="<?=$id?>">
<?php	if ($FORM_ALTA) { ?>			
			<input type="hidden" name="operacion" value="form_alta">
			<input type="hidden" name="tipo" value="form_alta">
<?php } else { ?>
			<input type="hidden" name="operacion" value="<?=$operacion?>">
			<input type="hidden" name="tipo" value="<?=$tipoListado?>">
<?php } ?>
			<div>
<?php
	$n1 = count($campos);
	for ($x=1; $x<=$n1; $x++) {  
		$txtCampo = "";
		if (isset($campos[$x]))
			$txtCampo = $campos[$x];
		
		if ($txtCampo != "") {
			$nomCampo = limpiarCampo($txtCampo);
			$txtCampo = limpiarCampoTxt($txtCampo);
			//echo $x."-".$nomCampo."<br>";
			$tipoCampo = $camposTipo[$x];
			$checkCampo = "";
			if (isset($check[$x]) && $operacion != "consulta")
				$checkCampo = $check[$x];
			$txtValor = "";
			if (isset($valor[$x]))
				$txtValor = $valor[$x];
			
			switch ($nomCampo) {
				case "fecha":
				case "fechaalta":
					mostrarCampo($nomCampo,$txtCampo,$txtValor,$txtOcultar,"",$tipoCampo,$checkCampo);
					break;

				default:
					//if ($nomCampo == "password")
					//	break;
					$txtSufijo = "";
					$txtCampoSM = "";
					if ($sufijo != "") {
						$aux = explode("|", $sufijo);
						for ($y=0; $y<count($aux); $y++) {
							if ($aux[$y] != "") {
								//echo $x." - ".$aux[$y]."<br>";
								$aux2 = explode("-",$aux[$y]);
								if ($aux2[0] == $x) {
									if ($aux2[1] != "")
										$txtCampoSM = " ".$aux2[1];
									if (isset($aux2[2]))
										$txtSufijo = $aux2[2];
								}
							}
						}
					}
					if ($nomCampo == "pais" && $txtValor == "")
						$txtValor = "España";

					mostrarCampo($nomCampo,$txtCampo,$txtValor,0,"",$tipoCampo,$checkCampo);
					break;
			}	
		}	
	}
?>
<?php if ($txtBoton != "") { ?>
			</div>
	<?php if ($operacion != "consulta" && !$IMPRIMIR) { ?>
			<div class="leyenda derecha separar_derecha">
				<span class="glyphicon glyphicon-asterisk rojo"></span> Campo obligatorio
	<?php if ($EVITAR_CONTROL) { ?>
				<br><span class="glyphicon glyphicon-asterisk gris"></span> Campo obligatorio (permisivo)
	<?php }?>		
			</div>
			<br>
			<div class="row">
		<?php if ($operacion != "insert") { ?>
				<div class="col-sm-12">
					<button type="submit" class="btn btn-success btn-lg btn-block"><span class='glyphicon glyphicon-pencil'></span>&nbsp;&nbsp;<?=$txtBoton?></button>	
				</div>
		<?php } else { ?>
				<div class="captcha">
				<?php  include "includes/captcha.php"; ?>					
				</div>
				<br/>
				<label class="checkbox centrar" style="width:94%">
					<input type="checkbox" name="condiciones" id="condiciones" value="s"/>
					<span class="check"></span>
					<span style="padding-left:10px">Al incluir mis datos en este formulario, declaro haber leído y aceptado las <a href="javascript:abrirVentanaModal(0,'condiciones','')"><b>Condiciones del Servicio</b></a> y la <a href="javascript:abrirVentanaModal(0,'politicaprivacidad','')"><b>Política de Privacidad</b></a></span>
				</label>		
				<br/>	
				<div class="col-sm-12">
			<?php if ($operacion == "insert") { ?>
				<?php if (($FORM_ALTA || $FORM_CONTACTO) && !$FORM_CRUD) { ?>
					<button type="submit" class="btn btn-success btn-lg btn-block"><span class='glyphicon glyphicon-list-alt'></span>&nbsp;&nbsp;<?=$txtBoton?></button>	
				<?php } else { ?>	
					<button type="submit" class="btn btn-success btn-lg btn-block"><span class='glyphicon glyphicon-plus'></span>&nbsp;&nbsp;<?=$txtBoton?></button>	
				<?php } ?>	
			<?php } else { ?>	
					<button type="submit" class="btn btn-success btn-lg btn-block"><span class='glyphicon glyphicon-pencil'></span>&nbsp;&nbsp;<?=$txtBoton?></button>	
			<?php } ?>	
				</div>
		<?php } ?>
			</div>
	<?php } ?>
<?php } ?>
		</form>
	</div>
</div>
<?php if ($IMPRIMIR) { ?> 
<script>
	window.print();
	top.location = "listados.php?tipo=<?=$tipoListado?>";
</script>
<?php } else { ?>	
 	<?php if ($tipoListado == "Contacto" && isset($campoSQL)) { ?>
		<?php
			$campoSQL = substr($campoSQL,0,strlen($campoSQL)-1);
			$valorSQL = substr($valorSQL,0,strlen($valorSQL)-1);
		?>	
<script>
	function realizarReserva()
	{
		window.location = "alta_form.php?crud=s&campo=<?=$campoSQL?>&valor=<?=$valorSQL?>";
	}
</script>
	<?php } ?>
	<?php if ($operacion == "insert" && (isset($VER_CABECERAFORM) && $VER_CABECERAFORM)) { ?> 
<script>focoPrimerCampo(document.forms[0]);</script>
	<?php } ?>
<script>
	<?php if ($operacion == "consulta") { ?> 
	function generarPDF(opcion)
	{
		url = "pdf_generar.php?id=<?=$_GET["id"]?>";
		if (opcion == "borrar")
			url = url+"&regenerar=s";
		//alert(url);
		window.location = url;
	}
	<?php } ?>
	<?php if ($operacion == "insert" || $operacion == "update") { ?> 
	webshim.setOptions('forms', {
		//show custom styleable validation bubble
		replaceValidationUI: true
	});

//start polyfilling
	webshim.polyfill('forms');

		<?php for ($x=1; $x<$n1; $x++) { ?>
			<?php
				$txtTipo = $camposTipo[$x];
				if ($txtTipo == "date") {
	   				$nomCampo = limpiarCampo($campos[$x]);
		?>
	anyHoy = <?=date("Y")?>;
	anyIni = anyHoy-2;
	anyFin = anyHoy+2;
	fechaHoy = anyHoy+",<?=date("n").",".date("j")?>";
	fechaAyer = anyIni+",<?=date("n").",".date("j")?>";
	var disable = false, picker = new Pikaday({
		field: document.getElementById('date_<?=$nomCampo?>'),
		firstDay: 1,
    	format: 'DD/MM/YYYY',
		minDate: new Date(fechaAyer),
		maxDate: new Date(anyFin, 12, 31),
		yearRange: [anyIni,anyFin]
	}); 
			<?php } ?>
		<?php } ?>
	<?php } ?>
<?php } ?>
</script>