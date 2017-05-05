<?php

namespace Drupal\listjs_theme_test\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 *
 * @package Drupal\listjs_theme_test\Controller
 */
class DefaultController extends ControllerBase {

  /**
   * Render.
   *
   * @return array
   *   Returns renderable array.
   */
  public function render() {
    return [
      '#theme' => 'listjs',
      '#placeholder_text' => $this->t('Kittens'),
      '#items' => [
        [
          'data' => [
            '#markup' => '<h2 class="value_name-house">Jones\'s</h2><div class="value_name-cat">Kitty</div>',
          ],
        ],
        [
          'data' => [
            '#markup' => '<h2 class="value_name-house">Hudson\'s</h2><div class="value_name-cat">Binky</div>',
          ],
        ],
        [
          'data' => [
            '#markup' => '<h2 class="value_name-house">Paul\'s</h2><div class="value_name-cat">Chinky</div>',
          ],
        ],
        [
          'data' => [
            '#markup' => '<h2 class="value_name-house">Singh\'s</h2><div class="value_name-cat">Tabby</div>',
          ],
        ],
      ],
      '#attributes' => [
        'class' => [
          'mykittens',
        ],
      ],
      '#list_id' => 'mykittens-are-unique',
      '#value_names' => [
        'value_name-cat' => [
          'sort' => TRUE,
          'sort_text' => $this->t('Sort Kittens'),
        ],
        'value_name-house' => [
          'sort' => FALSE,
          'sort_text' => $this->t('Sort House'),
        ],
      ],
    ];
  }

}
