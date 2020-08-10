<?php
	$strSQL = "SELECT MAX(id) AS idusuario FROM ".$nomTabla;
	$rs = ejecutarQUERY($strSQL);
	if ($row = $rs->fetch_assoc()) {
		$idUsuario = $row["idusuario"];

		$linkTemporal = generarLinkTemporal($idUsuario, $emailUsuario);
	
	// Preparamos email envio
		$asunto = "Invitacion para activar tu acceso";
		$mensaje = "<p>Has recibido una invitación para activar tu cuenta. Recuerda que el login será tu email</p>
						<p>
							<a href='".$linkTemporal."''>Pulsa en este enlace para <b>ACTIVAR TU ACCESO</b></a> y generar una nueva contraseña
					 	</p>";
		
		enviarEmail($emailUsuario, $asunto, $mensaje, "", "");
	}
?>