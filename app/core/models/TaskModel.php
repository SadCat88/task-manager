<?php

class TaskModel extends Model {

	public static $TABLE = 'tasks';

	public function __construct($table = null) {
		if ($table) {
      self::$TABLE = $table;
    }

		parent::__construct(self::$TABLE);
		
	}

	public function createTask(
		$user = null,
		$email = null,
		$description = null,
		$state = 0
	) {
		$result = false;

		if (($table = self::$TABLE) && $user && $email && $description) {
		
			$query = 
				"INSERT INTO `{$table}` (`user`, `email`, `description`, `state`)
				VALUES ('{$user}', '{$email}', '{$description}', '{$state}');";

			self::$DBRES = mysqli_query(self::$DBCON, $query);

			$result = true;

		}

		return $result;
	}

}