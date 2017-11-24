<?php

  namespace Eurobusiness;

  use Eurobusiness\Utils;

  class User {
    // User id (same as in the database)
    protected $id;

    // Username (alphanumeric)
    protected $username;

    // E-mail address (for account management)
    protected $email;

    // Password as SHA-256 hash, editable
    protected $password;

    // Activation token, if it is null => account activated
    protected $activationToken;

    public function __construct($id, $username, $email, $password, $activationToken) {
      $this->id = $id;
      $this->username = $username;
      $this->email = $email;
      $this->password = $password;
      $this->activationToken = $activationToken;
    }

    public function getId() {
      return $this->id;
    }

    public function getUsername() {
      return $this->username;
    }

    public function getEmailAddress() {
      return $this->email;
    }

    public function getPassword() {
      return $this->password;
    }

    public function setPassword($password) {
      $this->password = Utils::getSha256Hash($password);
    }

    public function checkPassword($password) {
      return $this->password === Utils::getSha256Hash($password);
    }

    public function getActivationToken() {
      return $this->activationToken;
    }

    public function isActivated() {
      return empty($this->activationToken);
    }
  }

?>
