<?php

$relative = '..';
require '../includes/common.php';

$appPlace = 'instalacion';
$appSubPlace = 'configuracion-db-table';

startDocument();
loadSection("header-install");

?>
	<div class="body">
		<div class="body-inner">
			<div class="body-content">
				<h1><span>Instalación</span><span class="subtitle">- Asistente de configuración de eCommerceApp</span></h1>
				<p>Estás un paso más cerca de completar la configuración del sistema.</p>
				<?php
				if(count($_POST) && (isset($_POST['table_prefix']) && trim($_POST['table_prefix']) == '')) {
					?>

					<div class="error">
						<h3>Algunos de los campos obligatorios no fueron completados</h3>
						<p>Verifica que campos quedaron vacíos.</p>
					</div>

					<?php
				} elseif(count($_POST)) {
					// check data and save config
					
				}
				?>
				<form action="/instalacion/index.php" method="post" id="settings">
					<h3>Paso 5: Prefijo</h3>
					<p>Especifica con que prefijo se encuentran guardadas las tablas del sistema en tu base de datos.</p>
					<p>Si las tablas no existen en la base de datos, estas se crearán automáticamente.</p>
					<?php if(count($_POST) && (isset($_POST['table_prefix']) && trim($_POST['table_prefix']) == '')) : ?>
					<span class="error">
					<?php endif; ?>
					<input type="text" name="table_prefix" placeholder="Prefijo para tablas del sistema" class="shadow-3" required>
					<?php if(count($_POST) && (isset($_POST['table_prefix']) && trim($_POST['table_prefix']) == '')) : ?>
					</span>
					<?php endif; ?>
					<button type="submit" name="save" class="shadow-3">Siguiente</button>
				</form>
			</div>
<?php

loadSection("footer-install");
endDocument();

?>