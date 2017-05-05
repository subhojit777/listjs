<?php

namespace Drupal\listjs_views\Plugin\views\style;

use Drupal\core\form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Listjs views display style.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "listjs",
 *   title = @Translation("Listjs"),
 *   help = @Translation("Render a list in listjs format."),
 *   theme = "views_view_listjs",
 *   display_types = { "normal" }
 * )
 */
class Listjs extends StylePluginBase {

  /**
   * Does the style plugin for itself support to add fields to it's output.
   *
   * @var bool
   */
  protected $usesFields = TRUE;

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['placeholder_text'] = [
      'default' => $this->t('Filter'),
      'translatable' => TRUE,
    ];
    $options['filterable_fields'] = [
      'default' => [
        'title' => [
          'filterable' => TRUE,
          'sort' => FALSE,
          'sort_text' => $this->t('Content: Title sort'),
        ],
      ],
    ];

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['placeholder_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder text for search box'),
      '#default_value' => $this->options['placeholder_text'],
    ];

    $form['filterable_fields'] = [
      '#title' => $this->t('Filterable fields'),
      '#type' => 'fieldset',
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
      '#tree' => TRUE,
    ];

    foreach ($this->displayHandler->getHandlers('field') as $field => $handler) {
      $field_label = $this->displayHandler->getFieldLabels()[$field]->__toString();

      $form['filterable_fields'][$field] = [
        '#title' => $field_label,
        '#type' => 'fieldset',
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
        '#tree' => TRUE,
      ];

      $form['filterable_fields'][$field]['filterable'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Filterable'),
        '#default_value' => !isset($this->options['filterable_fields'][$field]['filterable']) ? TRUE : $this->options['filterable_fields'][$field]['filterable'],
      ];

      $form['filterable_fields'][$field]['sort'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Sortable'),
        '#default_value' => !isset($this->options['filterable_fields'][$field]['sort']) ? FALSE : $this->options['filterable_fields'][$field]['sort'],
      ];

      $form['filterable_fields'][$field]['sort_text'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Sort text'),
        '#default_value' => !isset($this->options['filterable_fields'][$field]['sort_text']) ? $this->t('@field_name sort', ['@field_name' => $field_label]) : $this->options['filterable_fields'][$field]['sort_text'],
      ];
    }
  }

}
