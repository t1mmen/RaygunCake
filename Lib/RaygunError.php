<?php
require_once(dirname(dirname(__FILE__)).DS.'Vendor'.DS.'autoload.php');

// Workaround for Composers' autoloader
spl_autoload_unregister(array('App', 'load'));
spl_autoload_register(array('App', 'load'), true, true);

class RaygunError extends ErrorHandler {

	public static function handleError($code, $description, $file = null, $line = null, $context = null) {

		// Call Raygun
		$apiKey  = Configure::read('RaygunCake.apiKey'); // This is required
		$client = new \Raygun4php\RaygunClient($apiKey);
		$client->SendError($code, $description, $file, $line);

		// Fall back to cake
		return parent::handleError($code, $description, $file, $line, $context);
	}

	public static function handleException(Exception $exception) {

		// Call Raygun
		$apiKey  = Configure::read('RaygunCake.apiKey'); // This is required
		$client = new \Raygun4php\RaygunClient($apiKey, false, true);
		$client->SendException($exception);

		// Fall back to Cake..
		return parent::handleException($exception);
	}



}
