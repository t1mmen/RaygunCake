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
	public static $useAsyncSending = true;

	public static $debugMode = false;

	// Call Raygun without calling handleError()
	public static function handleErrorRaygun($code, $description, $file = null, $line = null) {
		// Call Raygun
		$apiKey = Configure::read('RaygunCake.apiKey'); // This is required
		$client = new \Raygun4php\RaygunClient($apiKey, self::$useAsyncSending, self::$debugMode);
		if (Configure::read('RaygunCake.version')) {
			$client->SetVersion(Configure::read('RaygunCake.version'));
		}
		$client->SendError($code, $description, $file, $line);
	}

	// Call Raygun without calling handleException
	public static function handleExceptionRaygun(Exception $exception) {
		// Call Raygun
		$apiKey = Configure::read('RaygunCake.apiKey'); // This is required
		$client = new \Raygun4php\RaygunClient($apiKey, self::$useAsyncSending, self::$debugMode);
		if (Configure::read('RaygunCake.version')) {
			$client->SetVersion(Configure::read('RaygunCake.version'));
		}
		$client->SendException($exception);
	}

	// Overload Errors: Call Raygun AND handleError()
	public static function handleError($code, $description, $file = null, $line = null, $context = null) {
		self::handleErrorRaygun($code, $description, $file, $line);

		// Fall back to cake
		return parent::handleError($code, $description, $file, $line, $context);
	}

	// Overload Exceptions: Call Raygun AND handleException()
	public static function handleException(Exception $exception) {
		self::handleExceptionRaygun($exception);

		// Fall back to Cake..
		return parent::handleException($exception);
	}

}
