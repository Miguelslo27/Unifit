<?php

session_start();
header('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(isset($_GET['debug'])) {
	$_SESSION['debug'] = $_GET['debug'];
}

if(isset($_SESSION['debug'])) {

	?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv=”Expires” content=”0″>
	<meta http-equiv=”Last-Modified” content=”0″>
	<meta http-equiv=”Cache-Control” content=”no-cache, mustrevalidate”>
	<meta http-equiv=”Pragma” content=”no-cache”>

</head>
<body>
	<h1>Sitio en mantenimiento</h1>
</body>
</html>

	<?php
	exit();

}

require_once('db.class.php');
require_once('class.upload.php');
include('mailer/PHPMailerAutoload.php');

is_file($relative.'/includes/config.php') AND require_once('config.php');

$revision = 'revision='.rand(1,3000);
define('TEMPLATE_PATH', (isset($GLOBALS['config']) ? $GLOBALS['config']['templatesPath'] : $relative.'/templates/'));

if(!isset($config)) {
	if($_SERVER['REQUEST_URI'] != '/instalacion' && $_SERVER['REQUEST_URI'] != '/instalacion/'  && $_SERVER['REQUEST_URI'] != '/instalacion/index.php') {
		header('Location: /instalacion');
	}
} else {
	$db = new DB($config['db_name'], $config['db_host'], $config['db_user'], $config['db_pass']);
}

/* USUARIO */
function returnIfLoggedIn($userStats) {
	$homeUrl     = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
	$loginUrl    = $homeUrl.'/login/';
	$regisUrl    = $homeUrl.'/registro/';
	$welcomUrl   = $homeUrl.'/registro/bienvenida/';

	if($userStats['status'] == 'LOGGED') {
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != $loginUrl && $_SERVER['HTTP_REFERER'] != $regisUrl && $_SERVER['HTTP_REFERER'] != $welcomUrl) {
			header('Location: '.$_SERVER['HTTP_REFERER']);
		} else {
			header('Location: /');
		}
	}
}

function loadUser($login = NULL) {
	// si no hay usuario ingresado
	if(!isset($_SESSION['usuario'])) {
		// chequeo si hay usuarios en la base de datos (solo la primera vez)
		if(checkUsers()) {
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			$pass = isset($_POST['pass']) ? $_POST['pass'] : '';

			if((!$email || !$pass) && $login == "login") {

				return array('user' => NULL, 'cart' => NULL,  'status' => 'ERROR_EMAIL_OR_PASS');

			} elseif (!$email && !$pass) {

				return array('user' => NULL, 'cart' => NULL,  'status' => 'READY_TO_LOGIN');

			} else {

				return array('user' => NULL, 'cart' => NULL,  'status' => 'READY_TO_LOGIN');
				
			}

			return loginUser($email, $pass);

		} else {

			header('Location: /instalacion/admin-registration');

		}

	} else {

		$usuario = JSON_decode($_SESSION['usuario']);

		if (checkCurrentUser($usuario->email)) {

			$pedido = obtenerPedidoAbierto($usuario->id);

			return
				array(
					'user' => $usuario,
					'cart' => $pedido,
					'status' => 'LOGGED'
				);

		} elseif (!checkUsers()) {

			return array('user' => NULL, 'cart' => NULL,  'status' => 'NO_USERS');

		} else {

			$email = isset($_POST['email']) ? $_POST['email'] : '';
			$pass = isset($_POST['pass']) ? $_POST['pass'] : '';

			if (!$email || !$pass) {

				return array('user' => NULL, 'cart' => NULL,  'status' => 'ERROR_EMAIL_OR_PASS');

			}

			loginUser($email, $pass);

		}

	}

}

function loginUser($email = NULL, $pass = NULL, $forzarLogin = false) {
	if((!$email && !$pass) && (!count($_POST) || (!isset($_POST['email']) && !isset($_POST['pass']))) && !isset($_SESSION['usuario'])) {
		return array('user' => NULL, 'cart' => NULL,  'status' => 'READY_TO_LOGIN');
	}

	if(isset($_SESSION['usuario'])) {
		return array('user' => JSON_decode($_SESSION['usuario']), 'cart' => JSON_decode($_SESSION['pedido']),  'status' => 'LOGGED');
	}

	$email = $email ? $email : isset($_POST['email']) ? $_POST['email'] : '';
	$pass  = $pass ? $pass : isset($_POST['pass']) ? $_POST['pass'] : '';

	$email = str_replace(" ", "", strtolower(trim($email)));

	if(!$email || !$pass) {
		return array('user' => NULL, 'cart' => NULL,  'status' => 'ERROR_EMAIL_OR_PASS');
	}

	// cargar el usuario por email y pass y retornar los valores
	$db = $GLOBALS['db'];
	$sql = 'SELECT `id`, `nombre`, `apellido`, `rut`, `email`, `direccion`, `telefono`, `celular`, `departamento`, `ciudad`, `administrador` FROM `usuario` WHERE `email` = "' . $email . '" AND `clave` = "' . md5($pass . $email) . '"';
	$usuario = $db->getObjeto($sql);

	if($usuario) {
		$pedido = obtenerPedidoAbierto($usuario->id);

		$_SESSION['usuario'] = JSON_encode($usuario);
		$_SESSION['pedido'] = JSON_encode($pedido);

		return array(
			'user' => $usuario,
			'cart' => $pedido,
			'status' => 'LOGGED'
		);
	} else {
		return array('user' => NULL, 'cart' => NULL,'status' => 'ERROR_EMAIL_OR_PASS');
	}
}

function checkEmail($email = NULL) {
	if(!$email) {
		return false;
	}

	$email = str_replace(" ", "", strtolower(trim($email)));

	$db = $GLOBALS['db'];
	$sql = 'SELECT `email`, `codigo` FROM `usuario` WHERE `email` = "' . $email . '"';
	$usuario = $db->getObjeto($sql);

	if(isset($usuario->email) && $usuario->email != '') {
		$_SESSION['codigo-de-recuperacion'] = $usuario->codigo;
		return true;
	} else return false;
}

function enviarDatosDeRecuperacion ($email) {

	$asunto = "Solicitud de recuperación de contraseña";
	$mensaje = ''.
	'<p>Has solicitado la recuperación de tu contraseña de Monique.com.uy</p>'.
	'<p>Por favor, sigue el link a continuación y podrás cambiar tu contraseña.</p>'.
	'<p><a href="http://monique.com.uy/recuperar-clave/index.php?c='.$_SESSION['codigo-de-recuperacion'].'">Click aquí para cambiar contraseña</a></p>'.
	'<p>Si por cualquier motivo no puedes hacer click en el link anterior, copia la siguente dirección y pégala en la barra de direcciones de tu navegador</p>'.
	'<p>http://monique.com.uy/recuperar-clave/index.php?c='.$_SESSION['codigo-de-recuperacion'].'</p>';

	$mail = new PHPMailer();
	// $mail->addAddress('no-responder@monique.com.uy', 'Monique.com.uy');
	$mail->addAddress($email);
	
	$mail->setFrom('monique@monique.com.uy', 'Monique - Tienda Online');
	$mail->Subject = utf8_decode($asunto);
	$mail->msgHTML(utf8_decode($mensaje));

	if ($mail->send()) {

		return true;

	} else {

		return false;
		
	}

}

function checkCodigoDeValidacion ($codigo = NULL) {

	// debo obtener el usuario según el código
	if(!$codigo) {
		return false;
	}

	$db = $GLOBALS['db'];
	// $sql = 'SELECT `email`, `codigo` FROM `dev_usuario` WHERE `codigo` = "' . $codigo . '"';
	$sql = 'SELECT `email`, `codigo` FROM `usuario` WHERE `codigo` = "' . $codigo . '"';
	$usuario = $db->getObjeto($sql);

	if(isset($usuario->email) && $usuario->email != '') {
		$_SESSION['email-de-recuperacion'] = $usuario->email;
		return true;
	} else return false;

}

function checkClaves($clave1 = NULL, $clave2 = NULL) {

	if(!$clave1 || !$clave2 || $clave1 != $clave2 || $clave1 == '') {

		return false;

	}

	return actualizarClave($clave1);

}

function actualizarClave($clave = NULL) {

	if(!$clave) return false;
	$email = str_replace(" ", "", strtolower($_SESSION['email-de-recuperacion']));

	$db = $GLOBALS['db'];
	// $sql = 'UPDATE `dev_usuario` SET `clave`="' . md5($clave . $email) . '" WHERE `email`="' . $email .'"';
	$sql = 'UPDATE `usuario` SET `clave`="' . md5($clave . $email) . '" WHERE `email`="' . $email .'"';

	$cid = $db->insert($sql);
	
	return true;

}

function logout () {

	session_destroy();
	return array('user' => NULL, 'cart' => NULL, 'status' => 'LOGGED_OUT');

}

