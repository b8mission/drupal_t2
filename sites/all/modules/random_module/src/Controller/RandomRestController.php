<?php

namespace Drupal\random_module\Controller;

use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Drupal\Core\Entity\Query\QueryFactory;

//use Zend\Diactoros\Response\JsonResponse;

/*** Class CustomRestController.*/
class RandomRestController extends ControllerBase {

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

    $nids        = \Drupal::entityQuery('node')
                          ->condition('type', 'device')
                          ->execute();
    $nodes       = \Drupal\node\Entity\Node::loadMultiple($nids);
    $total_count = count($nodes);


    if ($this->getRandoms($total_count, $random_count, $indexes) === FALSE) {
      return (new JsonResponse(['message' => 'no data'], 300));
    }


    $assoc_array = $this->getNodes($nodes, $indexes);


    if (empty($assoc_array)) {
      return (new JsonResponse(['message' => 'no data'], 300));
    }

    return new JsonResponse($assoc_array, 200);
  }


  private function getNodes(array &$nodes, &$indexes, bool $titlesOnly = FALSE): array {
    $assoc_array = [];

    foreach ($indexes as $ind) {
      $t = $nodes[$ind + 1]->getTypedData()->get('title')->getValue();
      $b = $nodes[$ind + 1]->getTypedData()->get('body')->getValue();


      if ($titlesOnly) {//take only the titles
        $assoc_array['data'][] = ['title' => $t,];
      }
      else {//take titles + bodies
        $assoc_array['data'][] = ['title' => $t, 'body' => $b];
      }

    }

    return $assoc_array;
  }


  private function getRandoms($total_count, &$random_count, &$indexes): bool {
    if ($total_count < 1) {
      return FALSE;
    }

    $random_count = random_int(0, $total_count);

    if ($random_count < 1) {
      return FALSE;
    }

    $indexes = [];

    for ($x = 0; $x < $random_count; $x++) {

      A:
      $candidate = random_int(0, $total_count - 1);
      if (in_array($candidate, $indexes)) {
        goto A;
      }

      $indexes[$x] = $candidate;
    }

    return TRUE;
  }


}
