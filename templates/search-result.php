					<style>
					#body .body-content {
						padding: 20px 0!important;
					}
					.lista-articulos {
						width: 100%;
						float: none;
					}
					</style>
					<div class="lista-articulos">
						<span class="line-h margin-bottom"></span>
						<?php

						foreach($resultado as $art) {

						?>

						<div class="item-articulo">
							<div class="item-articulo-inner">
								<div class="item-articulo-imagen">
									<!-- <a href="/articulos?a=<?php echo $art->id; ?>"> -->
									<img src="<?php echo ($art->imagenes_url != '') ? str_replace("{id}", $art->id, $art->imagenes_url) . "thumbnail.jpg"  : '/statics/images/noimage.jpg'; ?>">
									<!-- </a> -->
									<?php
									if ($art->nuevo == 1 && $art->agotado != 1) {

									?>
									<!-- <span style="font-weight: bold; font-size: 14px; z-index: 10; width: 50px; -webkit-transform: rotate(-45deg); transform: rotate(-45deg); border-left: 35px solid transparent; border-right: 35px solid transparent; color: rgb(255, 255, 255); height: 0px; left: -30px; line-height: 36px; position: absolute; text-align: center; border-bottom: 35px solid #FFAA00; top: 12px;">NUEVO</span> -->
									<span><img src="/statics/images/nuevo.png"></span>
									<?php

									}
									if ($art->agotado == 1) {
										
									?>
									<!-- <span style="font-weight: bold; font-size: 10px; z-index: 10; width: 50px; -webkit-transform: rotate(-45deg); transform: rotate(-45deg); border-left: 35px solid transparent; border-right: 35px solid transparent; color: rgb(255, 255, 255); height: 0px; left: -30px; line-height: 36px; position: absolute; text-align: center; border-bottom: 35px solid #FF0000; top: 12px;">AGOTADO</span> -->
									<span><img src="/statics/images/agotado.png"></span>
									<?php

									}
									?>
									<!-- <span style="display: none;"><?php echo $art->nuevo . ' ' . $art->agotado; ?></span> -->
								</div>

								<?php
								if ($userStats['user'] && $userStats['user']->administrador == 1) {

									?>

									<div class="admin-article-cmds">
										<span class="admin-article-cmd cmd-edit" data-id="<?php echo $art->id; ?>" data-nombre="<?php echo $art->nombre; ?>" data-codigo="<?php echo $art->codigo; ?>" data-descripcion_breve="<?php echo $art->descripcion_breve; ?>" data-descripcion="<?php echo $art->descripcion; ?>" data-precio="<?php echo $art->precio; ?>" data-talle="<?php echo $art->talle; ?>" data-packs="<?php echo $art->packs; ?>" data-categoria_id="<?php echo $art->categoria_id; ?>" data-orden="<?php echo $art->orden; ?>">Editar</span>
										<span class="admin-article-cmd cmd-delete" data-id="<?php echo $art->id; ?>"  data-nombre="<?php echo $art->nombre; ?>">Eliminar</span>
									</div>

									<?php

								}
								?>
								<?php
								if ($art->colores_url != "") {
								?>

								

								<?php
								}
								?>
								<div class="item-articulo-info">
									<!-- <div class="item-articulo-titulo"> -->
										<!-- <a href="/articulos?a=<?php echo $art->id; ?>"> -->
											<?php //echo $art->nombre; ?> <!-- (<strong><?php echo $art->codigo; ?></strong>) -->
										<!-- </a> -->
									<!-- </div> -->
									<div class="item-articulo-description-line item-articulo-nombre">
										<!-- <span class="info-label">Artículo:</span> -->
										<span class="info-value" style="font-size: 14px; color: #666"><?php echo $art->nombre; ?></span>
									</div>
									<div class="item-articulo-description-line item-articulo-codigo">
										<span class="info-label">Artículo:</span>
										<span class="info-value"><?php echo $art->codigo; ?></span>
									</div>
									<div class="item-articulo-description-line item-articulo-precio">
										<span class="info-label">Precio por mayor:</span>
										<span class="info-value">$ <?php echo $art->precio; ?> c/u</span>
									</div>
									<div class="item-articulo-description-line item-articulo-packs">
										<span class="info-label">Packs: </span>
										<span class="info-value"><?php echo $art->packs; ?></span>
									</div>
									<div class="item-articulo-description-line item-articulo-talles">
										<span class="info-label">Talles: </span>
										<span class="info-value"><?php echo $art->talle; ?></span>
									</div>
									<div class="item-articulo-description-line item-articulo-colores">
										<span class="info-label">Colores:</span>
										<span class="info-value">
											<img src="<?php echo str_replace("{id}", $art->id, $art->colores_url); ?>colors.jpg">
										</span>
									</div>
									<div class="item-articulo-description-line item-articulo-acciones">
										<?php
										if ($userStats['user']) {
										?>
										<div class="accion-comprar">
											<?php

											if ($art->agotado != 1) {
										
											?>

											<label>
												Ingrese cant. de packs: <input type="text" value="1" class="input vsmall-input packs-cantidad">
											</label>
											<a href="#" class="btn btn-style black add-to-cart" data-id="<?php echo $art->id; ?>">Agregar al pedido<span class="fa fa-shopping-cart"></span></a>

											<?php

											} else {

											?>

											<label>
												Ingrese cant. de packs: <input type="text" value="1" disabled="true" class="input vsmall-input packs-cantidad">
											</label>
											<a href="#" class="btn btn-style grey" data-id="<?php echo $art->id; ?>">Artículo agotado<span class="fa fa-shopping-cart"></span></a>

											<?php

											}

											?>
										</div>
										<?php
										} else {
										?>
										<div class="accion-registrar">
											<a href="/registro" class="btn btn-style black">Registrarme</a>
										</div>
										<?php
										}
										?>
									</div>
								</div>
							</div>
						</div>
						<?php

						}

						?>
						
						<div style="clear: both"></div>
					</div>