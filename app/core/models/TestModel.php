<?php

class TestModel extends Model {

	public static $TABLE = 'tests';

	public function __construct($table = null) {
		if ($table) {
      self::$TABLE = $table;
    }

		parent::__construct(self::$TABLE);
		
	}

}