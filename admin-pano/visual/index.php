<?php

$relative = '../..';
require '../../includes/common.php';

$userStats = loadUser();

returnIfNotAdmin();

$appPlace = 'admin-pano';
$appSubPlace = 'visual-settings';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadHeader("header");

?>
					<div class="home-block config-nav">
						<div class="left-column">
							<h1><span>Configuración de apariencia</span><span class="subtitle">- AppCommerce</span></h1>
						</div>
						<div class="right-column">
							<div class="config-nav-menu">
								<a href="/admin-pano/" class="btn btn-action shadow-3">General</a>
								<a href="/admin-pano/users/" class="btn btn-action shadow-3">Usuarios</a>
								<a href="/admin-pano/sales/" class="btn btn-action shadow-3">Ventas</a>
								<a href="/admin-pano/categories/" class="btn btn-action shadow-3">Categorías</a>
								<a href="/admin-pano/articles/" class="btn btn-action shadow-3">Artículos</a>
							</div>
						</div>
					</div>
					<form>
						
					</form>
<?php

loadFooter("footer");
endDocument();

?>