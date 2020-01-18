<?php

namespace Drupal\random_module\Controller;

//use Drupal\features\Package;

class BigBenController extends \Drupal\Core\Controller\ControllerBase {

  public function content() {

    $rstring = 'Big Ben time is ';

    $response = ['#type' => 'markup', '#markup' => t($rstring . 'unknown')];

    if (TRUE !== date_default_timezone_set("Europe/London")) {
      return $response;
    }

    $time = (date('h:i a', time()) ?? 'N/A');

    $response['#markup'] = t($rstring . $time);
    return $response;

  }

}
