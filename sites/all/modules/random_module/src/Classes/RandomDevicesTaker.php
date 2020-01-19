<?php

namespace Drupal\random_module\Classes;

class RandomDevicesTaker {


  public static function getRandomNodes(&$result, $titles_only = FALSE): bool {
    $nodes       = self::getNodes();
    $total_count = count($nodes);

    if ($total_count < 1) {
      return FALSE;
    }

    if (self::getRandomIndexes($total_count, $indexes) === FALSE) {
      return FALSE;
    }

    $result = self::getNodesByIndexes($nodes, $indexes, $titles_only);
    return TRUE;
  }


  private static function getNodes() {
    $nids  = \Drupal::entityQuery('node')
                    ->condition('type', 'device')
                    ->execute();
    $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);

    return $nodes;
  }

  private static function getNodesByIndexes(array &$nodes, &$indexes, bool $titlesOnly = FALSE): array {
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


  private static function getRandomIndexes($total_count, &$indexes): bool {
    if ($total_count < 1) {
      return FALSE;
    }

    $random_quantity = random_int(1, (ceil($total_count / 2)));

    if ($random_quantity < 1) {
      return FALSE;
    }
    //random quantity is chosen


    //indexes randomize is next
    $indexes = [];
    for ($x = 0; $x < $random_quantity; $x++) {

      A:
      $candidate = random_int(1, $total_count - 1);
      if (in_array($candidate, $indexes)) {
        goto A;
      }

      $indexes[$x] = $candidate;
    }

    return TRUE;
  }

}