function saveUser() {
	$user = loadUser();

	if($user['user'] && !isset($_POST['id'])) {
		$user['status'] = 'LOGGED';
		return $user;
	}

	$registerStatus = array(
		'status' => 'OK',
		'fields_messages' => array()
	);

	if(isset($_POST['guardar'])) {
		$email        = @trim($_POST['email']) OR NULL;
		$email        = @str_replace(" ", "", strtolower($email)) OR NULL;

		$registerStatus['status']                   = 'DUPLICATE_EMAIL';
		$registerStatus['fields_messages']['email'] = 'DUPLICATE_EMAIL';

		if(!isset($_POST['id']) && checkCurrentUser($email)) {
			return array('user' => NULL, 'cart' => NULL, 'status' => 'DUPLICATE_EMAIL', 'register_status' => $registerStatus);
		}

		$nombre       = @trim($_POST['nombre']) OR NULL;
		$apellido     = @trim($_POST['apellido']) OR NULL;
		$direccion    = @trim($_POST['direccion']) OR NULL;
		$rut          = @trim($_POST['rut']) OR NULL;
		$celular      = @trim($_POST['celular']) OR NULL;
		$telefono     = @trim($_POST['telefono']) OR NULL;
		$departamento = @trim($_POST['departamento']) OR NULL;
		$ciudad       = @trim($_POST['ciudad']) OR NULL;
		$email2       = @trim($_POST['email2']) OR NULL;
		$email2       = @str_replace(" ", "", strtolower($email2)) OR NULL;
		$pass         = @trim($_POST['pass']) OR NULL;
		$pass2        = @trim($_POST['pass2']) OR NULL;

		if($nombre == '') {
			$registerStatus['status']                    = 'ERROR';
			$registerStatus['fields_messages']['nombre'] = 'REQUIRED';
		}
		if($apellido == '') {
			$registerStatus['status']                      = 'ERROR';
			$registerStatus['fields_messages']['apellido'] = 'REQUIRED';
		}
		if($celular == '') {
			$registerStatus['status']                     = 'ERROR';
			$registerStatus['fields_messages']['celular'] = 'REQUIRED';
		}
		if($email == '') {
			$registerStatus['status']                   = 'ERROR';
			$registerStatus['fields_messages']['email'] = 'REQUIRED';
		}
		if($email2 == '') {
			$registerStatus['status']                    = 'ERROR';
			$registerStatus['fields_messages']['email2'] = 'REQUIRED';
		}
		if($pass == '') {
			$registerStatus['status']                  = 'ERROR';
			$registerStatus['fields_messages']['pass'] = 'REQUIRED';
		}
		if($pass2 == '') {
			$registerStatus['status']                   = 'ERROR';
			$registerStatus['fields_messages']['pass2'] = 'REQUIRED';
		}

		// Check email wellformed
		if(!preg_match('/^[a-z0-9]+[a-z0-9_.-]+@[a-z0-9_.-]+$/', $email)) {
			$registerStatus['status']                   = 'ERROR';
			$registerStatus['fields_messages']['email'] = 'EMAIL_MALFORMED';
		}

		// Check for repeated emails
		if($email != $email2) {
			$registerStatus['status']                    = 'ERROR';
			$registerStatus['fields_messages']['email2'] = 'INCORRECT_EMAIL';
		}

		// Check for repeated passwords
		if($pass != $pass2) {
			$registerStatus['status']                    = 'ERROR';
			$registerStatus['fields_messages']['pass2'] = 'INCORRECT_PASS';
		}
	} else {
		return array('user' => NULL, 'cart' => NULL,  'status' => 'READY_TO_LOGIN');
	}

	if($registerStatus['status'] == 'ERROR') {
		return array('user' => NULL, 'cart' => NULL,  'status' => 'MISSING_REQUIRED_FIELDS', 'register_status' => $registerStatus);
	}

	$db = $GLOBALS['db'];

	if(!isset($_POST['id'])) {
		$sql = 'INSERT INTO `usuario` (`nombre`, `apellido`, `rut`, `email`, `clave`, `codigo`, `direccion`, `telefono`, `celular`, `departamento`, `ciudad`, `administrador`) VALUES ("'.$nombre.'","'.$apellido.'","'.$rut.'","'.$email.'","'.md5($pass.$email).'","'.md5($email).'","'.$direccion.'","'.$telefono.'","'.$celular.'","'.$departamento.'","'.$ciudad.'",0)';
	} else {
		$sql = 'UPDATE `usuario` SET ';

		if($nombre != "") {
			$sql .= '`nombre` = "'.$nombre.'",';
		}
		if($apellido != "") {
			$sql .= '`apellido` = "'.$apellido.'",';
		}
		if($rut != "") {
			$sql .= '`rut` = "'.$rut.'",';
		}
		if($email != "") {
			$sql .= '`email` = "'.$email.'",';
		}
		if($pass != "") {
			$sql .= '`clave` = "'.md5($pass.$email).'",';
		}
		if($direccion != "") {
			$sql .= '`direccion` = "'.$direccion.'",';
		}
		if($telefono != "") {
			$sql .= '`telefono` = "'.$telefono.'",';
		}
		if($celular != "") {
			$sql .= '`celular` = "'.$celular.'",';
		}
		if($departamento != "") {
			$sql .= '`departamento` = "'.$departamento.'",';
		}
		if($ciudad != "") {
			$sql .= '`ciudad` = "'.$ciudad.'",';
		}

		$sql  = substr($sql, 0, -1);
		$sql .= ' WHERE `id` = '.$_POST['id'];
	}

	$cid = $db->insert($sql);

	if(isset($_POST['id'])) {
		$res = loginUser($email, $pass, true);
		$res['register_status'] = $registerStatus;

		return $res;
	} elseif($cid != 0) {
		// TODO - enviar email con código de activación
		
		// Guardo el registro en sesion para verificar la bienvenida
		$_SESSION['registered'] = true;
		// Redirecciono a página de bienvenida
		header('Location: /registro/bienvenida/');
	}

	return array('user' => NULL, 'cart' => NULL,  'status' => 'ERROR_SAVING');

}

function checkCurrentUser ($email) {

	$db = $GLOBALS['db'];
	// $sql = 'SELECT COUNT(id) AS usuarios FROM `dev_usuario` WHERE `email` = "' . $email . '"';
	$sql = 'SELECT COUNT(id) AS usuarios FROM `usuario` WHERE `email` = "' . $email . '"';
	$r = $db->getObjeto($sql);

	if ($r->usuarios == 0) {

		return false;

	}

	return true;

}

function checkUsers () {

	$db = $GLOBALS['db'];
	// $sql = 'SELECT COUNT(id) AS usuarios FROM `dev_usuario`';
	$sql = 'SELECT COUNT(id) AS usuarios FROM `usuario`';
	$r = $db->getObjeto($sql);

	if ($r->usuarios == 0) {

		return false;

	}

	return true;

}

function obtenerUsuarios($id = null) {

	$db = $GLOBALS['db'];
	// $sql = 'SELECT `id`, `nombre`, `apellido`, `rut`, `email`, `direccion`, `telefono`, `celular`, `departamento`, `ciudad`, `administrador`, SUM(`) FROM `usuario` WHERE 1';
	// $sql = 'SELECT usuario.id, usuario.nombre, usuario.apellido, usuario.rut, usuario.email, usuario.direccion, usuario.telefono, usuario.celular, usuario.departamento, usuario.ciudad, SUM(pedido.total) AS total_pedidos FROM pedido JOIN usuario ON pedido.usuario_id = usuario.id GROUP BY usuario.id'
	// $sql = 'SELECT * FROM (SELECT dev_usuario.id, dev_usuario.nombre, dev_usuario.apellido, dev_usuario.rut, dev_usuario.email, dev_usuario.direccion, dev_usuario.telefono, dev_usuario.celular, dev_usuario.departamento, dev_usuario.ciudad, SUM(dev_pedido.total) AS total_pedidos FROM dev_pedido RIGHT JOIN dev_usuario ON dev_pedido.usuario_id = dev_usuario.id WHERE dev_pedido.estado = 1 OR dev_pedido.usuario_id IS NULL GROUP BY dev_usuario.id UNION SELECT dev_usuario.id, dev_usuario.nombre, dev_usuario.apellido, dev_usuario.rut, dev_usuario.email, dev_usuario.direccion, dev_usuario.telefono, dev_usuario.celular, dev_usuario.departamento, dev_usuario.ciudad, NULL AS total_pedidos FROM dev_pedido RIGHT JOIN dev_usuario ON dev_pedido.usuario_id = dev_usuario.id WHERE dev_pedido.estado != 1 GROUP BY dev_usuario.id) AS usuarios GROUP BY usuarios.id ORDER BY `usuarios`.`total_pedidos` DESC';
	$sql = 'SELECT * FROM (SELECT usuario.id, usuario.nombre, usuario.apellido, usuario.rut, usuario.email, usuario.direccion, usuario.telefono, usuario.celular, usuario.departamento, usuario.ciudad, SUM(pedido.total) AS total_pedidos FROM pedido RIGHT JOIN usuario ON pedido.usuario_id = usuario.id WHERE pedido.estado = 1 OR pedido.usuario_id IS NULL GROUP BY usuario.id UNION SELECT usuario.id, usuario.nombre, usuario.apellido, usuario.rut, usuario.email, usuario.direccion, usuario.telefono, usuario.celular, usuario.departamento, usuario.ciudad, NULL AS total_pedidos FROM pedido RIGHT JOIN usuario ON pedido.usuario_id = usuario.id WHERE pedido.estado != 1 GROUP BY usuario.id) AS usuarios GROUP BY usuarios.id ORDER BY `usuarios`.`total_pedidos` DESC';

	$r = $db->getObjetos($sql);

	return $r;

}

