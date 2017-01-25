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
            '#markup' => '<div class="value_name-cat">Kitty</div>',
          ],
        ],
        [
          'data' => [
            '#markup' => '<div class="value_name-cat">Binky</div>',
          ],
        ],
        [
          'data' => [
            '#markup' => '<div class="value_name-cat">Chinky</div>',
          ],
        ],
        [
          'data' => [
            '#markup' => '<div class="value_name-cat">Tabby</div>',
          ],
        ],
      ],
      '#list_attributes' => [
        'class' => [
          'mykittens',
        ],
      ],
      '#list_id' => 'mykittens-are-unique',
      '#value_names' => [
        [
          'value_name-cat' => [
            'sort' => TRUE,
            'sort_text' => $this->t('Sort Kittens'),
          ],
        ],
      ],
    ];
  }

}
