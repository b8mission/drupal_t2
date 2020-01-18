<?php

namespace Drupal\random_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines HelloController class.
 */
class HelloController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content() {

    $template = include('templates/RandomPage.php');


    return [
      '#type'   => 'markup',
      '#markup' => $this->t(($template)),
    ];
  }

}
