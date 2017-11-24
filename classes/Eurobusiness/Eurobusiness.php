<?php

  namespace Eurobusiness;

  use Eurobusiness\Storage\DatabaseHandler;

  class Eurobusiness {
    private static $database = null;

    public static function getDatabase() {
      if (self::$database != null)
        return self::$database;

      self::$database = DatabaseHandler::connect();
      return self::$database;
    }
  }

?>
