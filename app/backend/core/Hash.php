<?php

class Hash
{
  public static function make($string)
  {
    return hash(Config::get('hash/algo_name'), $string . self::salt());
  }

  public static function salt()
  {
    $length = intval(Config::get('hash/salt_length'));
    return random_bytes($length);
  }

  public static function unique()
  {
    return self::make(uniqid());
  }
}
