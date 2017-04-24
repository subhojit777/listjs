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
  $listjs_list_value_names = &drupal_static('listjs_list_value_names', []);
  $view = $variables['view'];
  $rows = $variables['rows'];
  $fields = $view->field;
  $handler = $view->style_plugin;
  $options = $handler->options;
  $filterable_fields = $options['filterable_fields'];

  // Prepare value names.
  foreach ($view->display_handler->getHandlers('field') as $field_handler) {
    if ($filterable_fields[$field_handler->field]['filterable'] == 1) {
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
        'sort' => $view->style_plugin->options['filterable_fields'][$field_handler->field]['sort'],
        'sort_text' => $view->style_plugin->options['filterable_fields'][$field_handler->field]['sort_text'],
      ];
    }
  }

  // Prepare items to be shown in the list.
  foreach ($rows as $id => $row) {
    $disp_item = [];

    foreach ($fields as $field_name => $field) {
      if (!$field->options['exclude']) {
        $class = [];
        $field_output = $handler->getField($id, $field_name);

        if (trim($field_output) != '') {
          $disp_item[$field_name]['wrapper_element'] = empty($field->elementWrapperType(TRUE, TRUE)) ? 'div' : $field->elementWrapperType(TRUE, TRUE);

          // Prepare row classes.
          if ($field->options['element_default_classes']) {
            $class = [
              'views-field',
              "views-field-$field_name",
            ];
          }

          if (!empty($field->elementWrapperClasses($id))) {
            $class = array_merge($class, explode(' ', $field->elementWrapperClasses($id)));
          }

          $disp_item[$field_name]['attributes'] = new Attribute([
            'class' => $class,
          ]);

          $disp_item[$field_name]['data'] = [
            '#markup' => $field_output,
          ];
        }
      }
    }

    if (!empty($disp_item)) {
      $items[] = $disp_item;
    }
  }

  $variables['items'] = $items;
  $variables['list_id'] = "{$view->id()}-{$view->current_display}-wrapper";
  $variables['attributes']['class'] = ['list'];

  // Add default settings and resources.
  if (empty($listjs_list_value_names[$variables['list_id']])) {
    $listjs_list_value_names[$variables['list_id']] = $variables['value_names'];
  }
  $variables['#attached']['drupalSettings']['listJs']['valueNames'] = $listjs_list_value_names;
  $variables['#attached']['library'][] = 'listjs/drupal.listjs';

  $variables['filter_attributes'] = new Attribute([
    'class' => ['search'],
    'placeholder' => $view->style_plugin->options['placeholder_text'],
    'name' => "{$variables['list_id']}-filter",
    'type' => 'text',
  ]);

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
}
