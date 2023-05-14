<?php

session_start();
$_SESSION['USER']['LOGIN'] = false;

include __DIR__ . '/app/helpers.php';
goHome();