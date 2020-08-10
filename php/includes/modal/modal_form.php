<!-- MODAL IFRAME //-->
<div class="modal fade" id="myModal" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-lg modal-ventana">
		<a href="#" id="cerrarModal" data-dismiss="modal" title="cerrar ventana"><img src="<?=$path?>images/crud/btn-cerrar.png" width="20" border="0" vspace="10"></a>
		<div class="modal-content">
			<div class="modal-body">	
				<iframe id="frame_modal" src="" style="zoom:0.60" width="100%" height="100%" frameborder="0"></iframe>
			</div>
		</div>
	</div>
</div>
<script>
	$("#cerrarModal").click(function (e) {
 		e.preventDefault(); 		//Cancel the link behavior
 		cerrarModal();
		//$("#myModal").hide();
	});
</script>
