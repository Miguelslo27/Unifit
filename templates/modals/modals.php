	<div class="modal-bg"></div>
	<div class="modal-cont">
<?php

$appPlace = $GLOBALS['appPlace'];
$appSubPlace = $GLOBALS['appSubPlace'];
$userStats = $GLOBALS['userStats'];
$templatesPath = $GLOBALS['config']['templatesPath'];

switch($userStats['status']) {

	case 'NO_USERS':

		include($templatesPath . 'modals/superuser-register.php');

	break;
	case 'READY_TO_LOGIN':
	case 'USER_DOESNT_EXIST':
	case 'ERROR_EMAIL_OR_PASS':
	
		// include($templatesPath . 'modals/login.php');

	break;

}

switch($appSubPlace) {

	case 'register':

		// include($templatesPath . 'modals/login.php');

	break;
	case 'pedido-actual':

		include($templatesPath . 'modals/confirmar-pedido.php');
		include($templatesPath . 'modals/compra-menor-al-limite.php');

	break;

}

switch($appPlace) {

	case 'categories':

		if ($userStats['user'] && $userStats['user']->administrador == 1) {

			$categories = $GLOBALS['categories'];
			$category = $GLOBALS['category'];

			include($templatesPath . 'modals/new-category.php');
			include($templatesPath . 'modals/new-article.php');
			include($templatesPath . 'modals/delete-category.php');
			include($templatesPath . 'modals/delete-article.php');

		} else if (!$userStats['user']) {

			include($templatesPath . 'modals/accesso-restringido.php');

		} else {

			include($templatesPath . 'modals/mensaje-nueva-forma-compra.php');
			
		}

	break;

}

?>
</div>