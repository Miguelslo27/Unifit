<?php

$relative = '../..';
require '../../includes/common.php';

$userStats = saveUser();
$appPlace = 'home';
$appSubPlace = 'welcome';
$templatesPath = $GLOBALS['config']['templatesPath'];

if(!isset($_SESSION['registered'])) {
	header('Location: /');
}

unset($_SESSION['registered']);

startDocument();
loadHeader("header");

?>

				<h1><span>¡Tu registro ha sido un éxito!</span></h1>
				<!-- <p>Sólo te queda un paso para poder disfrutar de todos los beneficios de estar registrado.</p> -->
				<!-- <p><strong>Te hemos enviado un email</strong> con un <strong>link</strong> y un <strong>código de activación</strong>, sólo debes revisar tu correo y seguir las instrucciones.</p> -->
				<p>Ya puedes ingresar al sitio y disfrutar de todos los beneficios de estar registrado.</p>
				<h3>Muchas gracias por tu registro.</h3>

<?php

loadFooter("footer");
endDocument();
?>