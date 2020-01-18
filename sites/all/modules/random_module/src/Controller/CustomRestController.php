<?php

namespace Drupal\random_module\Controller;

use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Zend\Diactoros\Response\JsonResponse;

/*** Class CustomRestController.*/
class CustomRestController extends ControllerBase {

/*
  protected $entityQuery;


  public function __construct(QueryFactory $entity_query) {
    $this->entityQuery = $entity_query;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.query')
    );
  }*/

  /** * Return random nodes in a formatted JSON response. * * @return \Symfony\Component\HttpFoundation\JsonResponse * The formatted JSON response. */
  public function getRandomNodes() {

    $nids  = \Drupal::entityQuery('node')
                    ->condition('type', 'device')
                    ->execute();
    $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);


    $index = 0;
    foreach ($nodes as $n) {
      $t = $n->getTypedData()->get('title')->getValue();
      $b = $n->getTypedData()->get('body')->getValue();

      $assoc_array[$index]['title'] = $t;
      $assoc_array[$index]['body']  = $b;
      $index++;
    }

    if (empty($assoc_array)) {
      return (new CacheableJsonResponse(['message' => 'no data'], 300));
    }

    return new CacheableJsonResponse($assoc_array, 200);
  }

}
