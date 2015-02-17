<?php

return array(
    'client_id' => '<!- client id -!>',
    'client_secret' => '<!- client secret !->',
    'redirect_uri' => 'http://' . $_SERVER['HTTP_HOST'] . '/example/callback.php',
    'scope' => array('openid', 'email', 'profile')
);


