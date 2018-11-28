This repo is no longer maintained. The plugin is forked & maintained at [MindscapeHQ/RaygunCake](https://github.com/MindscapeHQ/RaygunCake)
===========

CakePHP 2.x [Raygun.io](http://raygun.io) Plugin
============

A CakePHP plugin to use [Raygun.io](http://raygun.io) for errors and exceptions. Required PHP 5.3+ (due to Raygun4php dependency)


Based on https://github.com/morrislaptop/AirbrakeCake

**Dependencies**
* CakePHP 2.x
* [Raygun4php](https://github.com/MindscapeHQ/raygun4php), bundled in /Vendor

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
// Optional: Send your application's version number
Configure::write('RaygunCake.version', '1.2.3.4');
// Optional: Filter out sensitive parameters before logging to Raygun
Configure::write('RaygunCake.filterParams', array('password' => true));
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

Manually register an error with Raygun
=========================

```php
<?php
// Only the first 2 arguments are required
RaygunError::handleErrorRaygun(
  E_WARNING,
  "Generic Description",
  $file, $line, $tags,
  $userCustomData, $timestamp
);
```

Manually register an exception with Raygun
=========================

```php
<?php
// Only the first argument is required
RaygunError::handleExceptionRaygun(
  $exception, $tags,
  $userCustomData, $timestamp
);
```