function getCategory () {

	$cat;

	if (isset($_GET['c']) && $_GET['c'] != 'new' && $_GET['c'] != 'save') {

		$db = $GLOBALS['db'];
		// $sql = 'SELECT `id`, `titulo`, `descripcion_breve`, `descripcion`, `imagen_url`, `categoria_id`, `estado`, `orden` FROM `dev_categoria` WHERE id = ' . $_GET['c'];
		$sql = 'SELECT `id`, `titulo`, `descripcion_breve`, `descripcion`, `imagen_url`, `categoria_id`, `estado`, `orden` FROM `categoria` WHERE id = ' . $_GET['c'];

		$cat = $db->getObjeto($sql);

	} elseif(isset($_GET['ofertas']) && $_GET['ofertas'] == 1) {

		$cat = new stdClass();
		$cat->id = -1;
		$cat->titulo = 'Ofertas Monique';
		$cat->descripcion_breve = 'Encuentra todos los artículos en oferta en Monique';
		$cat->descripcion = '';
		$cat->imagen_url = '';
		$cat->categoria_id = NULL;
		$cat->estado = NULL;		

	} else {

		$cat = new stdClass();
		$cat->id = 0;
		$cat->titulo = 'Todas las categorías';
		$cat->descripcion_breve = 'Explore las categorias para encontrar el artículo que busca';
		$cat->descripcion = '';
		$cat->imagen_url = '';
		$cat->categoria_id = NULL;
		$cat->estado = NULL;

	}

	$cat->subcategorias = getCategories($cat->id);
	$cat->articulos = getArticles($cat->id);

	return $cat;
}

function getCategories ($parentId = NULL) {

	$cats;

	$db = $GLOBALS['db'];
	// $sql = 'SELECT `id`, `titulo`, `descripcion_breve`, `descripcion`, `imagen_url`, `categoria_id`, `estado`, `orden` FROM `dev_categoria` WHERE `categoria_id` = ' . $parentId . ' ORDER BY `orden` ASC';
	$sql = 'SELECT `id`, `titulo`, `descripcion_breve`, `descripcion`, `imagen_url`, `categoria_id`, `estado`, `orden` FROM `categoria` WHERE `categoria_id` = ' . $parentId . ' ORDER BY `orden` ASC';
	$cats = $db->getObjetos($sql);

	return (count($cats) > 0) ? $cats : array();

}

function getArticles ($parentId = NULL) {

	$arts;

	$db = $GLOBALS['db'];

	if($parentId == -1) {

		// $sql = 'SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `adaptable`, `colores_url`, `packs`, `imagenes_url`, `categoria_id`, `estado`, `nuevo`, `agotado`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido`, `orden` FROM `dev_articulo` WHERE `oferta` = 1 ORDER BY `orden` ASC';
		$sql = 'SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `adaptable`, `colores_url`, `packs`, `imagenes_url`, `categoria_id`, `estado`, `nuevo`, `agotado`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido`, `orden` FROM `articulo` WHERE `oferta` = 1 ORDER BY `orden` ASC';

	} else {

		// $sql = 'SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `adaptable`, `colores_url`, `packs`, `imagenes_url`, `categoria_id`, `estado`, `nuevo`, `agotado`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido`, `orden` FROM `dev_articulo` WHERE `categoria_id` = ' . $parentId . ' ORDER BY `orden` ASC';
		$sql = 'SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `adaptable`, `colores_url`, `packs`, `imagenes_url`, `categoria_id`, `estado`, `nuevo`, `agotado`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido`, `orden` FROM `articulo` WHERE `categoria_id` = ' . $parentId . ' ORDER BY `orden` ASC';

	}

	$arts = $db->getObjetos($sql);

	return (count($arts) > 0) ? $arts : array();

}

function buscarArticulos ($busqueda = NULL) {

	$palabras_buscadas = explode(" ", $busqueda);
	$resultado_ = array();
	foreach ($palabras_buscadas as $palabra) {

		switch ($palabra) {

			default:
			$resultado_[] = $palabra;
			continue;
			break;

			case 'camisas':
			$resultado_[] = "camisa";
			continue;
			break;

			case 'pantalones':
			$resultado_[] = "pantalón";
			continue;
			break;

			case 'pantalon':
			$resultado_[] = "pantalón";
			continue;
			break;

			case 'buzos':
			$resultado_[] = "buzo";
			continue;
			break;

			case 'poleras':
			$resultado_[] = "polera";
			continue;
			break;

			case 'rompevientos':
			case 'rompe vientos':
			case 'rompe viento':
			$resultado_[] = "rompeviento";
			continue;
			break;

			case 'sacos':
			$resultado_[] = "saco";
			continue;
			break;

			case 'camperas':
			$resultado_[] = "campera";
			continue;
			break;

			case 'blusas':
			$resultado_[] = "blusa";
			continue;
			break;

			case 'minifaldas':
			case 'mini faldas':
			case 'mini falda':
			$resultado_[] = "minifalda";
			continue;
			break;

			case 'shorts':
			$resultado_[] = "short";
			continue;
			break;

		}

	}

	$busqueda_ = implode(" ", $resultado_);

	$arts;

	$db = $GLOBALS['db'];
	// $sql = 'SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `adaptable`, `colores_url`, `packs`, `imagenes_url`, `categoria_id`, `estado`, `nuevo`, `agotado`, `surtido`, `orden` FROM `dev_articulo` WHERE `codigo` LIKE "%' . $busqueda_ . '%" OR `nombre` LIKE "%' . $busqueda_ . '%" ORDER BY `orden` ASC';
	$sql = 'SELECT `id`, `nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `adaptable`, `colores_url`, `packs`, `imagenes_url`, `categoria_id`, `estado`, `nuevo`, `agotado`, `surtido`, `orden` FROM `articulo` WHERE `codigo` LIKE "%' . $busqueda_ . '%" OR `nombre` LIKE "%' . $busqueda_ . '%" ORDER BY `orden` ASC';
	$arts = $db->getObjetos($sql);

	return (count($arts) > 0) ? $arts : array();

}

/* ADMINISTRACION */
function returnIfNotAdmin() {
	$userStats = $GLOBALS['userStats'];

	if(!$userStats['user'] || $userStats['user']->administrador != 1) {
		header('HTTP/1.0 404 Not Found');
		header('Location: /');
		exit;
	}
}
function saveCategory () {

	if (isset($_POST['type']) && $_POST['type'] == 'category') {

		if (isset($_POST['save'])) {

			if (isset($_POST['id']) && $_POST['id'] != "") {

				updateCategory($_POST['id']);
				return;

			}

			$relative = $GLOBALS['relative'];

			$imageLocation = ($_FILES['imagen']['error'] == 0) ? '/statics/images/categories/{id}' : '';

			$db = $GLOBALS['db'];
			// $sql = 'INSERT INTO `dev_categoria` (`titulo`, `descripcion_breve`, `descripcion`, `imagen_url`, `categoria_id`, `estado`, `orden`) VALUES ("' . $_POST['titulo'] . '","' . $_POST['descripcion_breve'] . '","' . $_POST['descripcion'] . '","' . $imageLocation . '","' . $_POST['categoria_id'] . '", 1, ' . $_POST['orden'] . ')';
			$sql = 'INSERT INTO `categoria` (`titulo`, `descripcion_breve`, `descripcion`, `imagen_url`, `categoria_id`, `estado`, `orden`) VALUES ("' . $_POST['titulo'] . '","' . $_POST['descripcion_breve'] . '","' . $_POST['descripcion'] . '","' . $imageLocation . '","' . $_POST['categoria_id'] . '", 1, ' . $_POST['orden'] . ')';
			$cid = $db->insert($sql);

			$imageLocation = $relative . '/statics/images/categories/' . $cid;
			
			// creo la carpeta para las immagenes de esta categoria
			mkdir($imageLocation);

			// salvar imagen
			$img = new upload($_FILES['imagen']);
			if ($img->uploaded) {

				$img->image_x = 200;
				$img->file_new_name_body = 'thumbnail';
				$img->image_convert = 'jpg';
				$img->process($imageLocation);

			}

			return;
			
		}

		if (isset($_POST['delete'])) {

			deleteCategory($_POST['id']);

		}

	}

}

