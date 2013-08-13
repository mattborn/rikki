<?php

session_start();

// Initialize Slim
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array(
	'debug' => true
));

// This file is not tracked
require 'config.php';

// Connect to database
require 'Slim/NotORM.php';
$pdo = new PDO('mysql:dbname=' .$c['db']. ';', $c['user'], $c['pass']);
$db = new NotORM($pdo);

// Set JSON as the default response type
$app->response()->header('content-type', 'application/json');

$app->post('/rsvp', function () use ($app) {
	// Capture RSVP form data
});

$app->response()->header('content-type', 'text/html');

$app->get('/', function () use ($app) {
	$app->render('bootstrap.php', array('uri' => 'vegas'));
});

$app->notFound(function () use ($app) {
	$app->render('bootstrap.php', array('uri' => '404'));
});

$app->run();
