<?php

  include "vendor/autoload.php";

  use Eurobusiness\Utils;

  // Should output f550db9696875255f26d569675874ee9d6a9c8ed0e9c724d3fb35533a58fa005
  echo Utils::getSha256Hash("test123");

?>