function updateCategory ($id = NULL) {

	if ($id) {

		$db = $GLOBALS['db'];
		$imageLoc = '/statics/images/categories/{id}';
		// $sql = 'UPDATE `dev_categoria` SET `titulo`="' . $_POST['titulo'] . '", `descripcion_breve`="' . $_POST['descripcion_breve'] . '", `descripcion`="' . $_POST['descripcion'] . '", `categoria_id`="' . $_POST['categoria_id'] . '", `imagen_url` = "' . $imageLoc . '", `orden` = ' . $_POST['orden'] . ' WHERE `id`=' . $id;
		$sql = 'UPDATE `categoria` SET `titulo`="' . $_POST['titulo'] . '", `descripcion_breve`="' . $_POST['descripcion_breve'] . '", `descripcion`="' . $_POST['descripcion'] . '", `categoria_id`="' . $_POST['categoria_id'] . '", `imagen_url` = "' . $imageLoc . '", `orden` = ' . $_POST['orden'] . ' WHERE `id`=' . $id;

		$cid = $db->insert($sql);

		$relative = $GLOBALS['relative'];
		$imageLocation = $relative . '/statics/images/categories/' . $id;
		
		// creo la carpeta para las immagenes de esta categoria
		@mkdir($imageLocation);

		if($_FILES['imagen']['error'] == 0) {

			// salvar imagen
			@unlink($imageLocation . '/thumbnail.jpg');
			$img = new upload($_FILES['imagen']);
			if ($img->uploaded) {

				$img->image_x = 200;
				$img->file_new_name_body = 'thumbnail';
				$img->image_convert = 'jpg';
				$img->process($imageLocation);

			}

		}

	}

}

function deleteCategory ($id = NULL) {

	if ($id) {

		$db = $GLOBALS['db'];
		// $sql = 'DELETE FROM `dev_categoria` WHERE `id`=' . $id;
		$sql = 'DELETE FROM `categoria` WHERE `id`=' . $id;

		$cid = $db->insert($sql);

	}

}

function saveArticle () {

	if (isset($_POST['type']) && $_POST['type'] == 'article') {

		if (isset($_POST['save'])) {

			if (isset($_POST['id']) && $_POST['id'] != "") {

				updateArticle($_POST['id']);
				return;

			}

			$relative = $GLOBALS['relative'];

			$imagesLocation = ($_FILES['imagen']['error'] == 0) ? '/statics/images/articles/{id}/' : '';
			$colorsLocation = ($_FILES['colores']['error'][0] == 0) ? '/statics/images/articles/{id}/colors/' : '';

			$db = $GLOBALS['db'];
			// $sql = 'INSERT INTO `dev_articulo` (`nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `adaptable`, `colores_url`, `packs`, `categoria_id`, `imagenes_url`, `estado`, `nuevo`, `agotado`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido`, `orden`) VALUES ("' . $_POST['nombre'] . '","' . $_POST['codigo'] . '","' . $_POST['descripcion_breve'] . '","' . $_POST['descripcion'] . '","' . $_POST['talle'] . '","' . ($_POST['adaptable'] == "on" ? 1 : 0) . '","' . $colorsLocation . '","' . $_POST['packs'] . '","' . $_POST['categoria_id'] . '","' . $imagesLocation . '", 1, "' . ($_POST['nuevo'] == "on" ? 1 : 0) . '", "' . ($_POST['agotado'] == "on" ? 1 : 0) . '", "' . ($_POST['oferta'] == "on" ? 1 : 0) . '", "' . ($_POST['surtido'] == "on" ? 1 : 0) . '", "' . $_POST['precio'] . '", "' . $_POST['precio_oferta'] . '", "' . $_POST['precio_surtido'] . '", "' . $_POST['precio_oferta_surtido'] . '", ' . $_POST['orden'] . ')';
			$sql = 'INSERT INTO `articulo` (`nombre`, `codigo`, `descripcion_breve`, `descripcion`, `talle`, `adaptable`, `colores_url`, `packs`, `categoria_id`, `imagenes_url`, `estado`, `nuevo`, `agotado`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido`, `orden`) VALUES ("' . $_POST['nombre'] . '","' . $_POST['codigo'] . '","' . $_POST['descripcion_breve'] . '","' . $_POST['descripcion'] . '","' . $_POST['talle'] . '","' . ($_POST['adaptable'] == "on" ? 1 : 0) . '","' . $colorsLocation . '","' . $_POST['packs'] . '","' . $_POST['categoria_id'] . '","' . $imagesLocation . '", 1, "' . ($_POST['nuevo'] == "on" ? 1 : 0) . '", "' . ($_POST['agotado'] == "on" ? 1 : 0) . '", "' . ($_POST['oferta'] == "on" ? 1 : 0) . '", "' . ($_POST['surtido'] == "on" ? 1 : 0) . '", "' . $_POST['precio'] . '", "' . $_POST['precio_oferta'] . '", "' . $_POST['precio_surtido'] . '", "' . $_POST['precio_oferta_surtido'] . '", ' . $_POST['orden'] . ')';
			$cid = $db->insert($sql);

			$imageLocation = $relative . '/statics/images/articles/' . $cid;
			$colorLocation = $relative . '/statics/images/articles/' . $cid . '/colors/';
			
			// creo la carpeta para las imagenes de este artículo
			@mkdir($imageLocation);
			@unlink($imageLocation . '/thumbnail.jpg');
			
			// salvar imagen
			$img = new upload($_FILES['imagen']);
			if ($img->uploaded) {

				// $img->image_resize = true;
				// $img->image_ratio_y = true;
				// $img->image_x = 300;
				$img->file_new_name_body = 'thumbnail';
				$img->image_convert = 'jpg';
				$img->process($imageLocation);

			}
			
			@mkdir($colorLocation);
			@unlink($colorLocation . '/colors.jpg');
			
			// salvar colores
			$colorsNum = count($_FILES['colores']['name']);
			
			for($i = 0; $i < $colorsNum; $i++) {
				
				$currentColor			  = array();
				$currentColor['name']	  = $_FILES['colores']['name'][$i];
				$currentColor['type']     = $_FILES['colores']['type'][$i];
				$currentColor['tmp_name'] = $_FILES['colores']['tmp_name'][$i];
				$currentColor['error']    = $_FILES['colores']['error'][$i];
				$currentColor['size']     = $_FILES['colores']['size'][$i];
				
				$colorName = (string) $i + 1;
				$colorName = (strlen($colorName) < 2 ? '0'.$colorName : $colorName);
				
				$color = new upload($currentColor);
				if ($color->uploaded) {

					$color->file_new_name_body = $colorName;
					$color->image_convert = 'jpg';
					$color->process($colorLocation);
	
				}
			}
			
		}

		if (isset($_POST['delete'])) {

			deleteArticle($_POST['id']);

		}

	}

}

