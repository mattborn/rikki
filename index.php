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
$mysql = "mysql:host={$config['host']};dbname={$config['db']};";
$pdo = new PDO($mysql, $config['user'], $config['pass']);
$db = new NotORM($pdo);

// Set JSON as the default response type
$app->response()->header('content-type', 'application/json');

$app->post('/rsvp', function () use ($app, $db) {
	$body = $app->request()->getBody();
	parse_str($body, $post);
	$guests = $db->rp_guests();
	$result = $guests->insert($post);
	
	$headers = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= 'From: RSVP <no-reply@rikkipalm.com>';
	
	if (!$post['going']) {
		$subject = $post['name'] .' is not going.';
		$message = 'Make them feel bad? <a href="mailto:'. $post['email'] .'">'. $post['email'] .'</a>';
	} else {
		$subject = $post['name'] . ' is going!';
		$message = '<a href="mailto:'. $post['email'] .'">'. $post['email'] .'</a><br>';
		$message .= 'Plus: '. $post['plus'] .'<br>';
		$message .= 'Size(s): '. $post['size'] .'<br>';
		$message .= 'Hotel: '. $post['hotel'];
	}
	
	$send = mail('rsvp@rikkipalm.com', $subject, $message, $headers);
	$status = $send ? 'Mail sent.' : 'Mail failed.';
	
	$return = array(
		'id' => $result['id'],
		'status' => $status
	);
	
	echo json_encode($return);
});

$app->response()->header('content-type', 'text/html');

$app->get('/', function () use ($app) {
	$app->render('bootstrap.php', array('uri' => 'vegas'));
});

$app->notFound(function () use ($app) {
	$app->render('bootstrap.php', array('uri' => '404'));
});

$app->run();
