<?php

class UserModel extends Model {

	public static $TABLE = 'users';

	public function __construct($table = null) {
		if ($table) {
      self::$TABLE = $table;
    }

		parent::__construct(self::$TABLE);
		
	}

	public function getList($limit = null, $offset = null, $order = null) {

		$result = null;

		if ($table = self::$TABLE) {

			$order = $order ?? "ORDER BY `id` DESC";
			if (is_array($order)) {
				$orderQ = '';
				if (!empty($order)) {
					$orderQ .= "ORDER BY ";
				}
				foreach ($order as $filter => $direct) {
					$orderQ .= "`{$filter}` {$direct}, ";
				}
				if (!empty($orderQ)) {
					$order = substr($orderQ, 0, -2);
				}

			}

			$limit = ($limit > 0) ? "LIMIT {$limit} OFFSET {$offset}" : "";
			$query = "SELECT * FROM `{$table}` {$order} {$limit}";

			self::$DBRES = mysqli_query(self::$DBCON, $query);
			$result = $this->getAll();

		}

		return $result;

	}

	public function getCount() {
		$result = null;

		if ($table = self::$TABLE) {
			$query = "SELECT COUNT(*) FROM `{$table}`";
			self::$DBRES = mysqli_query(self::$DBCON, $query);
			$result = $this->getValue();
		}

		return $result;
	}

	public function createUser(
		$username = null,
		$password = null,
		$role = 'manager',
		$active = 1
	) {
		$result = false;

		if (($table = self::$TABLE) && $username && $password) {
		
			$query = 
				"INSERT INTO `{$table}` (`username `, `password`, `role`, `active`)
				VALUES ('{$username}', '{$password}', '{$role}', '{$active}');";

			self::$DBRES = mysqli_query(self::$DBCON, $query);

			$result = true;

		}

		return $result;
	}

}