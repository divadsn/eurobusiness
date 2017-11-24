<?php

  include "vendor/autoload.php";

  use Ramsey\Uuid\Uuid;

  $client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 6379,
  ]);

  $session = $client->get('session');
  echo "Last session: " . (empty($session) ? "NONE" : $session) . "<br />";

  $sessionId = Uuid::uuid5(Uuid::NAMESPACE_DNS, 'game_' . time());
  $client->set('session', $sessionId->toString());
  echo "New session: " . $sessionId->toString();

?>