function updateArticle ($id) {

	if ($id) {

		$db = $GLOBALS['db'];
		$imageLoc = '/statics/images/articles/{id}/';
		$colorLoc = '/statics/images/articles/{id}/colors/';
		
		// $sql = 'UPDATE `dev_articulo` SET `nombre`="' . $_POST['nombre'] . '", `codigo`="' . $_POST['codigo'] . '", `descripcion_breve`="' . $_POST['descripcion_breve'] . '", `descripcion`="' . $_POST['descripcion'] . '", `talle`="' . $_POST['talle'] . '", `adaptable`="' . ($_POST['adaptable'] == "on" ? 1 : 0) . '", `colores_url` = "' . $colorLoc . '", `packs`="' . $_POST['packs'] . '", `categoria_id`="' . $_POST['categoria_id'] . '", `imagenes_url` = "' . $imageLoc . '", `orden`=' . $_POST['orden'] . ', `nuevo`=' . ($_POST['nuevo'] == "on" ? 1 : 0) . ', `agotado`=' . ($_POST['agotado'] == "on" ? 1 : 0) . ', `oferta`=' . ($_POST['oferta'] == "on" ? 1 : 0) . ', `surtido`=' . ($_POST['surtido'] == "on" ? 1 : 0) . ', `precio`="' . $_POST['precio'] . '", `precio_oferta`=' . (isset($_POST['precio_oferta']) ? $_POST['precio_oferta'] : 0 ) . ', `precio_surtido`=' . (isset($_POST['precio_surtido']) ? $_POST['precio_surtido'] : 0 ) . ', `precio_oferta_surtido`=' . (isset($_POST['precio_oferta_surtido']) ? $_POST['precio_oferta_surtido'] : 0 ) . ' WHERE `id`=' . $id;
		$sql = 'UPDATE `articulo` SET `nombre`="' . $_POST['nombre'] . '", `codigo`="' . $_POST['codigo'] . '", `descripcion_breve`="' . $_POST['descripcion_breve'] . '", `descripcion`="' . $_POST['descripcion'] . '", `talle`="' . $_POST['talle'] . '", `adaptable`="' . ($_POST['adaptable'] == "on" ? 1 : 0) . '", `colores_url` = "' . $colorLoc . '", `packs`="' . $_POST['packs'] . '", `categoria_id`="' . $_POST['categoria_id'] . '", `imagenes_url` = "' . $imageLoc . '", `orden`=' . $_POST['orden'] . ', `nuevo`=' . ($_POST['nuevo'] == "on" ? 1 : 0) . ', `agotado`=' . ($_POST['agotado'] == "on" ? 1 : 0) . ', `oferta`=' . ($_POST['oferta'] == "on" ? 1 : 0) . ', `surtido`=' . ($_POST['surtido'] == "on" ? 1 : 0) . ', `precio`="' . $_POST['precio'] . '", `precio_oferta`=' . (isset($_POST['precio_oferta']) ? $_POST['precio_oferta'] : 0 ) . ', `precio_surtido`=' . (isset($_POST['precio_surtido']) ? $_POST['precio_surtido'] : 0 ) . ', `precio_oferta_surtido`=' . (isset($_POST['precio_oferta_surtido']) ? $_POST['precio_oferta_surtido'] : 0 ) . ' WHERE `id`=' . $id;

		$cid = $db->insert($sql);

		$relative = $GLOBALS['relative'];
		$imageLocation = $relative . '/statics/images/articles/' . $id;
		$colorLocation = $relative . '/statics/images/articles/' . $id . '/colors/';

		// creo la carpeta para las imagenes de este artículo
		@mkdir($imageLocation);

		if($_FILES['imagen']['error'] == 0) {

			// salvar imagen
			@unlink($imageLocation . '/thumbnail.jpg');
			$img = new upload($_FILES['imagen']);
			if ($img->uploaded) {

				$img->file_new_name_body = 'thumbnail';
				$img->image_convert = 'jpg';
				$img->process($imageLocation);

			}
		}
		
		if($_FILES['colores']['error'][0] == 0) {
			// salvar colores
			@unlink($imageLocation . '/colors.jpg');
			$oldColors = glob($colorLocation.'*'); // get all file names
			
			foreach($oldColors as $oldColor) {
				unlink($oldColor);
			}
			
			// salvar colores
			$colorsNum = count($_FILES['colores']['name']);
			
			for($i = 0; $i < $colorsNum; $i++) {
				
				$currentColor			  = array();
				$currentColor['name']	  = $_FILES['colores']['name'][$i];
				$currentColor['type']     = $_FILES['colores']['type'][$i];
				$currentColor['tmp_name'] = $_FILES['colores']['tmp_name'][$i];
				$currentColor['error']    = $_FILES['colores']['error'][$i];
				$currentColor['size']     = $_FILES['colores']['size'][$i];
				
				$colorName = (string) $i + 1;
				$colorName = (strlen($colorName) < 2 ? '0'.$colorName : $colorName);
				
				$color = new upload($currentColor);
				if ($color->uploaded) {

					$color->file_new_name_body = $colorName;
					$color->image_convert = 'jpg';
					$color->process($colorLocation);
	
				}
			}

		}

	}

}

function deleteArticle ($id) {

	if ($id) {

		$db = $GLOBALS['db'];
		// $sql = 'DELETE FROM `dev_articulo` WHERE `id`=' . $id;
		$sql = 'DELETE FROM `articulo` WHERE `id`=' . $id;

		$cid = $db->insert($sql);

	}

}

/* PEDIDOS */
function agregarAlPedido ($id, $cantidad, $esPack = 'true', $talle = NULL, $color = NULL) {

	$user = loadUser();

	if (!$user || $user == "") {

		return array('status' => 'error', 'error' => 'USER_UNAUTORIZED');

	}

	// checar si hay un pedido abierto (1 : pendiente, 2 : cancelado, 3 : aprobado, 4 : abierto, 5 : cerrado)
	$estafecha = time() - (2 * 24 * 60 * 60);
	$esPack = $esPack == 'true' ? true : false;

	$db = $GLOBALS['db'];
	// $sql_reuse = 'SELECT `id`, `fecha`, `total`, `cantidad`, `estado` FROM `dev_pedido` WHERE `usuario_id` = "' . $user['user']->id . '" AND `estado` = 4 AND `fecha` >= "' . date('Y/m/d', $estafecha) .'"';
	$sql_reuse = 'SELECT `id`, `fecha`, `total`, `cantidad`, `estado` FROM `pedido` WHERE `usuario_id` = "' . $user['user']->id . '" AND `estado` = 4 AND `fecha` >= "' . date('Y/m/d', $estafecha) .'"';
	$pedido = $db->getObjeto($sql_reuse);

	$pedidoId = NULL;

	if ($pedido) {

		// si hay pedido
		// guardo el id de este pedido
		$pedidoId = $pedido->id;

	} else {

		// creo el pedido con estado abierto
		$h = "-3";
		$hm = $h * 60; 
		$ms = $hm * 60;
		$gmdate = gmdate("Y-m-d H:i:s", time()+($ms));

		// $sql = 'INSERT INTO `dev_pedido` (`usuario_id`, `fecha`, `total`, `cantidad`, `estado`) VALUES ("' . $user['user']->id .'", "' . $gmdate . '", 0, 0, 4)';
		$sql = 'INSERT INTO `pedido` (`usuario_id`, `fecha`, `total`, `cantidad`, `estado`) VALUES ("' . $user['user']->id .'", "' . $gmdate . '", 0, 0, 4)';
		$pedidoId = $db->insert($sql);

		// controlar pedido, si no existe retornar error
		if (!$pedidoId) {

			return array('status' => 'error', 'error' => 'INVOICE_DOESNT_EXIST');

		}

		$pedido = $db->getObjeto($sql_reuse);

	}

	// obtengo el articulo para extraer los datos necesarios para el pedido
	// $sql = 'SELECT `packs`, `colores_url`, `talle`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido` FROM `dev_articulo` WHERE `id`=' . $id;
	$sql = 'SELECT `packs`, `colores_url`, `talle`, `oferta`, `surtido`, `precio`, `precio_oferta`, `precio_surtido`, `precio_oferta_surtido` FROM `articulo` WHERE `id`=' . $id;
	$articulo = $db->getObjeto($sql);
	
	// controlar articulo, si no existe retornar error
	if (!$articulo) {

		return array('status' => 'error', 'error' => 'ITEM_DOESNT_EXIST');

	}

	// actualizo el pedido con la cantidad y el total
	// $articulo_precio = ($articulo->oferta == 1 ? $articulo->precio_oferta : $articulo->precio);
	// echo '// ' . ($pedido->total + ($articulo_precio * ((int) str_replace(array("pack x", "pack x ", "X", "x", "X ", "x ", "packs x", "packs x ", "Packs X", "Packs X ", "PACKS X", "PACKS X ", "Pack x", "Pack x "), "", $articulo->packs) * $cantidad))) . "\n";
	// echo '// ' . ((int) str_replace(array("pack x", "pack x ", "X", "x", "X ", "x ", "packs x", "packs x ", "Packs X", "Packs X ", "PACKS X", "PACKS X ", "Pack x", "Pack x "), "", $articulo->packs)) . "\n";
	
	// Chequeo el precio si es pack o surtido y lo actualizo en el pedido
	if($esPack) {
		$articulo_precio = (($articulo->oferta == 1 && $articulo->precio_oferta > 0) ? $articulo->precio_oferta : $articulo->precio);
		$surtido = 0;
		
		// guardar todos los colores en $colors
		$colorsDir  = '../../..'.str_replace("{id}", $id, $articulo->colores_url);
		
		if(!is_dir($colorsDir)) {
			$colors = '0';
		} else {
			$colorsFiles = opendir($colorsDir);
			$colorsList = array();
			
			if(!$colorsFiles) {
				$colors = '0';
			} else {
				$auxColors = array();
				while($col = readdir($colorsFiles)) {
					if (!is_dir($col)) {
						// $colorsList[] = $col;
						$auxColors[] = basename($col, '.jpg');
					}
				}
				
				$colors = implode(',', $auxColors);
				
			}
			
		}
		
	} else {
		$articulo_precio = 0;
		// ($articulo->oferta == 1 ? $articulo->precio_oferta_surtido : $articulo->precio_surtido)
		if($articulo->oferta == 1) {
			$articulo_precio = ($articulo->precio_oferta_surtido > 0 ? $articulo->precio_oferta_surtido : ($articulo->precio_surtido > 0 ? $articulo->precio_surtido : ($articulo->precio_oferta > 0 ? $articulo->precio_oferta : $articulo->precio)));
		} else {
			$articulo_precio = ($articulo->precio_surtido > 0 ? $articulo->precio_surtido : $articulo->precio);
		}
		$colors = str_replace('color-'.$id.'-', '', $color);
		$surtido = 1;
	}
	
	$pack        = $esPack ? (int) str_replace(array("pack x", "pack x ", "X", "x", "X ", "x ", "packs x", "packs x ", "Packs X", "Packs X ", "PACKS X", "PACKS X ", "Pack x", "Pack x "), "", $articulo->packs) : 1;
	$subtotalArt = $articulo_precio * $pack * $cantidad;
	$totalPedido = $pedido->total + ($articulo_precio * $pack * $cantidad);
	$talle       = $esPack ? $articulo->talle : $talle;
	
	// $sql = 'UPDATE `dev_pedido` SET `total`=' . ($pedido->total + ($articulo_precio * ((int) str_replace(array("pack x", "pack x ", "X", "x", "X ", "x ", "packs x", "packs x ", "Packs X", "Packs X ", "PACKS X", "PACKS X ", "Pack x", "Pack x "), "", $articulo->packs) * $cantidad))) . ', `cantidad`=' . ($pedido->cantidad + 1) . ' WHERE `id`=' . $pedidoId;
	// $sql = 'UPDATE `dev_pedido` SET `total`=' . $totalPedido . ', `cantidad`=' . ($pedido->cantidad + 1) . ' WHERE `id`=' . $pedidoId;
	$sql = 'UPDATE `pedido` SET `total`=' . $totalPedido . ', `cantidad`=' . ($pedido->cantidad + 1) . ' WHERE `id`=' . $pedidoId;
	$db->insert($sql);

	// Guardo el articulo relacionado al pedido, en la tabla articulo_pedido
	// $sql = 'INSERT INTO `dev_articulo_pedido` (`pedido_id`, `articulo_id`, `precio_actual`, `surtido`, `talle`, `color`, `cantidad`, `subtotal`) VALUES (' . $pedidoId . ', ' . $id . ', ' . $articulo_precio . ', ' . $surtido . ', "' . $talle . '", "' . $colors . '", ' . ($pack * $cantidad) . ', ' . $subtotalArt  . ')';
	$sql = 'INSERT INTO `articulo_pedido` (`pedido_id`, `articulo_id`, `precio_actual`, `surtido`, `talle`, `color`, `cantidad`, `subtotal`) VALUES (' . $pedidoId . ', ' . $id . ', ' . $articulo_precio . ', ' . $surtido . ', "' . $talle . '", "' . $colors . '", ' . ($pack * $cantidad) . ', ' . $subtotalArt  . ')';
	$rId = $db->insert($sql);

	$pedido = $db->getObjeto($sql_reuse);

	if ($rId) {

		return array('status' => 'ok', 'pedido' => $pedido);

	} else {

		return array('status' => 'error', 'error' => 'DB_ERROR');

	}

}

