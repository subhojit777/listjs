(function ($) {
  Drupal.behaviors.listjs = {
    attach: function(context, settings) {
      var options = {};

      if (settings.facetapi) {
        for (var i = 0; i < settings.facetapi.facets.length; i++) {
          if (settings.facetapi.facets[i].listJs) {
            options = {
              valueNames: settings.facetapi.facets[i].listJs.contentAttributes
            };
            Drupal.listJs.enableListJs(settings.facetapi.facets[i].listJs, options);
          }
        }
      }
      else {
        options = {
          valueNames: settings.listJs.contentAttributes
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
   * Enable list js.
   */
  Drupal.listJs.enableListJs = function(settings, options) {
    var listJs = new List(settings.listId, options);
  }
}(jQuery));
