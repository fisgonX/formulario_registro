<?php 
	$dominioFROM = str_replace("www.","",$dominioEmpresa);
	if (!isset($emailFROM)) {
		$emailFROM = $emailEmpresa;
		$nameFROM = $fromEmpresa;
		$emailREPLY = "no-responder@".$dominioFROM;
	} else
		$emailREPLY = "";

	function enviarEmail($emailTO, $asunto, $mensaje, $emailCC, $emailBCC)
	{
		global $emailFROM, $nameFROM, $emailREPLY, $dominioFROM, $DEPURAR, $emailEmpresa, $nomEmpresa1, $nomEmpresa2, $rutaHTML2, $LOCALHOST, $TIPO_EMAIL, $datosHOST1, $datosHOST2;
	// Detectamos emailTO si enviamos por hotmail o normal	
		if ($DEPURAR)
			echo $TIPO_EMAIL."<br>";
		if (strpos($emailTO, "@hotmail") !== false)
			$TIPO_EMAIL = 2;
		$TIPO_EMAIL = 1;
		if ($DEPURAR)
			echo $emailTO."<br>".strpos($emailTO,"@hotmail")."<br>TIPO_EMAIL: ".$TIPO_EMAIL."<br>";
		
		$mensaje = "<html>
							<head>
								<title>".$asunto."</title>
								<style>
									h3 {
										color:green;
									}
									small {
										font-family: sans-serif;
										font-style: italic;
										font-size: 12px;
										color: #808080;
									}
									.cajaMail {
										font-family: sans-serif;
										font-size: 13px;
										background-color: #F5F5F5;
										padding:20px;
										border-radius: 5px 5px 5px 5px;
										-moz-border-radius: 5px 5px 5px 5px;
										-webkit-border-radius: 5px 5px 5px 5px;
										border: 1px solid #E3E3E3;
									}	
								</style>	
							</head>
							<body>
								<div class='cajaMail'>
								<img src='".$rutaHTML2."config/log-".$nomEmpresa2."1.png'>
								".$mensaje."
								</div>
								<br/>
								<small><font color='00C000'>Antes de imprimir este mensaje, por favor, comprueba que es necesario. Una tonelada de papel implica la tala de 15 árboles y el consumo de 250.000 litros de agua. El Medio Ambiente es cuestión de TODOS.</font><br><br>\n
					 			En cumplimiento de la Ley Orgánica 15/1999, de Protección de Datos de Carácter Personal, te informamos que los datos personales, que puedan constar en este e-mail, están incorporados en un fichero cuyo responsable es ".strtoupper($nomEmpresa1)." con la finalidad de gestionar la relación, negociar e informarte sobre nuestros productos y servicios. Si deseas ejercitar los derechos de acceso, rectificación, cancelación u oposición, deberás dirigirse por escrito a: ".strtoupper($nomEmpresa1)."<br><br>\n
					 			Este mensaje va dirigido exclusivamente a su destinatario y puede contener información confidencial y sujeta al secreto profesional, cuya divulgación no está permitida por la ley. En caso de haber recibido este mensaje por error, rogamos que nos lo comuniques inmediatamente por e-mail a ".$emailEmpresa.". La distribución, copia o utilización de este mensaje, o de cualquier documento adjunto, sin autorización están prohibidas por ley.\n
								</small>
							</body>
						</html>";

		if ($TIPO_EMAIL == 1) {																					// MAIL DE PHP
			$aux = explode("|", $datosHOST1);
			ini_set('SMTP',$aux[0]);
			ini_set('smtp_port',$aux[1]);
			$headers  = "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-type: text/html; charset=utf-8\r\n"; 
			$headers .= "From: ".$nameFROM." <".$emailFROM.">\r\n"; 
			if ($emailREPLY != "")																				//dirección de respuesta si es distinta que el FROM 
				$headers .= "Reply-To: ".$emailREPLY."\r\n";      					                
			$headers .= "Return-path: ".$emailFROM."\r\n";                                   //ruta del mensaje desde origen a destino  
			if (isset($emailCC))                                                             //direcciones CC 
				$headers .= "Cc: ".$emailCC."\r\n"; 
			if (isset($emailBCC))                                                            //direcciones BCC 
				$headers .= "Bcc: ".$emailBCC."\r\n"; 
			
			if ($DEPURAR) {
				echo "FROM: ".$nameFROM." &lt;".$emailFROM."&gt;<br>";
				echo "TO: ".$emailTO."<br>";
				echo "CC: ".$emailCC."<br>";
				echo "BCC: ".$emailBCC."<br>";
				echo "ASUNTO: ".$asunto."<br><br>"; 
				echo $mensaje;
			} else {
				if ($LOCALHOST)
					echo "<script>alert('En LOCALHOST no se envia el email');</script>";
					//mail ($emailTO, $asunto, $mensaje, $headers); 
				else	
					mail ($emailTO, $asunto, $mensaje, $headers); 
			}
		} else {																										// PHPMAILER
			include "../bower_components/PHPMailer/class.phpmailer.php";
			$aux = explode("|", $datosHOST2);
			$auth = $aux[0];
			$host = $aux[1];
			$port = $aux[2];
			$protocolo = $aux[3];
			$username = $aux[4];
			$password = $aux[5];

			$mail = new PHPMailer();																			// crear instancia
			$mail->Organization = $dominioFROM;
			$mail->ContentTransferEncoding = "8bit";
			$mail->MessageID = "<".md5(uniqid(time()))."@".$dominioFROM.">";
			$mail->XMSmailPriority = "Normal";
			$mail->XMailer = "Microsoft Office Outlook, Build 11.0.5510";
			$mail->XMimeOLE = "Produced By Microsoft MimeOLE V6.00.2800.1441";
			$mail->XSender = $mail->Sender;
			$mail->XAntiAbuse = "This is a solicited email for - ".$dominioFROM." mailing list.";
			$mail->XAntiAbuse = "Servername - {$dominioFROM}";
			$mail->XAntiAbuse = $mail->Sender;

			$mail->CharSet = "UTF-8";
			if ($auth) {
				$mail->isSMTP();
				$mail->SMTPDebug  = 1;																			// modo depuracion (0 - off, 1 - cliente, 2 - cliente y servidor)
			}	
			$mail->Host = $host;																					// servidor smtp
			$mail->Port = $port;																					// puerto smtp
			$mail->SMTPSecure = $protocolo;																	// definimos seguridad (tls o ssl)

			if ($auth) {
				$mail->SMTPKeepAlive = true;
				$mail->SMTPAuth = true;																			// usar servidor autenticado
				$mail->AuthType = "LOGIN";
				$mail->Username = $username;																	// cuenta de envio	
				$mail->Password = $password; 																	// password de envio
		 	}
			$mail->Subject = $asunto;
			$mail->Body = $mensaje;
			$mail->From = $emailFROM;
			$mail->FromName = $nameFROM;
			$mail->IsHTML(true);

			$mail->AddAddress($emailTO);																		// agregamos destinatarios
			if (isset($emailCC) && $emailCC != "")
				$mail->addCC($emailCC);
			if (isset($emailBCC) && $emailBCC != "")
		      $mail->addBCC($emailCC);
			if ($DEPURAR) {
				echo "FROM: ".$nameFROM." &lt;".$emailFROM."&gt;<br>";
				echo "TO: ".$emailTO."<br>";
				echo "CC: ".$emailCC."<br>";
				echo "BCC: ".$emailBCC."<br>";
				echo "ASUNTO: ".$asunto."<br><br>"; 
				echo $mensaje;
			} else {
				if ($LOCALHOST)
					echo "<script>alert('En LOCALHOST no se envia el email');</script>";
				else
					$mail->Send();
			}
		}
	}

	function generarLinkTemporal($idusuario, $email)
	{
		global $hostBBDD, $userBBDD, $pwdBBDD, $nomBBDD, $DEPURAR, $rutaHTML1;
		$conn = new mysqli($hostBBDD, $userBBDD, $pwdBBDD, $nomBBDD); 
		$cadena = $idusuario.$email.rand(1,9999999).date('Y-m-d');                      // se genera una cadena para validar el cambio de contrase?
		$token = sha1($cadena);

	// Se borra los registros del usuario anterior
		$strSQL = "DELETE FROM usuarios_resetpass WHERE idusuario = ".$idusuario;
		$rs = ejecutarQUERY($strSQL);

	// Se inserta el registro en la tabla tblreseteopass
		$strSQL = "INSERT INTO usuarios_resetpass (idusuario, email, token, creado) VALUES (".$idusuario.",'".$email."','".$token."',NOW())";
		$rs = ejecutarQUERY($strSQL);

	// Se devuelve el link que se enviara al usuario
		$enlace = $rutaHTML1."php/password_reestablecer.php?idusuario=".sha1($idusuario)."&token=".$token;
		if ($DEPURAR)
			echo $enlace."<br>";
		return $enlace;
	}
?>