<?php

class TaskModel extends Model {

	public static $TABLE = 'tasks';

	public function getById($id = null, $table = null) {

		$result = null;

		if ($id && $table = self::$TABLE) {

			$query = "SELECT * FROM `{$table}` WHERE `id` = '{$id}' LIMIT 1";

			self::$DBRES = mysqli_query(self::$DBCON, $query);
			$result = $this->getOne();

		}

		return $result;

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