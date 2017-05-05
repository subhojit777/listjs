<?php

/**
 * @file
 * Contains theme helper functions.
 */

use Drupal\Component\Utility\Html;
use Drupal\Core\Template\Attribute;

/**
 * Adds more variables to views_view_listjs template.
 */
function template_preprocess_views_view_listjs(&$variables) {
  $items = [];
  $view = $variables['view'];
  $rows = $variables['rows'];
  $fields = $view->field;
  $handler = $view->style_plugin;
  $filterable_fields = $handler->options['filterable_fields'];

  // This is for suppressing PHP warnings if there is no `filterable_fields`
  // settings.
  $variables['value_names'] = [];

  /* --- Prepare value names (start) --- */
  foreach ($view->display_handler->getHandlers('field') as $field_handler) {
    if (isset($filterable_fields[$field_handler->field]) &&
      $filterable_fields[$field_handler->field]['filterable'] == 1 &&
      !($field_handler->options['exclude'])) {

      $element_classes = $field_handler->elementClasses();
      $element_wrapper_classes = $field_handler->elementWrapperClasses();

      if (!empty($element_classes)) {
        $value_names = $element_classes;
      }
      elseif (!empty($element_wrapper_classes)) {
        $value_names = $element_wrapper_classes;
      }
      else {
        // Views has hard coded this class.
        // @see template_preprocess_views_view_fields()
        $value_names = Html::getClass('views-field-' . $field_handler->field);
      }

      $variables['value_names'][$value_names] = [
        'sort' => $handler->options['filterable_fields'][$field_handler->field]['sort'],
        'sort_text' => $handler->options['filterable_fields'][$field_handler->field]['sort_text'],
      ];
    }
  }
  /* --- Prepare value names (end) --- */

  /* --- Prepare items to be shown in the list (start) --- */
  foreach ($rows as $id => $row) {
    $item = [];

    foreach ($fields as $field_name => $field) {
      if (!$field->options['exclude']) {
        $class = [];
        $field_output = $handler->getField($id, $field_name);

        if (trim($field_output) != '') {
          // If `wrapper_element` not specified, then we consider `div` as
          // wrapper element.
          $item[$field_name]['wrapper_element'] = empty($field->elementWrapperType(TRUE, TRUE)) ? 'div' : $field->elementWrapperType(TRUE, TRUE);

          /* --- Prepare row classes (start) --- */
          if ($field->options['element_default_classes']) {
            $class = [
              'views-field',
              "views-field-$field_name",
            ];
          }

          if (!empty($field->elementWrapperClasses($id))) {
            $class = array_merge($class, explode(' ', $field->elementWrapperClasses($id)));
          }

          $item[$field_name]['attributes'] = new Attribute([
            'class' => $class,
          ]);
          /* --- Prepare row classes (end) --- */

          $item[$field_name]['data'] = [
            '#markup' => $field_output,
          ];
        }
      }
    }

    if (!empty($item)) {
      $items[] = $item;
    }
  }
  /* --- Prepare items to be shown in the list (end) --- */

  $variables['items'] = $items;
  $variables['list_id'] = "{$view->id()}-{$view->current_display}-wrapper";
  $variables['attributes']['class'] = ['list'];

  // Add default settings and resources.
  module_load_include('inc', 'listjs', 'listjs.theme');
  $variables['#attached']['drupalSettings']['listJs']['valueNames'] = listjs_prepare_list_value_names($variables['list_id'], $variables['value_names']);
  $variables['#attached']['library'][] = 'listjs/drupal.listjs';

  $variables['filter_attributes'] = new Attribute([
    'class' => ['search'],
    'placeholder' => $handler->options['placeholder_text'],
    'name' => "{$variables['list_id']}-filter",
    'type' => 'text',
  ]);

  /* --- Prepare attributes for sort button (start) --- */
  foreach ($variables['value_names'] as $value_name => $conf) {
    if ($conf['sort']) {
      $variables['sort_attributes'][$value_name] = new Attribute([
        'type' => 'submit',
        'class' => ['sort'],
        'data-sort' => $value_name,
        'value' => $conf['sort_text'],
      ]);
    }
  }
  /* --- Prepare attributes for sort button (end) --- */
}
