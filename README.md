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
//GET
$tes = \udamuri\curl\YiiCurl::widget([
    'setMethod' => 'get',
    'setAuth' => ['user', 'password'],
    'setUrl'=>'http://website.com/api/100'
]);

//POST
$body = [
            [
                "name" => "Tes",
                "email" => "tes@gmail.com",
                "blog" => "tes.xx.com",
                "company" => "Gite",
                "bio" => "Lorem Ipsum Dolor SIt Amet"
            ],
            [
                "name" => "Tos",
                "email" => "tos@gmail.com",
                "blog" => "tos.xx.com",
                "company" => "Gite",
                "bio" => "Lorem Ipsum Dolor SIt Amet"
            ]
        ];

$tes = \udamuri\curl\YiiCurl::widget([
    'setMethod' => 'post',
    'setAuth' => ['user', 'password'],
    'setBody' => $body,
    'setUrl'=>'http://ladoapi.dev/example/create'
]);```
