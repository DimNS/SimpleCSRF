# Simple CSRF-token class to prevent CSRF attacks

[![Latest Stable Version](https://poser.pugx.org/dimns/simplecsrf/v/stable)](https://packagist.org/packages/dimns/simplecsrf)
[![Total Downloads](https://poser.pugx.org/dimns/simplecsrf/downloads)](https://packagist.org/packages/dimns/simplecsrf)
[![License](https://poser.pugx.org/dimns/simplecsrf/license)](https://packagist.org/packages/dimns/simplecsrf)

## Requirements
- PHP 5.3 or higher is required.

## Composer installation
1. Get [Composer](http://getcomposer.org/).
3. Require SimpleCSRF with `php composer.phar require dimns/simplecsrf` or `composer require dimns/simplecsrf` (if the composer is installed globally).
3. Add the following to your application's main PHP file: `require 'vendor/autoload.php';`.

## Usage with FORM
php
```php
<?php
require 'vendor/autoload.php';

session_start();

// Init class
$csrf = new \DimNS\SimpleCSRF(); // Default session name: csrf_token

// Init class with other session name
$csrf = new \DimNS\SimpleCSRF('my_session_name');

// Getting a token for forms
$csrf_token = $csrf->getToken();

// Checking the token
if ($csrf->validateToken($_POST['_token'])) {
    echo 'Token correct';
} else {
    echo 'Invalid token';
}
```

html
```html
<form action="index.php" method="post">
    <input type="text" name="login">
    <input type="password" name="password">
    <input type="hidden" name="_token" value="<?=$csrf_token?>">
    <input type="submit" value="GO!">
</form>
```

## Usage with AJAX
php
```php
<?php
require 'vendor/autoload.php';

session_start();

// Init class
$csrf = new \DimNS\SimpleCSRF(); // Default session name: csrf_token

// Init class with other session name
$csrf = new \DimNS\SimpleCSRF('my_session_name');

// Generate a token for forms
$csrf_token = $csrf->getToken();

// Checking the token
if ($csrf->validateToken($_SERVER['HTTP_X_CSRFTOKEN'])) {
    // Token correct
} else {
    // Invalid token
}
```

html
```html
<head>
    <meta name="_token" content="<?=$csrf_token?>">
</head>
```

javascript
```javascript
// jQuery
$.ajaxSetup({
    beforeSend: function (xhr, settings) {
        if (!/^(GET|HEAD|OPTIONS|TRACE)$/i.test(settings.type)) {
            xhr.setRequestHeader("X-CSRFToken", $('meta[name="_token"]').attr('content'));
        }
    }
});
```