function eliminarDelPedido ($idpedido, $itemid, $pedidoid, $precioitem, $cantidaditem, $totalpedido, $cantidaditemstotal) {

	$db = $GLOBALS['db'];
	// $sql = 'DELETE FROM `dev_articulo_pedido` WHERE `pedido_id`=' . $pedidoid . ' AND `articulo_id`=' . $itemid . ' AND `id`=' . $idpedido;
	$sql = 'DELETE FROM `articulo_pedido` WHERE `pedido_id`=' . $pedidoid . ' AND `articulo_id`=' . $itemid . ' AND `id`=' . $idpedido;
	$db->insert($sql);

	// $sql = 'SELECT COUNT(*) AS `cantidad_en_pedido`, SUM(`subtotal`) AS `total_en_pedido` FROM `dev_articulo_pedido` WHERE `pedido_id`=' . $pedidoid;
	$sql = 'SELECT COUNT(*) AS `cantidad_en_pedido`, SUM(`subtotal`) AS `total_en_pedido` FROM `articulo_pedido` WHERE `pedido_id`=' . $pedidoid;
	$articulos = $db->getObjeto($sql);

	// if(($cantidaditemstotal - $cantidaditem) > 0) {
	if ($articulos->cantidad_en_pedido > 0) {

		// $sql = 'UPDATE `pedido` SET `total`=' . ($totalpedido - $precioitem) . ', `cantidad`=' . ($cantidaditemstotal - $cantidaditem) . ' WHERE `id`=' . $pedidoid;
		// $sql = 'UPDATE `dev_pedido` SET `total`=' . $articulos->total_en_pedido . ', `cantidad`=' . $articulos->cantidad_en_pedido . ' WHERE `id`=' . $pedidoid;
		$sql = 'UPDATE `pedido` SET `total`=' . $articulos->total_en_pedido . ', `cantidad`=' . $articulos->cantidad_en_pedido . ' WHERE `id`=' . $pedidoid;

	} else {

		// $sql = 'DELETE FROM `dev_pedido` WHERE `id`=' . $pedidoid;
		$sql = 'DELETE FROM `pedido` WHERE `id`=' . $pedidoid;

	}

	$db->insert($sql);

	return array('status' => 'DELTE_SUCCESSFUL', 'articulos' => $articulos->cantidad_en_pedido, 'total' => $articulos->total_en_pedido);

}

function obtenerPedido ($idPedido) {

	$pedidoCompleto = array('articulos' => NULL, 'pedido' => NULL);

	$db = $GLOBALS['db'];
	// $sql = 'SELECT `dev_pedido`.*, `dev_usuario`.`nombre`, `dev_usuario`.`apellido`, `dev_usuario`.`rut`, `dev_usuario`.`telefono`, `dev_usuario`.`celular`, `dev_usuario`.`email`  FROM `dev_pedido` JOIN `dev_usuario` ON `dev_pedido`.`usuario_id` = `dev_usuario`.`id`  WHERE `dev_pedido`.`id`=' . $idPedido;
	$sql = 'SELECT `pedido`.*, `usuario`.`nombre`, `usuario`.`apellido`, `usuario`.`rut`, `usuario`.`telefono`, `usuario`.`celular`, `usuario`.`email`  FROM `pedido` JOIN `usuario` ON `pedido`.`usuario_id` = `usuario`.`id`  WHERE `pedido`.`id`=' . $idPedido;
	$pedidoCompleto['pedido'] = $db->getObjeto($sql);

	// $sql = 'SELECT `dev_articulo_pedido`.`id` AS `id_pedido`, `dev_articulo_pedido`.`cantidad`, `dev_articulo_pedido`.`subtotal`, `dev_articulo`.`id`, `dev_articulo`.`nombre`, `dev_articulo`.`codigo`, `dev_articulo_pedido`.`surtido`, `dev_articulo_pedido`.`talle`, `dev_articulo_pedido`.`color`, `dev_articulo`.`colores_url`, `dev_articulo`.`imagenes_url` FROM `dev_articulo_pedido` JOIN `dev_articulo` ON `dev_articulo_pedido`.`articulo_id`=`dev_articulo`.`id` WHERE `dev_articulo_pedido`.`pedido_id`=' . $idPedido;
	$sql = 'SELECT `articulo_pedido`.`id` AS `id_pedido`, `articulo_pedido`.`cantidad`, `articulo_pedido`.`subtotal`, `articulo`.`id`, `articulo`.`nombre`, `articulo`.`codigo`, `articulo_pedido`.`surtido`, `articulo_pedido`.`talle`, `articulo_pedido`.`color`, `articulo`.`colores_url`, `articulo`.`imagenes_url` FROM `articulo_pedido` JOIN `articulo` ON `articulo_pedido`.`articulo_id`=`articulo`.`id` WHERE `articulo_pedido`.`pedido_id`=' . $idPedido;
	$pedidoCompleto['articulos'] = $db->getObjetos($sql);

	return $pedidoCompleto;

}

function obtenerPedidoAbierto ($id_usuario = null) {

	$id_us = $id_usuario ? $id_usuario : JSON_decode($_SESSION['usuario'])->id;

	// DEBAGUEANDO
	// echo "<!-- DEBUG -->\n";
	// echo "<!-- \n";

	$estafecha = time() - (2 * 24 * 60 * 60);
	// print_r(date('Y/m/d', $estafecha));

	// echo "\n";

	// echo "-->\n";
	// echo "<!-- END DEBUG -->\n";

	// obtengo el pedido abierto
	$db = $GLOBALS['db'];
	// $sql = 'SELECT * FROM `dev_pedido` WHERE `estado` = 4 AND `usuario_id`=' . $id_us . ' AND `fecha` >= "' . date('Y/m/d', $estafecha) .'"';
	$sql = 'SELECT * FROM `pedido` WHERE `estado` = 4 AND `usuario_id`=' . $id_us . ' AND `fecha` >= "' . date('Y/m/d', $estafecha) .'"';
	$pedido = $db->getObjeto($sql);

	return $pedido;

}

function obtenerPedidos ($id_usuario = null, $estado = NULL) {

	$db = $GLOBALS['db'];
	// de momento selecciono todos los pedidos
	// $sql = 'SELECT `dev_pedido`.*, `dev_usuario`.`nombre`, `dev_usuario`.`apellido`, `dev_usuario`.`rut`, `dev_usuario`.`telefono`, `dev_usuario`.`celular`, `dev_usuario`.`email` FROM `dev_pedido` JOIN `dev_usuario` ON `dev_pedido`.`usuario_id`=`dev_usuario`.`id`';
	$sql = 'SELECT `pedido`.*, `usuario`.`nombre`, `usuario`.`apellido`, `usuario`.`rut`, `usuario`.`telefono`, `usuario`.`celular`, `usuario`.`email` FROM `pedido` JOIN `usuario` ON `pedido`.`usuario_id`=`usuario`.`id`';
	if ($id_usuario) {

		// le agrego el usuario, si se especifico el id
		$sql .= ' WHERE `usuario_id`=' . $id_usuario;

	}

	if ($estado) {

		if (!$id_usuario) {

			$sql .= ' WHERE';

		} else {

			$sql .= ' AND';

		}

		$sql .= ' `estado`=' . $estado;

	}

	$sql .= ' ORDER BY `estado` ASC';

	$pedidos = $db->getObjetos($sql);
	return $pedidos;

}

