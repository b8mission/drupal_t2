<?php

namespace Drupal\random_module\Classes;

class EndpointVisitorCounter {


  public static function recordVisit($endpoint_id = NULL) {

    if (!is_int($endpoint_id) || $endpoint_id < 0) {
      $endpoint_id = 'NULL';
    }

    $user_id = (\Drupal::currentUser()->id() ?? 0);
    if ($user_id < 1) {
      $user_id = "NULL";
    }

    $ip = &$_SERVER["REMOTE_ADDR"];

    \Drupal::database()
           ->query("INSERT INTO random_module_endpoints_visitors
              (`user_id`, `endpoint_id`,`ip_address`, `date`)
              VALUES ($user_id, $endpoint_id,'{$ip}', UNIX_TIMESTAMP())");

  }


}
