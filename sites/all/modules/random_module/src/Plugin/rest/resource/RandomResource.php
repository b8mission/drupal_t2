<?php

namespace Drupal\random_module\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

use Drupal\random_module\Classes\RandomDevicesTaker;


/**
 * Provides a Random Resource
 *
 * @RestResource(
 *   id = "random_resource",
 *   label = @Translation("Random Resource"),
 *   uri_paths = {
 *     "canonical" = "/api/random-endpoint2"
 *   }
 * )
 */
class RandomResource extends ResourceBase {

  /**
   * Responds to entity GET requests.
   *
   * @return \Drupal\rest\ResourceResponse
   */
  public function get() {
    \Drupal\random_module\Classes\EndpointVisitorCounter::recordVisit(1);


    $cacheable_dependency = [
      '#cache' => [
        'max-age' => 0,
      ],
    ];

    $response = new ResourceResponse(['message' => 'no data'], '500');
    $response->addCacheableDependency($cacheable_dependency);


    $assoc_array = [];
    if (FALSE === RandomDevicesTaker::getRandomNodes( $assoc_array, FALSE)) {
      return $response;
    }

    return (new ResourceResponse($assoc_array, 200))->addCacheableDependency($cacheable_dependency);
  }

}
