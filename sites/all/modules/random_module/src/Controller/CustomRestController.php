<?php

namespace Drupal\random_module\Controller;

use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\Query\QueryFactory;

/*** Class CustomRestController.*/
class CustomRestController extends ControllerBase {

  /** * Entity query factory. * * @var \Drupal\Core\Entity\Query\QueryFactory */
  //protected $entityQuery;

  /** * Constructs a new CustomRestController object. * @param \Drupal\Core\Entity\Query\QueryFactory $entityQuery * The entity query factory. */
  /*
  public function __construct(){//QueryFactory $entity_query) {
    //$this->entityQuery = $entity_query;
  }
*/
  /** * {@inheritdoc} */
  /*
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.query')
    );
  }


  */
  /** * Return the 10 most recently updated nodes in a formatted JSON response. * * @return \Symfony\Component\HttpFoundation\JsonResponse * The formatted JSON response. */
  public function getLatestNodes() {

    $nids = \Drupal::entityQuery('node')->condition('type','device')->execute();
    $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);


    $index = 0;
    foreach ($nodes as $n)
    {
      $t = $n->getTypedData()->get('title')->getValue();
      $b = $n->getTypedData()->get('body')->getValue();

      $rarray[$index]['title'] = $t;
      $rarray[$index]['body'] = $b;
      $index ++;
    }

    $response = new CacheableJsonResponse($rarray);

    return $response;

  }

}
