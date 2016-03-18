	<div class="modal" id="super-user-register">
		<div class="modal-title">
			<h2>Registro de Administrador</h2>
			<a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>
			<span class="line-h">&nbsp;</span>
		</div>
		<div class="modal-content cols cols-1">
			<div class="modal-col modal-col-span1 first-col last-col">
				<div class="modal-col-inner">
					<h3>Registro de usuario Administrador por primera vez</h3>
					<span class="line-h">&nbsp;</span>
					<form action="/registro/index.php?newUser=true" method="POST" id="first-time-register-form">
						<div class="form-line form-error">
							<span>Alguno de los datos ingresados es incorrecto!</span>
						</div>
						<div class="form-line">
							<label for="nombre">Nombre</label>
							<input type="text" class="input" id="nombre" name="nombre">
						</div>
						<div class="form-line">
							<label for="apellido">Apellido</label>
							<input type="text" class="input" id="apellido" name="apellido">
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
							<label for="pass2">Repetir contraseña</label>
							<input type="password" class="input" id="pass2" name="pass2">
						</div>
						<div class="form-line">
							<label for="direccion">Dirección</label>
							<input type="text" class="input" id="direccion" name="direccion">
						</div>
						<div class="form-line">
							<label for="telefono">Teléfono</label>
							<input type="text" class="input" id="telefono" name="telefono">
						</div>
						<div class="form-line">
							<label for="departamento">Departamento</label>
							<input type="text" class="input" id="departamento" name="departamento">
						</div>
						<div class="form-line">
							<label for="ciudad">Ciudad</label>
							<input type="text" class="input" id="ciudad" name="ciudad">
						</div>
						<div class="form-line form-commands">
							<button type="submit" class="btn btn-style bnt-login black">Registrarme</button>
							<button type="button" class="btn btn-style bnt-login grey action-close">Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>