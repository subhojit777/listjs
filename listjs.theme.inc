<?php

/**
 * @file
 * Contains theme helper functions.
 */

/**
 * Add more variables to listjs template.
 */
function template_preprocess_listjs(&$variables) {
  $listjs_list_value_names = &drupal_static('listjs_list_value_names', []);

  // We make sure that value names settings are not overridden, new settings are
  // only appended.
  // Settings get overridden when there are listjs widgets in a single page.
  if (empty($listjs_list_value_names[$variables['list_id']])) {
    $listjs_list_value_names[$variables['list_id']] = $variables['value_names'];
  }

  // @TODO Use the default `attributes` key behavior.
  $variables['list_attributes']['class'][] = 'list';
  $variables['attributes'] = $variables['list_attributes'];

  // Add default settings and resources.
  $variables['#attached']['drupalSettings']['listJs']['valueNames'] = $listjs_list_value_names;
  $variables['#attached']['library'][] = 'listjs/drupal.listjs';
}
