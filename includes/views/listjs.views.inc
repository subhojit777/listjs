<?php

/**
 * @file
 * Views hook implementations.
 */

/**
 * Implements hook_views_plugins().
 */
function listjs_views_plugins() {
  // Style plugin for the listjs.
  return array(
    'style' => array(
      'listjs' => array(
        'title' => t('List.js'),
        'help' => t('Display the results in a list.js widget.'),
        'handler' => 'ViewsListjsPluginStyleListjs',
        'uses row plugin' => FALSE,
        'uses row class' => TRUE,
        'uses fields' => TRUE,
        'uses options' => TRUE,
        'uses grouping' => FALSE,
        'type' => 'normal',
      ),
    ),
  );
}
