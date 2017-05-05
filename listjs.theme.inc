<?php

/**
 * @file
 * Contains theme helper functions.
 */

/**
 * Adds more variables to listjs template.
 */
function template_preprocess_listjs(&$variables) {
  $variables['attributes']['class'][] = 'list';

  // Add default settings and resources.
  $variables['#attached']['drupalSettings']['listJs']['valueNames'] = listjs_prepare_list_value_names($variables['list_id'], $variables['value_names']);
  $variables['#attached']['library'][] = 'listjs/drupal.listjs';
}

/**
 * Prepares value names suitable for drupal.listjs library.
 *
 * @param string $list_id
 *   List id.
 * @param array $value_names
 *   Key settings pair of value names.
 *
 * @return array
 *   An associative array that is suitable for drupal.listjs library.
 *   The array is in this format:
 *   list_id => [
 *     'value-name-1' => [
 *       'sort' => TRUE,
 *       'sort_text' => 'Sort me',
 *     ],
 *     'value-name-2' => [
 *       'sort' => FALSE,
 *       'sort_text' => 'Do not sort me',
 *     ],
 *   ];
 */
function listjs_prepare_list_value_names($list_id, array $value_names) {
  $listjs_list_value_names = &drupal_static('listjs_list_value_names', []);

  // We make sure that value names settings are not overridden, new settings are
  // only appended.
  // This fixes the problem of settings getting overridden if there are multiple
  // listjs widgets in a single page.
  if (empty($listjs_list_value_names[$list_id])) {
    $listjs_list_value_names[$list_id] = $value_names;
  }

  return $listjs_list_value_names;
}
