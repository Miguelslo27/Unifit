			<div class="body-content">
				<div class="lista-categorias">

					<h1 class="titulo-pedidos" style="text-align: center">
						<!-- <span class="fa icon-snowflake"></span>
						<span class="fa fa-circle"></span> 
						Colección <strong>Otoño/Invierno</strong> 2014
						<span class="fa fa-circle"></span> 
						<span class="fa icon-snowflake"></span> -->
						<img src="/statics/images/titulo-oi.jpg" width="960px">
					</h1>
					
					<div class="lista-categorias-columna-izquierda">
						<ul>
							<li><a class="<?php echo ($category->id == 0) ? 'category-selected' : ''; ?>" href="/categorias">Ver todo</a></li>
						<?php
						foreach($categories as $cat) {

							?>
							<li><a href="/categorias?c=<?php echo $cat->id; ?>" class="<?php echo ($cat->titulo == $category->titulo) ? 'category-selected' : '' ?>"><?php echo $cat->titulo; ?></a></li>
							<?php

						}
						?>
							<!-- <li class="categoria-ofertas"><a href="/categorias?ofertas=1">Ofertas Monique</a></li> -->
							<!-- <li class="categoria-ofertas"><a href="/categorias?ofertas=1"><span class="fa fa-star"></span>&nbsp;&nbsp;&nbsp;Ofertas Monique&nbsp;&nbsp;&nbsp;<span class="fa fa-star"></span></a></li> -->
						</ul>
						<a class="categoria-ofertas" href="/categorias?ofertas=1"><img src="/statics/images/ofertas.jpg?<?php echo $revision ?>" alt="Ofertas Monique"></a>
					</div>

					<div class="lista-articulos">
						<!-- <h1 style="display: none;"><img width="35px" src="/statics/images/hoja.gif" style="position: relative; bottom: -6px; margin-right: 10px;">Colección Otoño / Invierno 2014</h1> -->

						<?php
						
						?>
						<!-- <span class="line-h">&nbsp;</span> -->
						<?php
						if ($category->descripcion_breve != '') {
						?>
						<!-- <h2><?php echo ($category->id == 0) ? $category->descripcion_breve : $category->descripcion_breve; ?></h2> -->
						<!-- <span class="line-h margin-bottom"></span> -->
						<?php
						}
						?>
						<!-- <h3 style="font-size: 18px;"><a href="/" style="font-size: 18px;">Inicio</a> / <a href="/categorias/" style="font-size: 18px;">Realizar Pedido</a> / <?php echo ($category->id == 0) ? $category->titulo : $category->titulo; ?><span style="float: right"><span>Envios a todo el interior</span> <span class="fa fa-truck" style="font-size: 22px"></span></h3> -->

						<h3 class="ubicacion-de-usuario">
							<a href="/" class="ubicacion-de-usuario-boton ubicacion-de-usuario-link primero">Inicio</a>
							<a href="/categorias/" class="ubicacion-de-usuario-boton ubicacion-de-usuario-link">Precios | Pedidos</a>
							<span class="ubicacion-de-usuario-boton ultimo">
								<?php echo ($category->id == 0) ? $category->titulo : $category->titulo; ?>
							</span>
							<span class="mensaje-envios">
								<span>Envios a todo el interior</span> <span class="fa fa-truck" style="font-size: 22px"></span>
							</span>
						</h3>

						<!-- <span class="line-h margin-bottom"></span> -->
						<?php
						
						if ($userStats['user'] && $userStats['user']->administrador == 1) {

							include($templatesPath . '/user/admin-cmds.php');

						}

						if(count($category->articulos) == 0) {
							?>

							<p>No se han encontrado artículos en esta categoría.</p>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<br>
							<?php
						}

						foreach($category->articulos as $art) {

						?>
						<!-- ARTICULO
						<?php var_dump($art); ?>
						-->
						<div class="item-articulo">
							<div class="item-articulo-inner">
								<div class="item-articulo-imagen">
									<!-- <a href="/articulos?a=<?php echo $art->id; ?>"> -->
									<?php
									$current_image_url = ($art->imagenes_url != '') ? str_replace("{id}", $art->id, $art->imagenes_url) . "thumbnail.jpg"  : '/statics/images/noimage.jpg';
									if(trim($art->imagenes_url) == '' || !file_exists($_SERVER["DOCUMENT_ROOT"].$current_image_url)) {
										$current_image_url = '/statics/images/noimage.jpg';
									}
									?>
									<img src="<?php echo $current_image_url.'?'.$revision; ?>">
									<!-- </a> -->
									<?php
									if ($art->oferta == 1 && $art->agotado != 1) {

									?>
									<!-- <span style="font-weight: bold; font-size: 14px; z-index: 10; width: 50px; -webkit-transform: rotate(-45deg); transform: rotate(-45deg); border-left: 35px solid transparent; border-right: 35px solid transparent; color: rgb(255, 255, 255); height: 0px; left: -30px; line-height: 36px; position: absolute; text-align: center; border-bottom: 35px solid #FFAA00; top: 12px;">NUEVO</span> -->
									<span><img src="/statics/images/oferta.png?<?php echo $revision ?>"></span>
									<?php

									} elseif ($art->nuevo == 1 && $art->agotado != 1) {

									?>
									<!-- <span style="font-weight: bold; font-size: 14px; z-index: 10; width: 50px; -webkit-transform: rotate(-45deg); transform: rotate(-45deg); border-left: 35px solid transparent; border-right: 35px solid transparent; color: rgb(255, 255, 255); height: 0px; left: -30px; line-height: 36px; position: absolute; text-align: center; border-bottom: 35px solid #FFAA00; top: 12px;">NUEVO</span> -->
									<span><img src="/statics/images/nuevo.png?<?php echo $revision ?>"></span>
									<?php

									} elseif ($art->agotado == 1) {
										
									?>
									<!-- <span style="font-weight: bold; font-size: 10px; z-index: 10; width: 50px; -webkit-transform: rotate(-45deg); transform: rotate(-45deg); border-left: 35px solid transparent; border-right: 35px solid transparent; color: rgb(255, 255, 255); height: 0px; left: -30px; line-height: 36px; position: absolute; text-align: center; border-bottom: 35px solid #FF0000; top: 12px;">AGOTADO</span> -->
									<span><img src="/statics/images/agotado.png?<?php echo $revision ?>"></span>
									<?php

									}
									?>
									<!-- <span style="display: none;"><?php echo $art->nuevo . ' ' . $art->agotado; ?></span> -->
									<?php
									if ($userStats['user'] && $userStats['user']->administrador == 1) {
	
										?>
	
										<div class="admin-article-cmds">
											<pre style="display: none;">
												<?php print_r($art); ?>
											</pre>
											<span class="admin-article-cmd cmd-edit" data-id="<?php echo $art->id; ?>" data-nombre="<?php echo $art->nombre; ?>" data-codigo="<?php echo $art->codigo; ?>" data-descripcion_breve="<?php echo $art->descripcion_breve; ?>" data-descripcion="<?php echo $art->descripcion; ?>" data-precio="<?php echo $art->precio; ?>" data-talle="<?php echo $art->talle; ?>" data-adaptable="<?php echo $art->adaptable; ?>" data-packs="<?php echo $art->packs; ?>" data-categoria_id="<?php echo $art->categoria_id; ?>" data-orden="<?php echo $art->orden; ?>" data-nuevo="<?php echo $art->nuevo; ?>" data-agotado="<?php echo $art->agotado; ?>" data-oferta="<?php echo $art->oferta; ?>" data-surtido="<?php echo $art->surtido; ?>" data-precio_oferta="<?php echo $art->precio_oferta; ?>" data-precio_surtido="<?php echo $art->precio_surtido; ?>" data-precio_oferta_surtido="<?php echo $art->precio_oferta_surtido; ?>">Editar</span>
											<span class="admin-article-cmd cmd-delete" data-id="<?php echo $art->id; ?>"  data-nombre="<?php echo $art->nombre; ?>">Eliminar</span>
										</div>
	
										<?php
	
									}
									?>
								</div>

								<div class="item-articulo-info">
									<!-- <div class="item-articulo-titulo"> -->
										<!-- <a href="/articulos?a=<?php echo $art->id; ?>"> -->
											<?php //echo $art->nombre; ?> <!-- (<strong><?php echo $art->codigo; ?></strong>) -->
										<!-- </a> -->
									<!-- </div> -->
									<div class="item-articulo-description-line item-articulo-nombre">
										<!-- <span class="info-label">Artículo:</span> -->
										<span class="info-value"><?php echo $art->nombre; ?></span>
									</div>
									
									<!-- Switch para Pack / Surtido -->
									<div class="item-switch-pack-surtido">
										<a class="item-switch-tab tab-pack selected" data-tab="item-articulo-info-pack">Comprar pack</a>
										<?php
										if($art->surtido == 1) {
										?>
										<a class="item-switch-tab tab-surtido" data-tab="item-articulo-info-surtido">Comprar surtido</a>
										<?php } ?>
									</div>
									
									<!-- Pack -->
									<div class="item-articulo-subinfo item-articulo-info-pack visible">
										<div class="item-articulo-description-line item-articulo-codigo">
											<span class="info-label">Artículo</span>
											<span class="info-value"><?php echo $art->codigo; ?></span>
										</div>
										<div class="item-articulo-description-line item-articulo-precio">
											<span class="info-label">Precio</span>
											<?php
											if($art->oferta == 1) {
												?>
												<span class="info-value"><span style="text-decoration: line-through; font-size: 11px; line-height: 22px;">$ <?php echo $art->precio; ?></span> <strong style="color: #7b057e;">$ <?php echo $art->precio_oferta; ?> </strong><span style="font-size: 11px; line-height: 22px;">c/u</span></span>
												<?php
											} else {
												?>
												<span class="info-value">$ <?php echo $art->precio; ?> <span style="font-size: 11px; line-height: 22px;">c/u</span></span>
												<?php
											}
											?>
										</div>
										<div class="item-articulo-description-line item-articulo-packs">
											<span class="info-label">Packs</span>
											<span class="info-value"><?php echo $art->packs; ?></span>
										</div>
										<div class="item-articulo-description-line item-articulo-talles">
											<span class="info-label">Talles</span>
											<span class="info-value"><?php echo trim($art->talle) != '' ? str_replace(array(',', ' '), array('-', ''), $art->talle) : 'No hay talles'; ?></span>
										</div>
										<?php
										// if($art->adaptable == 1) {
											?>
											<!--<div class="item-articulo-description-line item-articulo-talles">
												<span class="info-label">Adaptable</span>
												<span class="info-value">Si</span>
											</div>-->
											<?php
										// }
										?>
										<div class="item-articulo-description-line item-articulo-colores">
											<span class="info-label">Colores</span>
											<span class="info-value">
												<?php
												$colorsDir  = '..'.str_replace("{id}", $art->id, $art->colores_url);
												if($art->colores_url == $art->imagenes_url) {
													?>
													<img style="margin: -2px 0 0 -5px" src="<?php echo str_replace("{id}", $art->id, $art->imagenes_url); ?>colors.jpg">
													<?php
												} else {
													if(!is_dir($colorsDir)) {
														?>
														<!-- <img src="<?php echo str_replace("{id}", $art->id, $art->imagenes_url); ?>colors.jpg"> -->
														No hay colores
														<?php
													} else {
														$colorsFiles = opendir($colorsDir);
														$colorsList = array();
														if(!$colorsFiles) {
															?>
															<!-- <img src="<?php echo str_replace("{id}", $art->id, $art->imagenes_url); ?>colors.jpg"> -->
															No hay colores
															<?php
														} else {
															
															?>
															<ul class="lista-colores">
																
																<?php
																
																while($color = readdir($colorsFiles)) {
																	
																	if (!is_dir($color)) {
																		$colorsList[] = $color;
																	}
																}
																
																sort($colorsList);
																foreach($colorsList AS $color) {
																	$colorId = basename($colorsDir.$color, '.jpg');
																	?>
																	<li class="color"><span id="color-<?php echo $art->id; ?>-<?php echo $colorId; ?>"><img src="<?php echo $colorsDir.$color.'?'.$revision; ?>"></span></li>
																	<?php
																}
																
																?>
																
															</ul>
													<?php
														}
													} // END IF readdir $colorsDir
												}
												?>
												<!--<img src="<?php echo str_replace("{id}", $art->id, $art->colores_url); ?>colors.jpg">-->
											</span>
											<div style="clear: both;"></div>
										</div>
									</div>
									
									<!-- Surtido -->
									<div class="item-articulo-subinfo item-articulo-info-surtido">
										<div class="item-articulo-description-line item-articulo-codigo">
											<span class="info-label">Artículo</span>
											<span class="info-value"><?php echo $art->codigo; ?></span>
										</div>
										<div class="item-articulo-description-line item-articulo-precio">
											<span class="info-label">Precio</span>
											<?php
											if($art->precio_surtido != "0") {
												if($art->oferta == 1 && $art->precio_oferta_surtido != "0") {
													?>
													<span class="info-value"><span style="text-decoration: line-through; font-size: 11px; line-height: 22px;">$ <?php echo $art->precio_surtido; ?></span> <strong style="color: #7b057e;">$ <?php echo $art->precio_oferta_surtido; ?> </strong></strong><span style="font-size: 11px; line-height: 22px;">c/u</span></span>
													<?php
												} else {
													?>
													<span class="info-value">$ <?php echo $art->precio_surtido; ?> <span style="font-size: 11px; line-height: 22px;">c/u</span></span>
													<?php
												}
											} else {
												if($art->oferta == 1 && $art->precio_oferta != "0") {
													?>
													<span class="info-value"><span style="text-decoration: line-through; font-size: 11px; line-height: 22px;">$ <?php echo $art->precio; ?></span> <strong style="color: #7b057e;">$ <?php echo $art->precio_oferta; ?> </strong><span style="font-size: 11px; line-height: 22px;">c/u</span></span>
													<?php
												} else {
													?>
													<span class="info-value">$ <?php echo $art->precio; ?> <span style="font-size: 11px; line-height: 22px;">c/u</span></span>
													<?php
												}
											}
											?>
										</div>
										<div class="item-articulo-description-line item-articulo-talles">
											<span class="info-label">Talle</span>
											<span class="info-value">
												<?php
												
												$talles = explode(',', $art->talle);
												
												if(trim($art->talle) != "" && count($talles)) {
													?>
													<select class="talle-select" id="talle-<?php echo $art->id ?>">
														<option value="0">Seleccionar</option>
													<?php
														foreach($talles as $talle) {
															?>
															<option value="<?php echo strtoupper(trim($talle)); ?>"><?php echo strtoupper(trim($talle)); ?></option>
															<?php
														}
													?>
													</select>
													<?php
												} else {
													?>No hay talles<?php
												}
												
												?>
											</span>
										</div>
										<?php
										// if($art->adaptable == 1) {
											?>
											<!--<div class="item-articulo-description-line item-articulo-talles">
												<span class="info-label">Adaptable</span>
												<span class="info-value">Si</span>
											</div>-->
											<?php
										// }
										?>
										<div class="item-articulo-description-line item-articulo-colores">
											<span class="info-label">Color</span>
											<span class="info-value">
												<?php
												$colorsDir  = '..'.str_replace("{id}", $art->id, $art->colores_url);
												if($art->colores_url == $art->imagenes_url) {
													?>
													<img style="margin: -2px 0 0 -5px" src="<?php echo str_replace("{id}", $art->id, $art->imagenes_url); ?>colors.jpg">
													<?php
												} else {
													if(!is_dir($colorsDir)) {
														?>
														<!-- <img src="<?php echo str_replace("{id}", $art->id, $art->imagenes_url); ?>colors.jpg"> -->
														No hay colores
														<?php
													} else {
														$colorsFiles = opendir($colorsDir);
														$colorsList = array();
														if(!$colorsFiles) {
															?>
															<!-- <img src="<?php echo str_replace("{id}", $art->id, $art->imagenes_url); ?>colors.jpg"> -->
															No hay colores
															<?php
														} else {
															?>
															<ul class="lista-colores seleccionable">
																
																<?php
																
																while($color = readdir($colorsFiles)) {
																	if (!is_dir($color)) {
																		$colorsList[] = $color;
																	}
																}
																
																sort($colorsList);
																foreach($colorsList AS $color) {
																	$colorId = basename($colorsDir.$color, '.jpg');
																	?>
																	<li class="color"><span id="color-<?php echo $art->id; ?>-<?php echo $colorId; ?>"><img src="<? echo $colorsDir.$color.'?'.$revision; ?>"></span></li>
																	<?php
																}
																
																?>
																
																<!--<li class="color"><span id="color-338-01"><img src="/statics/images/articles/338/colors/01.jpg"></span></li>
																<li class="color"><span id="color-338-02"><img src="/statics/images/articles/338/colors/02.jpg"></span></li>
																<li class="color"><span id="color-338-03"><img src="/statics/images/articles/338/colors/03.jpg"></span></li>
																<li class="color"><span id="color-338-04"><img src="/statics/images/articles/338/colors/04.jpg"></span></li>-->
															</ul>
													<?php
														}
													} // END IF readdir $colorsDir
												}
												?>
												<!--<img src="<?php echo str_replace("{id}", $art->id, $art->colores_url); ?>colors.jpg">-->
											</span>
											<div style="clear: both;"></div>
										</div>
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
												Ingrese cantidad <input type="text" value="1" class="input vsmall-input packs-cantidad">
											</label>
											<a href="#" class="btn btn-style black add-to-cart" data-id="<?php echo $art->id; ?>">Agregar al pedido<span class="fa fa-shopping-cart"></span></a>

											<?php

											} else {

											?>

											<label>
												Ingrese cantidad <input type="text" value="1" disabled="true" class="input vsmall-input packs-cantidad">
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
						
					</div>
					<div style="clear: both;"></div>
					
				</div>
			</div>
