	<div class="modal" id="new-article">
		<div class="modal-title">
			<h2>Nuevo articulo</h2>
			<a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>
			<span class="line-h">&nbsp;</span>
		</div>
		<div class="modal-content cols cols-1">
			<div class="modal-col modal-col-span1 first-col last-col">
				<div class="modal-col-inner">
					<h3>Registrar un nuevo articulo</h3>
					<span class="line-h">&nbsp;</span>
					<form action="/categorias/index.php?<?php echo $_SERVER["QUERY_STRING"] ?>" enctype="multipart/form-data" method="POST" id="article-create-new">
						<div class="hidden-values" style="display: none;">
							<input type="hidden" name="type" value="article">
							<input type="hidden" name="id" id="id">
							<input type="hidden" name="save" id="save">
						</div>
						<div class="form-line">
							<label for="orden">Orden</label>
							<input type="text" class="input" id="orden" value="0" name="orden" style="width: 25px; float: left; margin-left: 15px;">
						</div>
						<div class="form-line">
							<label for="nuevo" style="margin-right: 12px;">Es Nuevo?</label>
							<input type="checkbox" id="nuevo" name="nuevo" style="margin-top: 12px;">
						</div>
						<div class="form-line">
							<label for="agotado" style="margin-right: 12px;">Está Agotado?</label>
							<input type="checkbox" id="agotado" name="agotado" style="margin-top: 12px;">
						</div>
						<div class="form-line">
							<label for="oferta" style="margin-right: 12px;">Está en Oferta?</label>
							<input type="checkbox" id="oferta" name="oferta" style="margin-top: 12px;">
						</div>
						<div class="form-line">
							<label for="surtido" style="margin-right: 12px;">Vender Surtido</label>
							<input type="checkbox" id="surtido" name="surtido" style="margin-top: 12px;">
						</div>
						<div class="form-line">
							<label for="nombre">Nombre</label>
							<input type="text" class="input" id="nombre" name="nombre">
						</div>
						<div class="form-line">
							<label for="codigo">Código</label>
							<input type="text" class="input" id="codigo" name="codigo">
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
							<label for="precio">Precio</label>
							<input type="text" class="input" id="precio" name="precio" value="0">
						</div>
						<div class="form-line">
							<label for="precio_oferta">Precio de oferta</label>
							<input type="text" class="input" id="precio_oferta" name="precio_oferta" value="0">
						</div>
						<div class="form-line">
							<label for="precio_surtido">Precio unitario surtido</label>
							<input type="text" class="input" id="precio_surtido" name="precio_surtido" value="0">
						</div>
						<div class="form-line">
							<label for="precio_oferta_surtido">Precio surtido de oferta</label>
							<input type="text" class="input" id="precio_oferta_surtido" name="precio_oferta_surtido" value="0">
						</div>
						<div class="form-line">
							<p style="margin-bottom: 0; margin-left: 215px;">Ingresa los talles separados por coma (,)<br/>Ej: S, M, L</p>
							<label for="talle">Talles</label>
							<input type="text" class="input" id="talle" name="talle">
						</div>
						<!--<div class="form-line">
							<label for="talle" style="margin-right: 12px;">Talle Adaptable?</label>
							<input type="checkbox" id="adaptable" name="adaptable" style="margin-top: 12px;">
						</div>-->
						<div class="form-line">
							<label for="packs">Packs</label>
							<input type="text" class="input" id="packs" name="packs">
						</div>
						<div class="form-line">
							<label for="imagen">Imagen</label>
							<input type="file" class="input" id="imagen" name="imagen">
						</div>
						<!--<div class="form-line">
							<label for="colores">Colores</label>
							<input type="file" class="input" id="colores" name="colores">
						</div>-->
						<div class="form-line">
							<label for="colores">Colores</label>
							<input type="file" class="input" id="colores" name="colores[]" multiple="true">
						</div>
						<div class="form-line">
							<label for="categoria_id">Categoría</label>
							<select name="categoria_id" id="categoria_id" class="input">
								<option value="0" <?php echo ($category->id == 0) ? 'selected' : '' ; ?>>-- Sin Categoría --</option>
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