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
            Drupal.listJs.enableListJs(settings.facetapi.facets[i].listJs, options);
          }
        }
      }
      else {
        options = {
          valueNames: settings.listJs.valueNames.map(function(currentValue) {
            return currentValue.value_name;
          })
        };
        Drupal.listJs.enableListJs(settings.listJs, options);
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
  }
}(jQuery));
