<?php

require_once(dirname(__DIR__) . '/src/google.php');
$config = require_once(__DIR__ . '/config.php');

$code = $_REQUEST['code'];

$google = new Google($config);
$google->authenticate($code);
$user = $google->getUser();

$_SESSION['google_user_info'] = $user;
header('Location: /example/home.php');
