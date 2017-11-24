<?php

  include "vendor/autoload.php";

  use Eurobusiness\Config;

  // Should output €urobu$ine$$
  echo Config::getHashSalt();

?>
