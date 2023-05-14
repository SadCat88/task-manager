<?php

class Model {
  public static $DBCON = null;
  public static $DBRES = null;
  public static $TABLE = null;

  public function __construct($table = null) {

    if (!self::$DBCON) {
      $cfgDB = Config::get('DB');
      self::$DBCON = mysqli_connect(
        $cfgDB['DB_HOST'],
        $cfgDB['DB_USER'],
        $cfgDB['DB_PASS'],
        $cfgDB['DB_NAME']
      );
    }

    if ($table) {
      self::$TABLE = $table;
    }

  }

  public function query($query = null) {

    if ($query) {
      self::$DBRES = mysqli_query(self::$DBCON, $query);
    }

    return $this;

  }

  public function get() {
    return self::$DBRES;
  }

  public function getAll() {

    for ($data = []; $row = mysqli_fetch_assoc(self::$DBRES); $data[$row['id']] = $row) {
    }
    return $data;

  }

  public function getOne() {

    return mysqli_fetch_assoc(self::$DBRES);

  }

  
  public function getValue() {

    return mysqli_fetch_row(self::$DBRES)[0];

  }

  /****************************************************************************/

  public function getById($id = null, $table = null) {

		$result = null;
    
		if ($id && ($table = self::$TABLE)) {

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

  public function getElementWhere( $field = null, $value = null ) {
    $result = null;

    if (($table = self::$TABLE) && $field && $value) {
      $query = "SELECT * FROM `{$table}` WHERE `$field` = '$value' LIMIT 1";
      self::$DBRES = mysqli_query(self::$DBCON, $query);
      $result = $this->getOne();
    }

    return $result;
  }


}