<?php

namespace Drupal\random_module\Plugin\Block;

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

    $stash_array = [
      'hello',
      'it\'s ok',
      'be well',
      'good luck!',
      'see you',
      'that\'s ok',
      'see you soon',
      'what a great idea!',
      'enjoy it',
      'glad to see yea!',
      'seems good!',
      'the real realm'
    ];

    $rand = random_int(0, count($stash_array) - 1);

    return [
      '#markup' => $this->t('Random words: ' . $stash_array[$rand]),
      //$this->t('RandomBlock!'),
    ];
  }

  public function getCacheMaxAge() {
    return 0;
  }

}
