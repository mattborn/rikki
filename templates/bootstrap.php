<?php

if (isset($this->data['uri'])) {
	$uri = $this->data['uri'];
} else {
	$uri = trim($_SERVER['REQUEST_URI'], '/');
}

$dir = '/modules/';
$path = $dir . $uri .'/'. $uri; // /modules/vegas/vegas.js
$html = getcwd() . $path .'.php';
$css = $path .'.css';
$js = $path .'.js';

$titles = array(
	'vegas' => 'RSVP'
);

function title($titles, $uri) {
	if (isset($titles[$uri])) {
		echo $titles[$uri];
	} else {
		echo 'Rikki Palm';
	}
}
function html($html) {
	if (file_exists($html)) {
		require $html;
	} else {
		header('Location: /dev/null');
		die();
	}
}
function css($css) {
	if (file_exists(getcwd() . $css)) {
		echo '<link rel="stylesheet" href="'.$css.'">'."\n";
	}
}
function js($js) {
	if (file_exists(getcwd() . $js)) {
		echo '<script src="'.$js.'"></script>'."\n";
	}
}

?><!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php title($titles, $uri); ?></title>
	<link rel="shortcut icon" href="/favicon.ico?v=1"> 
	<link rel="stylesheet" href="/shared/rikki.css">
	<?php css($css); ?>
	<script src="//use.typekit.net/ulo4mhg.js"></script>
	<script>try{Typekit.load();}catch(e){}</script>
</head>
<body>
<?php html($html); ?>
	<script src="/shared/jquery.js"></script>
	<?php js($js); ?>
</body>
</html>
