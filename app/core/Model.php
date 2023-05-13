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


}