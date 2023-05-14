<?php

Router::add(
	'/',
	['controller' => 'Task', 'action' => 'show']
);


Router::add(
	'/login/',
	['controller' => 'Login', 'action' => 'show']
);