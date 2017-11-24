<?php

  namespace Eurobusiness;

  use Eurobusiness\Config;

  class Utils {
    // Returns sha256 hash of string
    public static function getSha256Hash($string) {
      return hash("sha256", Config::getHashSalt() . "." . $string);
    }
  }

?>
