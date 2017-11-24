<?php

  namespace Eurobusiness\Storage;

  use Eurobusiness\Config;
  use Medoo\Medoo;

  class DatabaseHandler {
    // Shouldn't change as long as PDO is alive
    private const DRIVER_MYSQL = "mysql";

    // Creates a new MySQL database instance
    public static function connect($hostname, $username, $password, $database, $prefix="", $charset="utf8") {
      return new Medoo([
        "server" => $hostname,
        "username" => $username,
        "password" => $password,
        "database_type" => DRIVER_MYSQL,
        "database_name" => $database,
        "prefix" => $prefix,
        "charset" => $charset,
        "logging" => Config::isDebugMode()
      ])
    }
  }

?>
