<?php

  namespace Eurobusiness;

  // TODO: Load config.yml and REPLACE STATIC SHET
  class Config {
    public static function getHashSalt() {
      return "eurobusiness";
    }

    public static function isDebugMode() {
      return true;
    }

    public static function get($key) {

    }

    public static function set($key, $value) {
      
    }
  }

?>
