<?php

try {

	include __DIR__ . '/global.php';
	include __DIR__ . '/../config.php';
	include __DIR__ . '/helpers.php';
	include __DIR__ . '/../routes.php';


	if (Router::setRoute($_SERVER['REDIRECT_URL'] ?? '/')) {
		// vd(Router::getRoute());
		new Controller(Router::getRoute());
	}
	//
	else {
		echo '404';
	}
}
//
catch (Throwable $e) {
	echo '<pre style="white-space: pre-wrap;">';
	echo '<b>Что-то сломалось...</b>';
	throw new Exception($e);
	echo '</pre>';
}