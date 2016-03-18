<?php

$relative = '..';
require '../includes/common.php';

$userStats = logout();
$appPlace = 'home';
$appSubPlace = 'logout';

header('Location: /');

?>