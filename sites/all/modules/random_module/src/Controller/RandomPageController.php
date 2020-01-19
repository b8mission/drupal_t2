<?php

namespace Drupal\random_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines HelloController class.
 */
class RandomPageController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content() {

    $template = $this->front();//include('templates/RandomPage.php');

    $build['form']['#attached']['library'][] = 'random_module/random_page_js_lib';

    return [
      '#type'     => 'markup',
      '#markup'   => $this->t(($template)),
      '#attached' => [
        'library' => [
          'random_module/random_page_js_lib',
        ],
      ],
    ];
  }


  private function front() {
    ob_start(); ?>
    <form id='randomForm1' name='randomForm1'>
      <div>

        <input type="button" value="Magic Button" onclick="loadDoc();"
               id="randomButton">

        <label for="restroute1">
          <input type="radio" id="restroute1" name="route"
                 value="/api/random-endpoint" checked>
          route 1: /api/random-endpoint
        </label>

        <label for="restroute2">
          <input type="radio" id="restroute2" name="route"
                 value="/api/random-endpoint2">
          route 2: /api/random-endpoint2
        </label>

      </div>

    </form>

    <table id="randomNodes"></table>
    <?php

    return ob_get_clean();
  }

}
