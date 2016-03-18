<?php

$relative      = '..';
require '../includes/common.php';

$userStats     = loadUser();

returnIfNotAdmin();
$onSaveStatus  = saveSiteSettings($_POST);

$appPlace      = 'admin-pano';
$appSubPlace   = 'global-settings';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadHeader("header");

?>
					<div class="home-block config-nav">
						<div class="left-column">
							<h1><span>Configuración general</span><span class="subtitle">- AppCommerce</span></h1>
						</div>
						<div class="right-column">
							<div class="config-nav-menu">
								<a href="#general" class="btn btn-action shadow-3">Información General</a>
								<a href="#correos" class="btn btn-action shadow-3">Correos Electrónicos</a>
								<a href="#notificaciones" class="btn btn-action shadow-3">Notificaciones</a>
							</div>
						</div>
					</div>
					<form action="/admin-pano/" method="POST">
						<div class="home-block">
							<h3 id="general">Información general</h3>
							<div class="left-column">
								<p><strong>Nombre de la empresa</strong> Especifica el nombre de tu sitio y dominio del comercio electrónico, con el se identificarán tus clientes.</p>
								<input type="text" name="nombre" tabindex="1" class="shadow-3" placeholder="¿Qué nombre lleva tu eCommerce?">
								<input type="text" name="dominio" tabindex="2" class="shadow-3" placeholder="¿Qué nombre de dominio lleva tu eCommerce?">
							</div>
							<div class="right-column">
								<p><strong>Descripción de la empresa</strong> Escribe una descripción de tu comercio, esta descripción se verá en la pantalla principal del eCommerce.</p>
								<textarea name="descripcion" tabindex="3" class="shadow-3" placeholder="Describe tu comercio"></textarea>
							</div>
						</div>
						<div class="home-block">
							<div class="left-column">
								<p><strong>Dirección de la empresa</strong> Si tu comercio tiene local físico, escribe la dirección del mismo. Especifica calle, número y localidad.</p>
								<input type="text" name="direccion" tabindex="4" class="shadow-3" placeholder="Ej. Calle X 1234, Montevideo, Uruguay">
							</div>
							<div class="right-column">
								<p><strong>Teléfono/s de la empresa</strong> Déjale saber a tus clientes un teléfono de contacto, si tienes más de uno, sepáralos con una barra o guión.</p>
								<input type="text" name="telefono" tabindex="5" class="shadow-3" placeholder="2402 1234 / 099 123 123">
							</div>
						</div>
						<div class="home-block">
							<h3 id="correos">Correos electrónicos</h3>
							<div class="left-column">
								<p><strong>Correo de Administrador</strong> A este correo llegarán todas las notificaciones pertinentes.</p>
								<input type="text" name="admin-email" tabindex="6" class="shadow-3" placeholder="Correo del Administrador">
							</div>
							<div class="right-column">
								<p><strong>Correo de Vendedor</strong> A este correo llegarán todas las ventas del sitio, incluyendo detalles de la misma.</p>
								<input type="text" name="vendedor-email" tabindex="7" class="shadow-3" placeholder="Correo del Vendedor">
							</div>
						</div>
						<div class="home-block">
							<div class="left-column">
								<p><strong>Correo de contacto online</strong> A este correo llegarán los mensajes enviados desde el sitio, por tus clientes.</p>
								<input type="text" name="contacto-online-email" tabindex="8" class="shadow-3" placeholder="Correo de Contacto">
							</div>
							<div class="right-column">
								<p><strong>Correo de contacto directo</strong> Este correo se muestra en la página de contacto, para que los usuarios se comuniquen directamente.</p>
								<input type="text" name="contacto-email" tabindex="9" class="shadow-3" placeholder="Correo de la Empresa">
							</div>
						</div>
						<div class="home-block">
							<h3 id="notificaciones">Notificaciones</h3>
							<p>Selecciona los motivos por los cuales te gustaría recibir notificaciones en el futuro. Estas opciones sólo aplican al administrador. Los otros correos reciben notificaciones automáticas según su configuración por defecto.</p>
							<label>
								<input type="checkbox" name="notificacion[nuevo-usuario]">
								<span>Nuevo usuario registrado</span>
							</label>
							<label>
								<input type="checkbox" name="notificacion[nuevo-boletin]">
								<span>Nuevo usuario suscrito al boletín</span>
							</label>
							<label>
								<input type="checkbox" name="notificacion[nueva-venta]">
								<span>Se han registrado nuevas ventas</span>
							</label>
							<label>
								<input type="checkbox" name="notificacion[nuevo-mensaje]">
								<span>Mensaje enviado desde el sitio</span>
							</label>
						</div>

						<div class="home-block">
							<div class="left-column">
								<button type="submit" tabindex="10" class="btn btn-primary width-100 shadow-3">Guardar</button>
							</div>
							<div class="right-column">
								<button type="reset" tabindex="11" class="btn btn-off width-100 shadow-3">Restablecer</button>
							</div>
						</div>
					</form>
<?php

loadFooter("footer");
endDocument();

?>