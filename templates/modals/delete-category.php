	<div class="modal" id="delete-category">
		<div class="modal-title">
			<h2>Eliminando categoria <strong><span class="category-name"></span></strong></h2>
			<a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>
			<span class="line-h">&nbsp;</span>
		</div>
		<div class="modal-content cols cols-1">
			<div class="modal-col modal-col-span1 first-col last-col">
				<div class="modal-col-inner">
					<h3>Seguro que desea eliminar la categoría?</h3>
					<span class="line-h">&nbsp;</span>
					<form action="/categorias/index.php" enctype="multipart/form-data" method="POST" id="category-create-new">
						<div class="hidden-values" style="display: none;">
							<input type="hidden" name="type" value="category">
							<input type="hidden" name="id" id="id">
							<input type="hidden" name="delete" id="delete">
						</div>
						<div class="form-line form-commands">
							<button type="submit" class="btn btn-style bnt-login black">Eliminar</button>
							<button type="button" class="btn btn-style bnt-login grey action-close">Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>