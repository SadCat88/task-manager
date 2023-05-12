<?php

class TestModel extends Model {

	public function getById( $id = null ) {

		$result = null;

		if($id){

			$table = self::$TABLE;
			$query = "SELECT * FROM `{$table}` WHERE `id` = '{$id}' LIMIT 1";

			self::$DBRES = mysqli_query(self::$DBCON, $query);
			$result = $this->getOne();

		}

		return $result;

	}

}