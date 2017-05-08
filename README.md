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
    'setMethod' => 'get',
    'setAuth' => ['user', 'password'],
    'setUrl'=>'http://website.com/api/100'
]);```

```php
$body = [
            [
                "name" => "Pande",
                "email" => "pande@gmail.com",
                "blog" => "pande.wordpress.com",
                "company" => "Mindo",
                "bio" => "Lorem Ipsum Dolor SIt Amet"
            ],
            [
                "name" => "Sirait",
                "email" => "sirait@gmail.com",
                "blog" => "sirait.wordpress.com",
                "company" => "Mindo",
                "bio" => "Lorem Ipsum Dolor SIt Amet"
            ]
        ];

$tes = \udamuri\curl\YiiCurl::widget([
    'setMethod' => 'post',
    'setAuth' => ['muribudiman', '123456789'],
    'setBody' => $body,
    'setUrl'=>'http://ladoapi.dev:1984/example/create'
]);
```