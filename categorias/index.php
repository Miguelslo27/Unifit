<?php

$relative = '..';
require '../includes/common.php';

$userStats     = loadUser();
$appPlace      = 'categories';
$appSubPlace   = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadHeader("header");

$categories = getCategories(0);
$category   = getCategory();

?>
			<div class="home-block">
				<div class="buy-left-column">

<?php include($templatesPath.'sidebar-categories.php') ?>

				</div>
				<span class="vertical-complete-line"></span>
				<div class="buy-right-column">

<?php include($templatesPath.'categories.php') ?>
<?php include($templatesPath.'articles.php') ?>

				</div>
			</div>
<?php

loadFooter("footer");
endDocument();

?>