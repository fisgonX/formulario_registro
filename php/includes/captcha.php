<?php if (!$LOCALHOST) { ?>
<script type="text/javascript">
	var widgetId1;
	var onloadCallback = function() {
		widgetId1 = grecaptcha.render('captcha1', {
			'sitekey' : '<?=$keyCAPTCHA?>',
		});
	};
</script>
<div id="captcha1" class="centrar2" style="margin: 5px 0 5px 0"></div>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=es" async defer></script>
<?php } ?>