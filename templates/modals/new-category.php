	<div class="modal" id="new-category">
		<div class="modal-title">
			<h2>Nueva categoría</h2>
			<a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>
			<span class="line-h">&nbsp;</span>
		</div>
		<div class="modal-content cols cols-1">
			<div class="modal-col modal-col-span1 first-col last-col">
				<div class="modal-col-inner">
					<h3>Registrar una nueva categoría</h3>
					<span class="line-h">&nbsp;</span>
					<form action="/categorias/index.php?<?php echo $_SERVER["QUERY_STRING"] ?>" enctype="multipart/form-data" method="POST" id="category-create-new">
						<div class="hidden-values" style="display: none;">
							<input type="hidden" name="type" value="category">
							<input type="hidden" name="id" id="id">
							<input type="hidden" name="save" id="save">
						</div>
						<div class="form-line">
							<label for="orden">Orden</label>
							<input type="text" class="input" id="orden" value="0" name="orden" style="width: 25px; float: left; margin-left: 15px;">
						</div>
						<div class="form-line">
							<label for="titulo">Titulo</label>
							<input type="text" class="input" id="titulo" name="titulo">
						</div>
						<div class="form-line">
							<label for="descripcion_breve">Descripción breve</label>
							<input type="text" class="input" id="descripcion_breve" name="descripcion_breve">
						</div>
						<div class="form-line">
							<label for="descripcion">Descripción</label>
							<textarea class="input" id="descripcion" name="descripcion"></textarea>
						</div>
						<div class="form-line">
							<label for="imagen">Imagen</label>
							<input type="file" class="input" id="imagen" name="imagen">
						</div>
						<div class="form-line">
							<label for="categoria_id">Categoría padre</label>
							<select name="categoria_id" id="categoria_id" class="input">
								<option value="0" <?php echo ($category->id == 0) ? 'selected' : '' ; ?>>-- No tiene padre --</option>
								<?php

								foreach($categories as $cat) {

									?>
									<option value="<?php echo $cat->id; ?>" <?php echo ($category->id == $cat->id) ? 'selected' : '' ; ?>><?php echo $cat->titulo; ?></option>
									<?php

								}

								?>
							</select>
						</div>
						<div class="form-line form-commands">
							<button type="submit" class="btn btn-style bnt-login black">Guardar</button>
							<button type="button" class="btn btn-style bnt-login grey action-close">Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>