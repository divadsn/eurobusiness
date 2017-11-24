<?php

  namespace Eurobusiness;

  use Symfony\Component\Yaml\Yaml;

  // TODO: Find a way to get rid of static filepath
  class Config {
    private static $CONFIG_FILE = "/var/www/html/config.yml";

    private static $instance = null;

    private $data = null;

    private $cache = array();

    public function __construct() {
      $this->load(self::$CONFIG_FILE);
    }

    public static function getHashSalt() {
      return self::getInstance()->get("security.hashsalt");
    }

    public static function isDebugMode() {
      return self::getInstance()->get("debug");
    }

    public static function getInstance() {
      if (self::$instance === null)
        self::$instance = new Config();

      return self::$instance;
    }

    // Get value by key from config
    public function get($key, $default=null) {
      if ($this->has($key)) {
        return $this->cache[$key];
      }

      return $default;
    }

    // Save value and key to config
    public function set($key, $value) {
      $segs = explode('.', $key);
      $root = &$this->data;
      $cacheKey = '';

      // Look for the key, creating nested keys if needed
      while ($part = array_shift($segs)) {
        if ($cacheKey != '') {
          $cacheKey .= '.';
        }

        $cacheKey .= $part;

        if (!isset($root[$part]) && count($segs)) {
          $root[$part] = array();
        }

        $root = &$root[$part];

        //Unset all old nested cache
        if (isset($this->cache[$cacheKey])) {
          unset($this->cache[$cacheKey]);
        }

        //Unset all old nested cache in case of array
        if (count($segs) == 0) {
          foreach ($this->cache as $cacheLocalKey => $cacheValue) {
            if (substr($cacheLocalKey, 0, strlen($cacheKey)) === $cacheKey) {
              unset($this->cache[$cacheLocalKey]);
            }
          }
        }
      }

      // Assign value at target node
      $this->cache[$key] = $root = $value;
    }

    // Check if config.yml has been loaded
    public function has($key) {
      // Check if already cached
      if (isset($this->cache[$key])) {
        return true;
      }

      $segments = explode('.', $key);
      $root = $this->data;

      // nested case
      foreach ($segments as $segment) {
        if (array_key_exists($segment, $root)) {
          $root = $root[$segment];
          continue;
        } else {
          return false;
        }
      }

      // Set cache for the given key
      $this->cache[$key] = $root;
      return true;
    }

    // Load config.yml file (if not loaded)
    public function load() {
      if (!$this->isLoaded())
        $this->data = Yaml::parse(file_get_contents(self::$CONFIG_FILE));
    }

    // Save config.yml file (if it's loaded)
    public function save() {
      if ($this->isLoaded())
        file_put_contents(self::$CONFIG_FILE, Yaml::dump($this->data));
    }

    // Check whether config.yml has been loaded
    public function isLoaded() {
      return $this->data !== null;
    }
  }

?>
