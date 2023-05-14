<?php

class TestController extends Controller {
	
	public static $data = null;
	
	public function __construct( ) {
		
	}

	public static function show() {

		self::$data['test'] = 'test';

		return [
			'class' => 'IndexView',
			'data' => self::$data
		];
	}
	
}