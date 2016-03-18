<?php

echo 'Working...';
exit;

$relative = '.';
require './includes/common.php';

$userStats = loadUser();
$appPlace = 'home';
$appSubPlace = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadHeader("header");

loadSection('home/slide');
loadSection('home/content');

loadFooter("footer");
endDocument();

?>