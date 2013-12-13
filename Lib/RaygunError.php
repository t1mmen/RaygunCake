<?php
/**
 * Send along errors and exceptions to Raygun.io
 *
 * @link        http://raygun.ui
 * @link        https://github.com/t1mmen/RaygunCake
 * @author 	Timm Stokke <timm@stokke.me>
 */

App::import('Vendor', 'Raygun4php', array('file' => 'Raygun4php' . DS . 'RaygunClient.php'));

class RaygunError extends ErrorHandler {

	// Overload Errors:
	public static function handleError($code, $description, $file = null, $line = null, $context = null) {

		// Raygun settings
		$useAsyncSending = true;
		$debugMode = false;

		// Call Raygun
		$apiKey  = Configure::read('RaygunCake.apiKey'); // This is required
		$client = new \Raygun4php\RaygunClient($apiKey, $useAsyncSending, $debugMode);
		$client->SendError($code, $description, $file, $line);

		// Fall back to cake
		return parent::handleError($code, $description, $file, $line, $context);
	}

	// Overload Exceptions:
	public static function handleException(Exception $exception) {

		// Raygun settings
		$useAsyncSending = true;
		$debugMode = false;

		// Call Raygun
		$apiKey  = Configure::read('RaygunCake.apiKey'); // This is required
		$client = new \Raygun4php\RaygunClient($apiKey, $useAsyncSending, $debugMode);
		$client->SendException($exception);

		// Fall back to Cake..
		return parent::handleException($exception);
	}



}