// TODO MIKE - Completar Pedido - tareas en el email
function completarPedido ($idPedido) {

	$db = $GLOBALS['db'];

	$lugar = ($_POST['lugar_compra'] == 'envio_interior' ? 'Interior' : ($_POST['lugar_compra'] == 'envio_montevideo' ? 'Montevideo' : ''));
	$retira = $_POST['retira_agencia'] == 'true' || $_POST['retira_local'] == 'true' ? 1 : 0;

	// $sql = 'UPDATE `dev_pedido` SET `estado`=1, `lugar`="' . $lugar . '", `retira`=' . $retira . ', `agencia_de_envio`="' . $_POST['agencia_entrega']. '", `direccion_de_entrega`="' . $_POST['direccion_entrega']. '", `forma_de_pago`="' . $_POST['forma_pago']. '" WHERE `id`=' . $idPedido;
	$sql = 'UPDATE `pedido` SET `estado`=1, `lugar`="' . $lugar . '", `retira`=' . $retira . ', `agencia_de_envio`="' . $_POST['agencia_entrega']. '", `direccion_de_entrega`="' . $_POST['direccion_entrega']. '", `forma_de_pago`="' . $_POST['forma_pago']. '" WHERE `id`=' . $idPedido;

	// agregar direccion del usuario, agencia de entrega y forma de pago al pedido
	$db->insert($sql);

	// $ordenSQL = 'SELECT * FROM `dev_pedido` WHERE `id`=' . $idPedido;
	$ordenSQL = 'SELECT * FROM `pedido` WHERE `id`=' . $idPedido;
	$ordenOBJ = $db->getObjeto($ordenSQL);

	// $usuarioSQL = 'SELECT * FROM `dev_usuario` WHERE `id`=' . $ordenOBJ->usuario_id;
	$usuarioSQL = 'SELECT * FROM `usuario` WHERE `id`=' . $ordenOBJ->usuario_id;
	$usuarioOBJ = $db->getObjeto($usuarioSQL);

	// $pedidoSQL = 'SELECT `dev_articulo_pedido`.`id`, `dev_articulo_pedido`.`articulo_id`, `dev_articulo_pedido`.`precio_actual`, `dev_articulo_pedido`.`cantidad`, `dev_articulo_pedido`.`subtotal`, `dev_articulo`.`codigo`, `dev_articulo`.`nombre`,`dev_articulo_pedido`.`talle`, `dev_articulo_pedido`.`surtido`, `dev_articulo_pedido`.`color`, `dev_articulo`.`colores_url` FROM `dev_articulo_pedido` JOIN `dev_articulo` ON `dev_articulo_pedido`.`articulo_id`=`dev_articulo`.`id` WHERE `pedido_id`=' . $idPedido;
	$pedidoSQL = 'SELECT `articulo_pedido`.`id`, `articulo_pedido`.`articulo_id`, `articulo_pedido`.`precio_actual`, `articulo_pedido`.`cantidad`, `articulo_pedido`.`subtotal`, `articulo`.`codigo`, `articulo`.`nombre`,`articulo_pedido`.`talle`, `articulo_pedido`.`surtido`, `articulo_pedido`.`color`, `articulo`.`colores_url`, `articulo`.`imagenes_url` FROM `articulo_pedido` JOIN `articulo` ON `articulo_pedido`.`articulo_id`=`articulo`.`id` WHERE `pedido_id`=' . $idPedido;
	$pedidoOBJ = $db->getObjetos($pedidoSQL);

	// $para = "Monique.com.uy <moniqueindumentaria@hotmail.com>";
	$asunto = '(Monique.com.uy - Pedido) Orden N. ' . $idPedido;
	// $asunto = '(Monique.com.uy - Pedido de prueba) Orden N. ' . $idPedido;
	$mensaje = ''.

	'<h2><a href="http://monique.com.uy/detalle?id=' . $idPedido . '">Orden N. ' . $idPedido . '</a></h2>'.
	'<p><strong>Fecha:</strong> ' . $ordenOBJ->fecha . '</p>'.
	'<p><strong>Nombre:</strong> ' . $usuarioOBJ->nombre . ' ' . $usuarioOBJ->apellido . '</p>'.
	'<p><strong>RUT:</strong> ' . $usuarioOBJ->rut . '</p>'.
	'<p><strong>Teléfono:</strong> ' . $usuarioOBJ->telefono . (($usuarioOBJ->celular != "") ? ' / ' . $usuarioOBJ->celular : '') . '</p>'.
	'<p><strong>Email:</strong> ' . $usuarioOBJ->email . '</p>';

	// TODO MIKE - Agregar al pedido datos de pago / No de Cuenta BROU, ABITAB o RED PAGOS según el método
	// $mensaje .= 'Método de pago';

	$mensaje .=
	'<p><strong>Compra en '.$lugar.'</strong></p>';

	// Interior
	// Montevideo
	if($lugar == 'Interior') {
		if($retira) {

			$mensaje .=
			'<p><strong>Retira en Agencia</strong></p>'.
			'<p><strong>Localidad:</strong> ' . $usuarioOBJ->departamento . ', ' . $usuarioOBJ->ciudad . '</p>';

		} else {

			$mensaje .=

			'<p><strong>Envio al Interior</strong></p>'.
			'<p><strong>Localidad:</strong> ' . $usuarioOBJ->departamento . ', ' . $usuarioOBJ->ciudad . '</p>'.
			'<p><strong>Dirección de entrega:</strong> ' . $ordenOBJ->direccion_de_entrega . '</p>';

		}

		$mensaje .=
		'<p><strong>Agencia de Envío:</strong> ' . $ordenOBJ->agencia_de_envio . '</p>'.
		'<p><strong>Forma de Pago:</strong> ' . $ordenOBJ->forma_de_pago . '</p>';
	} elseif($lugar == 'Montevideo') {
		if($retira) {

			$mensaje .=
			'<p><strong>Retira y paga en local Monique.</strong></p>';

		} else {

			$mensaje .=
			'<p><strong>Envio en Montevideo</strong></p>'.
			'<p><strong>Dirección de entrega:</strong> ' . $ordenOBJ->direccion_de_entrega . '</p>'.
			'<p><strong>Forma de Pago:</strong> ' . $ordenOBJ->forma_de_pago . '</p>';
		}
	}

	// TODO MIKE - Agregar color y tamaño a los datos
	$mensaje .=
	'<table border="1">'.
		'<thead>'.
			'<tr>'.
				'<td>Código</td>'.
				'<td>Artículo</td>'.
				'<td>Surtido</td>'.
				'<td>Talles</td>'.
				'<td>Colores</td>'.
				'<td>Cantidad</td>'.
				'<td>Subtotal</td>'.
			'</tr>'.
		'</thead>'.
		'<tbody>';
			foreach($pedidoOBJ as $articulo) {

				$mensaje .=
				'<tr>'.
					'<td>' . $articulo->codigo . '</td>'.
					'<td>' . $articulo->nombre . '</td>'.
					'<td>' . ($articulo->surtido == 0 ? 'No' : 'Si') . '</td>'.
					'<td>' . $articulo->talle . '</td>'.
					'<td>';
					
				$colorsDir = '../../..'.str_replace("{id}", $articulo->articulo_id, $articulo->colores_url);
				$colorsDirAuxiliar = str_replace("{id}", $articulo->articulo_id, $articulo->colores_url);
				// $colorsDirForEmail = 'http://dev.monique.com.uy'.$colorsDirAuxiliar;
				$colorsDirForEmail = 'http://'.$_SERVER['SERVER_NAME'].$colorsDirAuxiliar;
				
				if($articulo->colores_url == $articulo->imagenes_url) {
					// <img src="..< ?php echo str_replace("{id}", $articulo->id, $articulo->imagenes_url); ? >colors.jpg">
					$mensaje .= '<img src="http://'.$_SERVER['SERVER_NAME'].str_replace("{id}", $articulo->articulo_id, $articulo->imagenes_url).'colors.jpg" />';
				} else {
					if(!is_dir($colorsDir)) {
						$mensaje .= '<span>No hay colores</span>';
					} else {
						$colorsFiles = opendir($colorsDir);
						$colorsList = array();
						if(!$colorsFiles) {
							$mensaje .= '<span>No hay colores</span>';
						} else {
							$mensaje .= 
							'<ul style="list-style:none;margin:0;padding:0;display:inline-block;">';
								$colores = explode(',', $articulo->color);
								foreach($colores AS $color) {
									$mensaje .= 
									'<li style="display:inline-block;">
										<span style="border-radius:8px;border-width:2px;border-style:solid;border-color:#ccc;width:14px;font-size:0px;display:inline-block;">
											<img src="'.$colorsDirForEmail.$color.'.jpg" style="border-radius:7px;" />
										</span>
									</li>';
								}
							$mensaje .= 
							'</ul>';
						}
					}
				}
					
				$mensaje .=
					'</td>' .
					'<td>' . $articulo->cantidad . '</td>'.
					'<td>$ ' . $articulo->subtotal . ',00</td>'.
				'</tr>';

			}

		$mensaje .=
		'</tbody>'.
	'</table>'.
	'<p><strong>TOTAL:</strong> $' . $ordenOBJ->total . ',00</p>';

	// echo $mensaje;
	// exit;

	$mail = new PHPMailer();

	// TODO - Poner emails acorde al sitio actual
	// $mail->addAddress('moniqueindumentaria@hotmail.com', 'Monique.com.uy');
	// $mail->addAddress('gahecht@hotmail.com', 'Gabriela Hecht');
	// $mail->addAddress('miguelmail2006@gmail.com', 'Monique.com.uy');
	// $mail->addAddress('miguelso18@hotmail.com', 'Monique.com.uy');
	// $mail->addAddress('esteban.leyton@hotmail.com', 'Monique.com.uy');
	// $mail->setFrom('monique@monique.com.uy', 'Monique - Pedidos Online');

	$mail->Subject = utf8_decode($asunto);
	// $mail->msgHTML(utf8_decode($mensaje));
	// $mail->msgHTML($mensaje);
	$mail->isHTML(true);
	$mail->Body = utf8_decode($mensaje);

	if ($mail->send()) {

		$mail->clearAddresses();
		$mail->addAddress($usuarioOBJ->email, $usuarioOBJ->nombre . ' ' . $usuarioOBJ->apellido);

		$linkareemplazar = '<a href="http://monique.com.uy/detalle?id=' . $idPedido . '">Orden N. ' . $idPedido . '</a>';
		$valornuevo = 'Orden N. ' . $idPedido;

		$msg = str_replace($linkareemplazar, $valornuevo, $mensaje);

		// $mail->msgHTML(utf8_decode($msg));
		$mail->Body = utf8_decode($mensaje);

		if ($mail->send()) {

			return array('status' => 'EMAIL_SENT', 'message' => $mensaje);

		} else {

			return array('status' => 'EMAIL_ERROR', 'error' => $mail->ErrorInfo);

		}

	} else {

		return array('status' => 'EMAIL_ERROR', 'error' => $mail->ErrorInfo);

	}

}

