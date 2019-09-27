/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

(function ($, Drupal, window, document, undefined) {

  Drupal.behaviors.superfishmenu = {
    attach: function (context, settings) {
      // remove the click from the parent
      $('#superfish-1 > li > a.menuparent').on('click', function(event) {
        event.preventDefault();
      });

    }
  };

})(jQuery, Drupal, this, this.document);
