PHP Google OAuth
================

A simple and small class for Google OAuth Login

## Initialization
### Using array
```php
<?php

require_once('src/google.php');
$config = array(
    'client_id' => '<!- client id -!>',
    'client_secret' => '<!- client secret !->',
    'redirect_uri' => 'http://' . $_SERVER['HTTP_HOST'] . '/example/callback.php',
    'scope' => array('openid', 'email', 'profile')
);

$google = new Google($config);
```

### Using properties
```php
<?php

require_once('src/google.php');
$google = new Google();
$google->client_id = '<!- client id -!>';
$google->client_secret = '<!- client scret -!>';
$google->redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/example/callback.php';
$google->scope = array('openid', 'email', 'profile');
```

This is to initialize the Google OAuth config. 
For security reasons, you can put your settings to a separate file.


## Usage (methods)

```php
header('Location: ' . $google->getAuthURL());
```

This creates google auth url based from your configurations.
You can use this as login URL for your web application.


```php
$google->authenticate($_REQUEST['code']);
```

This is used to authenticate if you had successfully logged-in to google.
The request code (from Google Login passed to callback URL) will be validated by Google API.

(Optional) Also returns the validated access token acquired


```php
$user = $google->getUser();
print_r($user);
```

Return array of the Google User's information. 
This request valid access token obtained from the authentication method


