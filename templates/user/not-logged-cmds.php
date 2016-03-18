			<div class="user-links">
				<span class="user-menu user-login">
					<a href="/login/"><span class="icon fa fa-2x fa-unlock-alt"></span></a>
					<span class="link-label"><span>Ingresar</span></span>
					<div class="dropdown shadow-3">
						<form action="/login/" method="POST" id="login-form">
							<div class="form-line">
								<label for="email">E-Mail</label>
								<input type="text" class="input shadow-3" id="email" name="email" placeholder="Email">
							</div>
							<div class="form-line">
								<label for="pass">Contraseña</label>
								<input type="password" class="input shadow-3" id="pass" name="pass" placeholder="Contraseña">
							</div>
							<div class="form-line">
								<label for="rememberme" class="rememberme">
									<input type="checkbox" id="rememberme" name="rememberme" checked="true">
									<span>Recordar</span>
								</label>
								<a href="/recuperar-clave/">Recuperar clave</a>
							</div>
							<div class="form-line form-commands">
								<button type="submit" class="btn bnt-login btn-style shadow-3">Ingresar</button>
							</div>
						</form>
					</div>
				</span>
				<span class="user-menu user-register">
					<a href="/registro/"><span class="icon fa fa-2x fa-edit"></span></a>
					<span class="link-label"><span>Registrarme</span></span>
				</span>
			</div>
