<?php

/**
 * @file
 * Listjs style plugin.
 */

/**
 * Implements a style type plugin for the Views module.
 */
class ListjsViewsListjsPluginStyle extends views_plugin_style {

  /**
   * Set default options.
   */
  function option_definition() {
    $options = parent::option_definition();

    $options['placeholder_text'] = array(
      'default' => t('Filter'),
      'translatable' => TRUE,
    );
    $options['filterable_fields'] = array(
      'default' => array(),
    );

    return $options;
  }

  /**
   * Show a form to edit the style options.
   */
  function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);

    $form['placeholder_text'] = array(
      '#type' => 'textfield',
      '#title' => t('Placeholder text for search box'),
      '#default_value' => $this->options['placeholder_text'],
    );

    $form['filterable_fields'] = array(
      '#title' => t('Filterable fields'),
      '#type' => 'fieldset',
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
      '#tree' => TRUE,
    );

    foreach ($this->view->display_handler->get_handlers('field') as $field => $handler) {
      $form['filterable_fields'][$field] = array(
        '#title' => $handler->ui_name(),
        '#type' => 'fieldset',
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
        '#tree' => TRUE,
      );

      $form['filterable_fields'][$field]['filterable'] = array(
        '#type' => 'checkbox',
        '#title' => t('Filterable'),
        '#default_value' => !isset($this->options['filterable_fields'][$field]['filterable']) ? TRUE : $this->options['filterable_fields'][$field]['filterable'],
      );

      $form['filterable_fields'][$field]['sort'] = array(
        '#type' => 'checkbox',
        '#title' => t('Sortable'),
        '#default_value' => !isset($this->options['filterable_fields'][$field]['sort']) ? FALSE : $this->options['filterable_fields'][$field]['sort'],
        '#dependency' => array(
          "edit-style-options-filterable-fields-$field-filterable" => array(1),
        ),
      );

      $form['filterable_fields'][$field]['sort_text'] = array(
        '#type' => 'textfield',
        '#title' => t('Sort text'),
        '#default_value' => !isset($this->options['filterable_fields'][$field]['sort_text']) ? t('@field_name sort', array('@field_name' => $handler->ui_name())) : $this->options['filterable_fields'][$field]['sort_text'],
        '#dependency' => array(
          "edit-style-options-filterable-fields-$field-filterable" => array(1),
        ),
      );
    }
  }

  /**
   * Validate style options.
   */
  function options_validate(&$form, &$form_state) {
    foreach ($form_state['values']['style_options']['filterable_fields'] as $field => $options) {
      if ($options['sort'] == 1 && empty($options['sort_text'])) {
        form_error($form['filterable_fields'][$field]['sort_text'], t('Sort text is required if sort is enabled'));
      }
    }
  }

  /**
   * Render the display in this style.
   */
  function render() {
    $output = theme('listjs', array(
      'view' => $this->view,
      'options' => $this->options,
      'rows' => $this->view->result,
    ));

    return $output;
  }

}
