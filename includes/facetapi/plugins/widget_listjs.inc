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
    $this->build['#attached']['js'][] = drupal_get_path('module', 'listjs') . '/js/list.min.js';
    $this->build['#attached']['js'][] = drupal_get_path('module', 'listjs') . '/js/listjs.js';
    $this->build['listjs']['#list_id'] = $this->build['#attributes']['id'] . '-wrapper';
    // We could have got this from `$this->build` itself, but I preferred to
    // create content attribute here so that it is independent of the attributes
    // generated in the parent class.
    // @see FacetapiWidget::init()
    $this->build['listjs']['#content_attributes'] = array(
      drupal_html_class("facetapi-facet-{$this->facet['name']}-name"),
    );
    $this->jsSettings['listJs']['listId'] = $this->build['listjs']['#list_id'];
    $this->jsSettings['listJs']['contentAttributes'] = $this->build['listjs']['#content_attributes'];

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

    $attributes = $this->build['#attributes'];
    $attributes['class'][] = 'list';

    // Sets each item's theme hook, builds item list.
    $this->setThemeHooks($element);
    $element = array(
      '#theme' => 'listjs',
      '#items' => $this->buildListItems($element),
      '#placeholder_text' => $this->settings->settings['placeholder_text'],
      '#list_attributes' => $attributes,
      '#list_id' => $this->build['listjs']['#list_id'],
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
          array(
            array(
              'select[name="widget"]' => array(
                'value' => 'listjs',
              ),
            ),
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
    return $settings;
  }

  /**
   * Overrides FacetapiWidgetLinks::getItemClasses().
   */
  public function getItemClasses() {
    return array_merge(array('facetapi-listjs'), $this->build['listjs']['#content_attributes']);
  }

}
