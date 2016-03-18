
			<div class="user-links">
				<span class="user-menu user-logged">
					<span class="icon fa fa-2x fa-user"></span>
					<span class="link-label"><span><?php echo $userName ?></span></span>
					<div class="dropdown padding-5 shadow-3">
						<ul>
							<li><a href="/registro/?id=<?php echo $userId ?>"><span class="fa fa-edit"></span>Mis datos</a></li>
							<li><a href="/logout/"><span class="fa fa-power-off"></span>Salir</a></li>
						</ul>
					</div>
				</span>

				<?php if(@$userStats['user']->administrador == 1) : ?>

				<span class="user-menu admin-settings">
					<a href="/admin-pano/"><span class="icon fa fa-2x fa-gear"></span></a>
					<span class="link-label"><span>Panel de Administrador</span></span>
				</span>

				<?php else : ?>

				<span class="user-menu user-cart">
					<a href="/pedido/"><span class="icon fa fa-2x fa-shopping-cart"></span></a>
					<span class="globe">14</span>
					<span class="link-label"><span>Mi Pedido</span></span>
					<div class="dropdown padding-5 shadow-3">
						<table class="minicart">
							<thead>
								<tr>
									<th class="label">Artículos</th>
									<th class="value">0</th>
								</tr>
								<tr>
									<th class="label">Total</th>
									<th class="value">$ 0,00</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th colspan="2" class="title"><h4><span>Pedido</span></h4></th>
								</tr>
								<tr>
									<td colspan="2" class="empty">Vacío</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2">
										<a href="/pedido/" class="btn btn-primary">Terminar pedido</a>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</span>

				<?php endif ?>
			</div>
