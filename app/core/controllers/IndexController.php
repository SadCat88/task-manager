<?php

class IndexController extends Controller {

	public static $data = null;

	public static function show() {

		return [
			'class' => 'IndexView',
			'data' => self::$data
		];

	}

}