			<div class="body-content shadow-5">
				<div class="lista-categorias">

							<li><a class="<?php echo ($category->id == 0) ? 'category-selected' : ''; ?>" href="/categorias">Ver todo</a></li>
						<?php
						foreach($categories as $cat) {

							?>
							<li><a href="/categorias?c=<?php echo $cat->id; ?>" class="<?php echo ($cat->titulo == $category->titulo) ? 'category-selected' : '' ?>"><?php echo $cat->titulo; ?></a></li>
							<?php

						}
						?>
						</ul>
						<a class="categoria-ofertas" href="/categorias?ofertas=1"><img src="/statics/images/ofertas.jpg" alt="Ofertas Monique"></a>
					</div>

					<div class="lista-subcategorias">
						<?php
						if ($category->descripcion_breve != '') {
						?>

						<h3 class="ubicacion-de-usuario">
							<a href="/" class="ubicacion-de-usuario-boton ubicacion-de-usuario-link primero">Inicio</a>
							<a href="/categorias/" class="ubicacion-de-usuario-boton ubicacion-de-usuario-link">Precios | Pedidos</a>
							<span class="ubicacion-de-usuario-boton ultimo">
								<?php echo ($category->id == 0) ? $category->titulo : $category->titulo; ?>
							</span>
							<span class="mensaje-envios">
								<span>Envios a todo el interior</span> <span class="fa fa-truck"></span>
							</span>
						</h3>
						<?php
						}
						if ($userStats['user'] && $userStats['user']->administrador == 1) {

							include($templatesPath . '/user/admin-cmds.php');

						}
						?>
						<?php

						foreach($category->subcategorias as $cat) {
							?>
							<!-- CATEGORIA
							<?php var_dump($cat); ?>
							-->
						<div class="item-categoria">
							<div class="item-categoria-inner">
								<div class="item-categoria-imagen">
									<?php
									$current_image_url = ($cat->imagen_url != '') ? str_replace("{id}", $cat->id, $cat->imagen_url) . "/thumbnail.jpg"  : '/statics/images/noimage.jpg';
									
									if(trim($cat->imagen_url) == '' || !file_exists($_SERVER["DOCUMENT_ROOT"].$current_image_url)) {
										$current_image_url = '/statics/images/noimage.jpg';
									}
									?>
									<a href="/categorias?c=<?php echo $cat->id; ?>"><img src="<?php echo $current_image_url.'?'.$revision; ?>"></a>
								</div>
								<?php
								if ($userStats['user'] && $userStats['user']->administrador == 1) {

									?>

									<div class="admin-category-cmds">
										<span class="admin-category-cmd cmd-edit" data-id="<?php echo $cat->id; ?>" data-titulo="<?php echo $cat->titulo; ?>" data-descripcion_breve="<?php echo $cat->descripcion_breve; ?>" data-descripcion="<?php echo $cat->descripcion; ?>" data-categoria_id="<?php echo $cat->categoria_id; ?>" data-estado="<?php echo $cat->estado; ?>" data-orden="<?php echo $cat->orden; ?>">Editar</span>
										<span class="admin-category-cmd cmd-delete" data-id="<?php echo $cat->id; ?>" data-titulo="<?php echo $cat->titulo; ?>">Eliminar</span>
									</div>

									<?php

								}
								?>
								<div class="item-categoria-titulo" style="display: none;">
									<a href="/categorias?c=<?php echo $cat->id; ?>"><?php echo $cat->titulo; ?></a>
								</div>
								<div class="item-categoria-titulo-new">
									<a href="/categorias?c=<?php echo $cat->id; ?>"><span class="fa fa-circle"></span> <?php echo $cat->titulo; ?> <span class="fa fa-circle"></span></a>
								</div>
							</div>
						</div>
							<?php

						}

						?>
						
					</div>
					<div style="clear: both;"></div>
				</div>
			</div>
