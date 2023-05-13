<?php

Router::add(
	'/',
	['controller' => 'Task', 'action' => 'show']
);

Router::add(
	'/test/',
	['controller' => 'Test', 'action' => 'show']
);