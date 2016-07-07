/**
 * @file
 * Enables ListJs for lists.
 */

(function ($) {
  Drupal.behaviors.listjs = {
    attach: function(context, settings) {
      var options = {};

      if (settings.facetapi) {
        for (var i = 0; i < settings.facetapi.facets.length; i++) {
          if (settings.facetapi.facets[i].listJs) {
            // Obtain the value names and pass it as options to listjs.
            options = {
              valueNames: settings.facetapi.facets[i].listJs.valueNames.map(function(currentValue) {
                return currentValue.value_name;
              })
            };
            $('#' + settings.facetapi.facets[i].listJs.listId).once('listjs', function() {
              Drupal.listJs.enableListJs(settings.facetapi.facets[i].listJs, options);
            });
          }
        }
      }
      else {
        options = {
          valueNames: settings.listJs.valueNames.map(function(currentValue) {
            return currentValue.value_name;
          })
        };
        $('#' + settings.listJs.listId).once('listjs', function() {
          Drupal.listJs.enableListJs(settings.listJs, options);
        });
      }
    }
  }

  /**
   * Class containing functionality for listjs.
   */
  Drupal.listJs = {}

  /**
   * Enable listjs.
   */
  Drupal.listJs.enableListJs = function(settings, options) {
    var listJs = new List(settings.listId, options);

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
