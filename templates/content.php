	<div class="body">
		<div class="body-inner">
			<div class="body-content">
<?php

$appPlace = $GLOBALS['appPlace'];
$appSubPlace = isset($GLOBALS['appSubPlace']) ? $GLOBALS['appSubPlace'] : NULL;
$userStats = $GLOBALS['userStats'];
$templatesPath = $GLOBALS['config']['templatesPath'];

switch($appPlace) {

case 'categories':

	$categories = getCategories(0);
	$category = getCategory();
	if (isset($_GET['c']) && ($_GET['c'] == 'new' || $_GET['c'] == 'save')) {

		switch($_GET['c']) {

		case 'new':

			include($templatesPath . '/modals/new-category.php');

		break;
		case 'save':

			saveCategory();

		break;

		}

	}

	if (isset($_GET['a']) && ($_GET['a'] == 'new' || $_GET['a'] == 'save')) {

		switch($_GET['a']) {

		case 'new':

			include($templatesPath . '/modals/new-article.php');

		break;
		case 'save':

			saveArticle();

		break;

		}

	}

	$categories = getCategories(0);
	$category = getCategory();

	if (count($category->subcategorias) > 0) {

		include($templatesPath . 'categories.php');
		
	} else {

		include($templatesPath . 'articles.php');

	}

break;

case 'catalogs':

	include($templatesPath . 'catalogs.php');

break;

case 'online-history':

	include($templatesPath . 'catalogs.php');

break;

case 'contact':

	include($templatesPath . 'catalogs.php');

break;

}
?>