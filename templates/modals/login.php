	<div class="modal" id="first-time-user">
		<div class="modal-title">
			<h2>Exclusivo Clientes Mayoristas</h2>
			<a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>
			<span class="line-h">&nbsp;</span>
		</div>
		<div class="modal-content cols cols-2">
			<div class="modal-col modal-col-span1 first-col">
				<div class="modal-col-inner">
					<h3>Ya soy usuario registrado</h3>
					<span class="line-h">&nbsp;</span>
					<form action="/index.php?a=login" method="POST" id="login-form">
						<div class="form-line form-error">
							<span>Alguno de los datos ingresados es incorrecto!</span>
						</div>
						<div class="form-line">
							<label for="email">E-Mail</label>
							<input type="text" class="input" id="email" name="email">
						</div>
						<div class="form-line">
							<label for="pass">Contraseña</label>
							<input type="password" class="input" id="pass" name="pass">
						</div>
						<div class="form-line">
							<label class="allsize" for="rememberme">
								<input type="checkbox" id="rememberme" name="rememberme" checked="true">
								Recúerdame en este equipo
							</label>
						</div>
						<div class="form-line form-commands">
							<button type="submit" class="btn bnt-login btn-style black">Ingresar</button>
							<a href="/recuperar-clave/">¿Has olvidado tu contraseña?</a>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-col modal-col-span1 last-col">
				<div class="modal-col-inner">
					<h3>Nuevo usuario</h3>
					<span class="line-h">&nbsp;</span>
					<form action="/registro" method="POST">
						<div class="form-line">
							<p>Registrarse en Monique.com.uy tiene muchas ventajas:</p>
							<ul>
								<li>Acceso a nuestros precios mayoristas</li>
								<li>Poder realizar pedidos desde la web</li>
								<li>Recibir ofertas y promociones exclusivas en tu email</li>
								<li>Y si deseas, recibirás nuestro catálogo en casa cada temporada</li>
							</ul>
						</div>
						<div class="form-line form-commands">
							<a href="/registro" class="btn btn-style btn-register black">Registrarme</a>
							<a href="/" class="btn bnt-login btn-style grey action-close">Ahora no, gracias</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- <div class="modal-footer">
		</div> -->
	</div>