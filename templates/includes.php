<?php
$appPlace = $GLOBALS['appPlace'];
$appSubPlace = $GLOBALS['appSubPlace'];
$userStats = (isset($GLOBALS['userStats']) ? $GLOBALS['userStats'] : array());
$revision = 'revision='.rand(1,3000);
switch($place) {

case 'head':
?>

	<meta charset="UTF-8">
	
	<meta http-equiv=”Expires” content=”0″>
	<meta http-equiv=”Last-Modified” content=”0″>
	<meta http-equiv=”Cache-Control” content=”no-cache, mustrevalidate”>
	<meta http-equiv=”Pragma” content=”no-cache”>
	
	<!--[if lt IE 9]>
	<script type="text/javascript">
		document.createElement("nav");
		document.createElement("header");
		document.createElement("footer");
		document.createElement("section");
		document.createElement("article");
		document.createElement("aside");
		document.createElement("hgroup");
	</script>
	<![endif]-->

	<!-- css -->
	<link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
	<link href="/statics/css/layout.css?<?php echo $revision; ?>" rel="stylesheet">
	<link href="/statics/css/colortheme.php?<?php echo $revision; ?>" rel="stylesheet">
	<link href="/statics/css/frameworks/fontawesome/font-awesome.min.css?<?php echo $revision; ?>" rel="stylesheet">
	<link href="/statics/css/blueimp-gallery.min.css?<?php echo $revision; ?>" rel="stylesheet">
	
	<?php
	
	switch($appPlace) {

	case 'home':
	?>

	<!-- Title for home -->
	<title>Unifit.com.uy</title>

	<!-- home css -->
	<link rel="stylesheet" href="/statics/css/home.css?<?php echo $revision; ?>">
		
	<?php
	break;
	case 'search':
	?>

	<!-- Title for search and categories -->
	<title>Unifit.com.uy - Búsqueda</title>

	<!-- home css -->
	<link rel="stylesheet" href="/statics/css/categories.css?<?php echo $revision; ?>">
		
	<?php
	break;
	case 'categories':
	?>

	<!-- Title for search and categories -->
	<title>Unifit.com.uy - Categorías</title>

	<!-- home css -->
	<link rel="stylesheet" href="/statics/css/categories.css?<?php echo $revision; ?>">
		
	<?php
	break;

	case 'instalacion':
	?>

	<!-- Title for search and categories -->
	<title>Unifit.com.uy - Instalación</title>

	<!-- instalacion css -->
	<link rel="stylesheet" href="/statics/css/instalacion.css?<?php echo $revision; ?>">
		
	<?php
	break;

	case 'admin-pano':
	?>

	<title>Unifit.com.uy - Configuración</title>

	<?php
	break;

	}

	switch($appSubPlace) {

	case 'login':

	?>

	<!-- <link rel="stylesheet" href="/statics/css/administrador.css?<?php echo $revision; ?>"> -->

	<?php

	break;

	}

	// estilos que solo se usaran en paginas de administrador
	if(@$userStats['user']->administrador == 1) {
	?>

	<link rel="stylesheet" href="/statics/css/administrador.css?<?php echo $revision; ?>">

	<?php
	}

	?>

<?php
break;

case 'body-end':
?>

	<?php if(@$userStats['user']->administrador == 1) : ?>

	<div id="administrative-tools" class="contracted">
		<ul>
			<li class="admin-tool admin-tool-control expand-tool">
				<a href="#" data-action="expand" data-target="#administrative-tools">
					<span class="fa fa-angle-double-right"></span>
					<span class="label">Expandir</span>
				</a>
				<span class="over-label globe dark">Expandir</span>
			</li>
			<li class="admin-tool admin-tool-control contract-tool">
				<a href="#" data-action="contract" data-target="#administrative-tools">
					<span class="fa fa-angle-double-left"></span>
					<span class="label">Contraer</span>
				</a>
				<span class="over-label globe dark">Contraer</span>
			</li>
			<li class="admin-tool config-tool<?php echo ($appSubPlace == 'global-settings') ? ' active' : '' ?>">
				<a href="/admin-pano/">
					<span class="fa fa-gears"></span>
					<span class="label">Configuración</span>
				</a>
				<span class="over-label globe dark">Configuración</span>
			</li>
			<li class="admin-tool visual-tool<?php echo ($appSubPlace == 'visual-settings') ? ' active' : '' ?>">
				<a href="/admin-pano/visual/">
					<span class="fa fa-desktop"></span>
					<span class="label">Apariencia</span>
				</a>
				<span class="over-label globe dark">Apariencia</span>
			</li>
			<li class="admin-tool users-tool<?php echo ($appSubPlace == 'users-admin') ? ' active' : '' ?>">
				<a href="/admin-pano/users/">
					<span class="fa fa-users"></span>
					<span class="label">Usuarios</span>
				</a>
				<span class="over-label globe dark">Usuarios</span>
			</li>
			<li class="admin-tool sales-tool<?php echo ($appSubPlace == 'sales-admin') ? ' active' : '' ?>">
				<a href="/admin-pano/sales/">
					<span class="fa fa-copy"></span>
					<span class="label">Ventas</span>
				</a>
				<span class="over-label globe dark">Ventas</span>
			</li>
			<li class="admin-tool categories-tool<?php echo ($appSubPlace == 'categories-admin') ? ' active' : '' ?>">
				<a href="/admin-pano/categories/">
					<span class="fa fa-folder-o"></span>
					<span class="label">Categorías</span>
				</a>
				<span class="over-label globe dark">Categorías</span>
			</li>
			<li class="admin-tool articles-tool<?php echo ($appSubPlace == 'articles-admin') ? ' active' : '' ?>">
				<a href="/admin-pano/articles/">
					<span class="fa fa-file-text-o"></span>
					<span class="label">Artículos</span>
				</a>
				<span class="over-label globe dark">Artículos</span>
			</li>
		</ul>
	</div>

	<?php endif ?>

	<a href="#<?php echo $GLOBALS['appPlace'].($GLOBALS['appSubPlace'] != '' ? '-'.$GLOBALS['appSubPlace'] : '') ?>" class="scroll-up fa fa-angle-up"></a>

	<!-- plugin scripts -->
	<script src="/statics/js/plugins/jquery-1.11.0.js?<?php echo $revision; ?>"></script>
	<script src="/statics/js/plugins/backstretch.js?<?php echo $revision; ?>"></script>
	<script src="/statics/js/generals.js?<?php echo $revision; ?>"></script>

	<?php if(@$userStats['user']->administrador == 1) : ?>

	<script src="/statics/js/administrador.js?<?php echo $revision; ?>"></script>

	<?php endif ?>

	<?php
	
	switch($appPlace) {

	case 'home':
	?>

	<!-- site scripts -->
	<script src="/statics/js/home.js?<?php echo $revision; ?>"></script>
		
	<?php

	break;
	case 'search':
	case 'categories':
	?>

	<!-- site scripts -->
	<script src="/statics/js/categorias.js?<?php echo $revision; ?>"></script>
		
	<?php

	break;

	case 'instalacion':
	?>

	<!-- site scripts -->
	<script src="/statics/js/instalacion.js?<?php echo $revision; ?>"></script>
		
	<?php

	break;

	}

	switch($appSubPlace) {

		case 'pedido-actual':

		?>

		<script src="/statics/js/carrito.js?<?php echo $revision; ?>"></script>

		<?php

		break;

		case 'register':

		?>

		<!-- <script src="/statics/js/registro.js?<?php echo $revision; ?>"></script> -->

		<?php

		break;

	}

	// scripts que solo se usaran en paginas de administrador
	if (@$userStats['user']->administrador == 1) {
	?>

	

	<?php
	}

	?>

<?php
break;

}
?>