CakePHP 2.0 Raygun
============

A CakePHP plugin to use Raygun for errors and exceptions.

Based on https://github.com/morrislaptop/AirbrakeCake

Installation
=========================
```
git submodule add git://github.com/t1mmen/RaygunCake.git app/Plugin/RaygunCake
cd app/Plugin/RaygunCake
git submodule init
git submodule update
```


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
