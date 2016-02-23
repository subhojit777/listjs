<?php

/**
 * @file
 * Theme functions for listjs theme.
 */

/**
 * Add more variables to listjs template.
 */
function template_preprocess_adb_listjs(&$variables) {
  // Alter variables if it is rendered from view.
  if (!empty($variables['view'])) {
    $items = array();
    $view = $variables['view'];

    $row_plugin = $view->style_plugin->row_plugin;

    // Prepare items to be shown in the list.
    foreach ($variables['rows'] as $id => $row) {
      $view->row_index = $id;
      $item['title'] = $row_plugin->render($row);
      $items[] = $item;
    }

    $variables['items'] = $items;
    $variables['placeholder_text'] = $variables['options']['placeholder_text'];
  }

  drupal_add_js(drupal_get_path('module', 'adb_views_listjs') . '/js/list.min.js');
  drupal_add_js(drupal_get_path('module', 'adb_views_listjs') . '/js/adb_views_listjs.js');
}
