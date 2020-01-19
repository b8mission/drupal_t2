<?php

namespace Drupal\random_module\Controller;

use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

use Drupal\random_module\Classes\RandomDevicesTaker;

/*** Class RandomRestController.*/
class RandomRestController extends ControllerBase {

  /** * Return random nodes in a formatted JSON response. * * @return \Symfony\Component\HttpFoundation\JsonResponse * The formatted JSON response. */
  public function getRandomNodes() {

    $nids        = \Drupal::entityQuery('node')
                          ->condition('type', 'device')
                          ->execute();
    $nodes       = \Drupal\node\Entity\Node::loadMultiple($nids);


    if (FALSE === RandomDevicesTaker::getRandomNodes($assoc_array, TRUE)) {
      return (new JsonResponse(['message' => 'no data'], 500));
    }


    if (empty($assoc_array)) {
      return (new JsonResponse(['message' => 'no data'], 500));
    }

    return new JsonResponse($assoc_array, 200);
  }


}
