/**
 * @file
 * Enables ListJs for lists.
 */

(function ($, Drupal) {
  'use strict';

  /**
   * Enables listjs widget for lists.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Enables the widget for each id.
   */
  Drupal.behaviors.listjs = {
    attach: function (context, settings) {
      $.each(settings.listJs.valueNames, function (listId, value) {
        $('#' + listId).once('listjs').each(function () {
          Drupal.listJs.enableListJs(listId, {
            valueNames: Object.keys(value)
          });
        });
      });
    }
  };

  /**
   * Class containing functionality for listjs.
   *
   * @namespace
   */
  Drupal.listJs = {};

  /**
   * Enables listjs widget.
   *
   * It also enables the events.
   * This is a normal function. We can convert this to a constructor if we want
   * to add behaviors.
   * See https://www.drupal.org/node/2183405
   *
   * @param {string} listId
   *   HTML id that will use listjs widget.
   * @param {object} options
   *   Key value pair of settings that is used while enabling the widget.
   */
  Drupal.listJs.enableListJs = function (listId, options) {
    /* global List:true */
    var listJs = new List(listId, options);

    // Invoke events.
    // See http://www.listjs.com/docs/list-api
    listJs.on('updated', function (listJs) {
      $(document).trigger('listJsUpdated', [listJs]);
    }).on('searchStart', function (listJs) {
      $(document).trigger('listJsSearchStart', [listJs]);
    }).on('searchComplete', function (listJs) {
      $(document).trigger('listJsSearchComplete', [listJs]);
    }).on('filterStart', function (listJs) {
      $(document).trigger('listJsFilterStart', [listJs]);
    }).on('filterComplete', function (listJs) {
      $(document).trigger('listJsFilterComplete', [listJs]);
    }).on('sortStart', function (listJs) {
      $(document).trigger('listJsSortStart', [listJs]);
    }).on('sortComplete', function (listJs) {
      $(document).trigger('listJsSortComplete', [listJs]);
    });
  };
})(jQuery, Drupal);
