Redirect behavior for Yii2
==========================
Is a component for configuration of redirects from controller actions to routes or previous page

[![Latest Stable Version](https://poser.pugx.org/black-lamp/yii2-redirect/v/stable)](https://packagist.org/packages/black-lamp/yii2-redirect)
[![Latest Unstable Version](https://poser.pugx.org/black-lamp/yii2-redirect/v/unstable)](https://packagist.org/packages/black-lamp/yii2-redirect)
[![License](https://poser.pugx.org/black-lamp/yii2-redirect/license)](https://packagist.org/packages/black-lamp/yii2-redirect)

Installation
------------
Run command
```
composer require black-lamp/yii2-redirect
```
or add
```json
"black-lamp/yii2-redirect": "dev-master"
```
to the require section of your composer.json.

Using
-----
Add behavior to your controller
```php
public function behaviors()
{
   return [
        'redirect' => [
            'class' => \bl\redirect\RedirectBehavior::class,
            'actions' => [
            ]
        ],
   ];
}
```
and configure redirects in the `actions` array
```php
// ...
'class' => \bl\redirect\RedirectBehavior::class,
'actions' => [
    'register' => ['/news'],
    'send-request' => ['/user'],
    // ...
]
```
array key it's a action ID and the value of the array it's a route to redirect.

If you leave route empty like this
```php
'actions' => [
    'register' => [],
    // ...
]
```
action will be redirected to request referrer.

If referrer is empty - action will be redirected to route from `\yii\web\User::getReturnUrl()`.
You can change this route if you use `\yii\web\User::setReturnUrl()` method.