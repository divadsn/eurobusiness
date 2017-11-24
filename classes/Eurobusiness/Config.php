<?php

  namespace Eurobusiness;

  use Symfony\Component\Yaml\Yaml;

  // TODO: Load config.yml and REPLACE STATIC SHET
  class Config {
    private static $CONFIG_FILE = "/var/www/html/config.yml";

    private static $data = null;

    private static $cache = array();

    public static function getHashSalt() {
      return self::get("security.hashsalt");
    }

    public static function isDebugMode() {
      return self::get("debug");
    }

    // Get value by key from config
    public static function get($key, $default=null) {
      self::load();

      if (self::has($key)) {
        return $this->cache[$key];
      }

      return $default;
    }

    // Save value and key to config
    public static function set($key, $value) {
      self::load();

      $segs = explode('.', $key);
      $root = self::data;
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
    public static function has($key) {
      self::load();

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

    public static function load() {
      if (!self::isLoaded())
        self::$data = Yaml::parse(file_get_contents(self::$CONFIG_FILE));
    }

    public static function isLoaded() {
      return self::$data !== null;
    }
  }

?>
