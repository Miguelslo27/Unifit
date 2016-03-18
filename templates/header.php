
	<header class="shadow-5">
		<div class="header-inner">
			<div id="logo">
				<a href="/"><img src="/statics/images/logo_unifit.png" alt="Unifit.com.uy"></a>
			</div>
			<div class="user-nav">
				<nav class="shadow-3">
					<a href="/" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="home") echo 'is-active'; ?>">Inicio</a>
					<a href="/categorias" class="access-menu large-tab <?php if($GLOBALS['appPlace']=="categories") echo 'is-active'; ?>">Comprar</a>
					<a href="/como-comprar" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="hoy-to-buy") echo 'is-active'; ?>">Ayuda</a>
					<a href="/contacto" class="access-menu normal-tab <?php if($GLOBALS['appPlace']=="contact") echo 'is-active'; ?>">Contacto</a>
					<div id="search-box">
						<form action="/busqueda/" method="GET">
							<span class="fa fa-search"></span>
							<input type="text" name="clave" class="search-input" placeholder="Qué deseas encontrar?">
						</form>
					</div>
				</nav> 
				<div id="user-cmd" class="shadow-3">
					
					<?php
				
					$userStats = $GLOBALS['userStats'];
					$templatesPath = $GLOBALS['config']['templatesPath'];
				
					$revision = 'revision='.rand(1,3000);

					if($userStats['status'] == 'LOGGED') {
						$userName = $userStats['user']->nombre;
						$userId   = $userStats['user']->id;
						include($templatesPath . 'user/logged-cmds.php');
					} else {
						include($templatesPath . 'user/not-logged-cmds.php');
					}
				
					?>
				
				</div>
			</div>
		</div>
	</header>
	