<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Random' Block.
 *
 * @Block(
 *   id = "random_block",
 *   admin_label = @Translation("Random block"),
 *   category = @Translation("Random Words"),
 * )
 */
class RandomBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $stash_array = ['hello', 'it\'s ok', 'be well', 'good luck!', 'see you', 'that\'s ok'];

    $rand = random_int(0, count($stash_array) -1);
    return [
      '#markup' => $this->t($stash_array[$rand]), //$this->t('RandomBlock!'),
    ];
  }

}
