			</div>
			<div><a style="color:#fff" href="index.php">Mico web design by Jorge Ballano</a><br></div>
	    	</div>
	    </div>
	</div>
	<div class="modal fade" id="modal_error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog login" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				      	<div id="formulari">
							<form method='POST' action='registro.php?cont=0'>
								<?php echo '<div class="form-inline"> '.$_COOKIE["error"].' </div>';?>								
							<button type="button" class="btn btn-secondary botonLogin" data-dismiss="modal">Aceptar</button>
							</form>							
						</div>						
				      </div>
				    </div>
				  </div>
				</div>
</div>
<script src="js/jquery-3.1.1.js"></script>
<script src="js/bootstrap.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/samples/js/sample.js"></script>
<script src="js/main.js"></script>
<script src="js/js-cookie.js"></script>
<script type="text/javascript" src="fancybox-3.0/dist/jquery.fancybox.min.js?v=2.1.5"></script>
</script>
</body>
</html>