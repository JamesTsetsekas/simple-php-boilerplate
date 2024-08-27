<?php

class Token
{
  public static function generate()
  {
    $session = new Session();
    return $session->put(Config::get('session/token_name'), base64_encode(random_bytes(32)));
  }

  public static function check($token)
  {
    $tokenName = Config::get('session/token_name');

    $session = new Session();
    if ($session->exists($tokenName) && $token === $session->get($tokenName)) {
      return true;
    }

    return false;
  }
}
