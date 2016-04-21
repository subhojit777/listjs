<?php

/**
 * @file
 * The listjs widget plugin classes.
 */

/**
 * Widget that renders facets as a searchable list of clickable links.
 *
 * Links make it easy for users to narrow down their search results by clicking
 * on them. The render arrays use theme_listjs() to generate the HTML markup.
 */
class FacetapiWidgetListjs extends FacetapiWidgetLinks {

  /**
   * Overrides FacetapiWidgetLinks::init().
   */
  public function init() {
    parent::init();

    // Override render array so that it can be themed using theme_listjs().
    $this->build['listjs']['#list_id'] = $this->build['#attributes']['id'] . '-wrapper';
    // We could have got the class attribute from `$this->build` itself, but I
    // preferred to create value name here so that it is independent of the
    // attributes generated in the parent class.
    // @see FacetapiWidget::init()
    $this->build['listjs']['#value_name'] = drupal_html_class("facetapi-facet-{$this->facet['name']}-name");
    $this->build['listjs']['#value_names'][] = array(
      'value_name' => $this->build['listjs']['#value_name'],
      'sort' => $this->settings->settings['sort'],
      'sort_text' => $this->settings->settings['sort_text'],
    );
    $this->jsSettings['listJs']['listId'] = $this->build['listjs']['#list_id'];
    $this->jsSettings['listJs']['valueNames'] = $this->build['listjs']['#value_names'];

    return $this;
  }

  /**
   * Implements FacetapiWidgetLinks::execute().
   *
   * Transforms the render array into something that can be themed by
   * theme_listjs().
   *
   * @see FacetapiWidgetLinks::setThemeHooks()
   * @see FacetapiWidgetLinks::buildListItems()
   */
  public function execute() {
    $element = &$this->build[$this->facet['field alias']];

    // Sets each item's theme hook, builds item list.
    $this->setThemeHooks($element);
    $element = array(
      '#theme' => 'listjs',
      '#items' => $this->buildListItems($element),
      '#placeholder_text' => $this->settings->settings['placeholder_text'],
      '#list_attributes' => $this->build['#attributes'],
      '#list_id' => $this->build['listjs']['#list_id'],
      '#value_names' => $this->build['listjs']['#value_names'],
    );
  }

  /**
   * Overrides FacetapiWidgetLinks::settingsForm().
   */
  function settingsForm(&$form, &$form_state) {
    parent::settingsForm($form, $form_state);

    $form['widget']['widget_settings']['listjs'][$this->id]['placeholder_text'] = array(
      '#type' => 'textfield',
      '#title' => t('Placeholder text'),
      '#default_value' => $this->settings->settings['placeholder_text'],
      '#states' => array(
        'visible' => array(
          'select[name="widget"]' => array(
            'value' => 'listjs',
          ),
        ),
      ),
    );

    $form['widget']['widget_settings']['listjs'][$this->id]['sort'] = array(
      '#type' => 'checkbox',
      '#title' => t('Sortable'),
      '#default_value' => $this->settings->settings['sort'],
      '#states' => array(
        'visible' => array(
          'select[name="widget"]' => array(
            'value' => 'listjs',
          ),
        ),
      ),
    );

    $form['widget']['widget_settings']['listjs'][$this->id]['sort_text'] = array(
      '#type' => 'textfield',
      '#title' => t('Sort text'),
      '#default_value' => $this->settings->settings['sort_text'],
      '#states' => array(
        'visible' => array(
          'select[name="widget"]' => array(
            'value' => 'listjs',
          ),
        ),
      ),
    );
  }

  /**
   * Overrides FacetapiWidgetLinks::getDefaultSettings().
   */
  function getDefaultSettings() {
    $settings = parent::getDefaultSettings();
    $settings['placeholder_text'] = t('Filter');
    $settings['sort'] = FALSE;
    $settings['sort_text'] = t('Sort');
    return $settings;
  }

  /**
   * Overrides FacetapiWidgetLinks::getItemClasses().
   */
  public function getItemClasses() {
    return array(
      'facetapi-listjs',
      $this->build['listjs']['#value_name'],
    );
  }

}
