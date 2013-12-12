CakePHP 2.x [Raygun.io] Plugin
============

A CakePHP plugin to use [Raygun.io](http://raygun.io) for errors and exceptions. Required PHP 5.3+ (due to Raygun4php dependency)


Based on https://github.com/morrislaptop/AirbrakeCake

Installation
=========================
```
git submodule add git://github.com/t1mmen/RaygunCake.git app/Plugin/RaygunCake
cd app/Plugin/RaygunCake
git submodule init
git submodule update
```

Dependencies
=========================
* [Raygun4php](https://github.com/MindscapeHQ/raygun4php), bundled in /Vendor

app/Config/bootstrap.php
=========================

```php
<?php
// Include our awesome error catcher..
CakePlugin::load('RaygunCake');
Configure::write('RaygunCake.apiKey', '<API KEY>');
App::uses('RaygunError', 'RaygunCake.Lib');
```

app/Config/core.php
=========================

```php
<?php
	Configure::write('Error', array(
		'handler' => 'RaygunError::handleError',
		'level' => E_ALL & ~E_DEPRECATED,
		'trace' => true
	));

	Configure::write('Exception', array(
		'handler' => 'RaygunError::handleException',
		'renderer' => 'ExceptionRenderer',
		'log' => true
	));
```
