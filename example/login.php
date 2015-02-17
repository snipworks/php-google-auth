<?php

require_once(dirname(__DIR__) . '/src/google.php');
$config = require_once(__DIR__ . '/config.php');
$google = new Google($config);

?>
<h1>Google Login Example</h1>
<a href="<?php echo $google->getAuthURL(); ?>">Click Here</a>
