<?php

Router::add(
	'/',
	['controller' => 'Index', 'action' => 'show']
);

Router::add(
	'/test/',
	['controller' => 'Test', 'action' => 'show']
);