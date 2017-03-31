YII2 CURL
=========
YII2 CURL using Library codeigniter by
- http://philsturgeon.co.uk/code/codeigniter-curl
- https://github.com/philsturgeon/codeigniter-curl/blob/master/libraries/Curl.php

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist udamuri/yii2-curl "*"
```

or add

```
"udamuri/yii2-curl": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
$tes = \udamuri\curl\YiiCurl::widget([
    'call' => 'simple_get',
    'http_login' => ['user', 'password'],
    'url'=>'http://website.com/api/100'
]);```