function aprobarPedido ($idPedido) {

	$db = $GLOBALS['db'];

	// agregar direccion del usuario, agencia de entrega y forma de pago al pedido
	// $sql = 'UPDATE `dev_pedido` SET `estado`=2 WHERE `id`=' . $idPedido;
	$sql = 'UPDATE `pedido` SET `estado`=2 WHERE `id`=' . $idPedido;
	$db->insert($sql);

	return array('status' => 'STATUS_UPDATED_SUCCESSFUL');

}

function cancelarPedido ($idPedido) {

	$db = $GLOBALS['db'];

	// agregar direccion del usuario, agencia de entrega y forma de pago al pedido
	// $sql = 'UPDATE `dev_pedido` SET `estado`=3 WHERE `id`=' . $idPedido;
	$sql = 'UPDATE `pedido` SET `estado`=3 WHERE `id`=' . $idPedido;
	$db->insert($sql);

	return array('status' => 'STATUS_UPDATED_SUCCESSFUL');

}

function posponerPedido ($idPedido) {

	$db = $GLOBALS['db'];

	// agregar direccion del usuario, agencia de entrega y forma de pago al pedido
	// $sql = 'UPDATE `dev_pedido` SET `estado`=1 WHERE `id`=' . $idPedido;
	$sql = 'UPDATE `pedido` SET `estado`=1 WHERE `id`=' . $idPedido;
	$db->insert($sql);

	return array('status' => 'STATUS_UPDATED_SUCCESSFUL');	

}

/* GENERAL */

function startDocument() {
?>
<!doctype html>
<html lang="es">
<head>

<?php
	$place = 'head';
	include(TEMPLATE_PATH.'includes.php');
	createAppObjects();
	?>

</head>
<body id="<?php echo $GLOBALS['appPlace'].($GLOBALS['appSubPlace'] != '' ? '-'.$GLOBALS['appSubPlace'] : '') ?>">
	
<?php
}

function endDocument () {
	$place = 'body-end';
	include(TEMPLATE_PATH.'includes.php');
?>

</body>
</html>

<?php
}

function loadHeader($template, $locationId = '') {
	include(TEMPLATE_PATH.$template.'.php');
	?>

	<div class="body">
		<div class="body-inner shadow-5">
			<div class="body-content">

	<?php
}

function loadFooter($template) {
	?>

			</div>
		</div>
	</div>

	<?php
	include(TEMPLATE_PATH.$template.'.php');
}

function loadSection($template, $data = null) {
	include(TEMPLATE_PATH.$template.'.php');
}

function createAppObjects() {
	?>
	<script>
	var userStats = <?php echo JSON_encode(@$GLOBALS['userStats']) ?>;
	</script>
	<?php
}

function custom_error_log($msg = null, $line = null, $file = null, $function = null) {
	// echo date('d/m/Y H:i:s').' :: '.$file.' :: '.$function.' :: '.$line.': '.$msg."\n";

    if(empty($msg)) {
        error_log(date('d/m/Y H:i:s').' :: '.__FILE__.' :: '.__FUNCTION__.' :: '.__LINE__.': $msg is null or empty'."\n", 3, "../../error.txt");
    }
    if(empty($line)) {
        error_log(date('d/m/Y H:i:s').' :: '.__FILE__.' :: '.__FUNCTION__.' :: '.__LINE__.': $line is null or empty'."\n", 3, "../../error.txt");
    }
    if(empty($file)) {
        error_log(date('d/m/Y H:i:s').' :: '.__FILE__.' :: '.__FUNCTION__.' :: '.__LINE__.': $line is null or empty'."\n", 3, "../../error.txt");
    }

    error_log(date('d/m/Y H:i:s').' :: '.$file.' :: '.$function.' :: '.$line.': '.$msg."\n", 3, "../../error.txt");
}

function checkConfig($config) {
	$db = new DB(trim($config['db_name']), trim($config['db_host']), trim($config['db_user']), trim($config['db_pass']));

	if($db->getStatus() == 'CONNECTED') {
		return array('status' => 'ok');
	} else {
		return array('status' => 'error');
	}
}

function saveConfig($config) {
	$relative = $GLOBALS['relative'];
	if(is_file($relative.'/includes/config.php')) {
		unlink($relative.'/includes/config.php');
	}

	$relative = $GLOBALS['relative'];
	$file = fopen($relative.'/includes/config.php', 'w');
	fwrite($file, '<?php'.PHP_EOL);
	fwrite($file, '$relative = $GLOBALS[\'relative\'];'.PHP_EOL);
	fwrite($file, '$config   = array('.PHP_EOL);
	fwrite($file, "	'templatesPath' => \$relative.'/templates/',".PHP_EOL);
	fwrite($file, "	'db_host'       => '".trim($config['db_host'])."',".PHP_EOL);
	fwrite($file, "	'db_user'       => '".trim($config['db_user'])."',".PHP_EOL);
	fwrite($file, "	'db_pass'       => '".trim($config['db_pass'])."',".PHP_EOL);
	fwrite($file, "	'db_name'       => '".trim($config['db_name'])."'".PHP_EOL);
	fwrite($file, ");".PHP_EOL);
	fwrite($file, '?>');
	fclose($file);

	if(is_file($relative.'/includes/config.php')) {
		return true;
	}
	return false;
}

function checkOnTables() {
	// 
}

function saveSiteSettings($post) {
	// SI no se han enviado datos, retorno estado ready to submit
	if(count($post) == 0) {
		return array('status' => 'READY_TO_SUBMIT');
	}

	$db            = $GLOBALS['db'];
	// Chequeo si hay configuración guardada
	$sql           = 'SELECT * FROM `configuracion`';
	$configuracion = $db->getObjeto($sql);


	if($configuracion) {
		// hago update de la configuracion
		var_dump($post);
		// $sql = '';
		// $cid = $db->insert($sql);
	} else {
		// inserto la nueva configuracion
		var_dump($post);
		$fields  = array();
		$values  = array();

		foreach($post as $field => $value) {
			if(trim($value) != '') {
				$fields[] = '`'.$field.'`';
				$values[] = '"'.$value.'"';
			}
		}

		if(count($fields)) {
			$fields = implode(', ', $fields);
			$values = implode(', ', $values);

			$sql = "INSERT INTO `configuracion` ($fields) VALUES ($values)";
		}

		var_dump($sql);
		// $cid = $db->insert($sql);
	}
}

?>
