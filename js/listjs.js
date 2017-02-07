/**
 * @file
 * Enables ListJs for lists.
 */

(function ($) {
  Drupal.behaviors.listjs = {
    attach: function(context, settings) {
      $.each(settings.listJs.valueNames, function(listId, value) {
        $('#' + listId).once('listjs').each(function() {
          Drupal.listJs.enableListJs(listId, {
            valueNames: Object.keys(value)
          });
        });
      });
    }
  }

  /**
   * Class containing functionality for listjs.
   */
  Drupal.listJs = {}

  /**
   * Enable listjs.
   */
  Drupal.listJs.enableListJs = function(listId, options) {
    var listJs = new List(listId, options);

    // Invoke events.
    // @see http://www.listjs.com/docs/list-api
    listJs.on('updated', function(listJs) {
      $(document).trigger('listJsUpdated', [listJs]);
    }).on('searchStart', function(listJs) {
      $(document).trigger('listJsSearchStart', [listJs]);
    }).on('searchComplete', function(listJs) {
      $(document).trigger('listJsSearchComplete', [listJs]);
    }).on('filterStart', function(listJs) {
      $(document).trigger('listJsFilterStart', [listJs]);
    }).on('filterComplete', function(listJs) {
      $(document).trigger('listJsFilterComplete', [listJs]);
    }).on('sortStart', function(listJs) {
      $(document).trigger('listJsSortStart', [listJs]);
    }).on('sortComplete', function(listJs) {
      $(document).trigger('listJsSortComplete', [listJs]);
    });
  }
}(jQuery));
