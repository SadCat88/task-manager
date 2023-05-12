<?php

class Config {

	public static function get($key) {

		require(__DIR__ . '/../../config.php');

		return $cfg[$key];

	}

}