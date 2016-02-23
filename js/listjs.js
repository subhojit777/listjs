(function ($) {
  Drupal.behaviors.adbViewsListjs = {
    attach: function(context, settings) {
      // @TODO make the classes configurable.
      var options = {
        valueNames: ['name']
      };

      // Invoke functions.
      enableListJs();

      /**
       * Enable list js.
       */
      function enableListJs() {
        // @TODO make the id configurable.
        var listJs = new List('listjs-wrapper', options);
      }
    }
  };
}(jQuery));
