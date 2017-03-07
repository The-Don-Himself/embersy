<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/setup.html#checking-symfony-application-configuration-and-setup
// for more information
//umask(0000);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Campus Discounts | Development"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'This Section is restricted to the Campus Discounts Development Team';
    exit;
} else {
    if($_SERVER['PHP_AUTH_USER'] !== 'backendadmin'){
		header('WWW-Authenticate: Basic realm="Campus Discounts | Development"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Incorrect username';
		exit;
	} else{
		if($_SERVER['PHP_AUTH_PW'] !== 'backendpassword'){
			header('WWW-Authenticate: Basic realm="Campus Discounts | Development"');
			header('HTTP/1.0 401 Unauthorized');
			echo 'Incorrect password';
			exit;
		}
	}
}

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../app/autoload.php';
Debug::enable();

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
