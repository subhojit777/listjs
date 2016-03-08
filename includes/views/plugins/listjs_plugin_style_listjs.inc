<?php

/**
 * @file
 * Listjs style plugin.
 */

/**
 * Implements a style type plugin for the Views module.
 */
class ViewsListjsPluginStyleListjs extends views_plugin_style {
  /**
   * Set default options.
   */
  function option_definition() {
    $options = parent::option_definition();

    // More options.
    $options['placeholder_text'] = array('default' => FALSE);

    return $options;
  }

  /**
   * Show a form to edit the style options.
   */
  function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);

    // Available fields.
    $field_options = array();
    foreach ($this->view->display_handler->get_handlers('field') as $field => $handler) {
      $field_options[$field] = $handler->ui_name();
    }

    $form['placeholder_text'] = array(
      '#type' => 'textfield',
      '#title' => t('Placeholder text for search box'),
      '#default_value' => $this->options['placeholder_text'],
    );

    $form['filter_fields'] = array(
      '#type' => 'checkboxes',
      '#title' => t('Filterable fields'),
      '#description' => t('Select the fields on which you want to apply filter'),
      '#options' => $field_options,
      '#default_value' => $this->options['filter_fields'],
    );
  }

  /**
   * Render the display in this style.
   */
  function render() {
    // Group the rows according to the grouping field, if specified.
    $sets = $this->render_grouping($this->view->result, $this->options['grouping']);

    // Render each group separately and concatenate.
    $output = '';

    foreach ($sets as $title => $rows) {
      $output .= theme('listjs', array(
        'view' => $this->view,
        'options' => $this->options,
        'rows' => $rows,
      ));
    }

    return $output;
  }
}
