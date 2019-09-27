/**
 * @file
 *
 * Remove the link from the parent in the superfish menu
 * Replace it with the effect of opening the menu
 *
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

  $(window).resize(function(){

    timer = setTimeout(function(){
      
        $('#superfish-1-accordion > li > a.menuparent').on('click', function(event) {

            // Making sure the buttons does not exist already.
            if ($(this).closest('li').children('ul').length > 0) {
              event.preventDefault();
              // Selecting the parent menu items.
              var parent = $(this).closest('li');
              // Creating and inserting Expand\Collapse buttons to the parent menu items,
              // of course only if not already happened.

              // Once the button is clicked, collapse the sub-menu if it's expanded.
              if (parent.hasClass('sf-expanded')) {
                parent.children('ul').slideUp('fast', function() {
                  // Doing the accessibility trick after hiding the sub-menu.
                  $(this).closest('li').removeClass('sf-expanded').end().addClass('sf-hidden').show();
                });

              }
              // Otherwise, expand the sub-menu.
              else {
                // Doing the accessibility trick and then showing the sub-menu.
                parent.children('ul').hide().removeClass('sf-hidden').slideDown('fast')
                  // Changing the caption of the inserted Expand link to 'Collape', if any is inserted.
                  .end().addClass('sf-expanded').children('a.sf-accordion-button')
                  // Hiding any expanded sub-menu of the same level.
                  .end().siblings('li.sf-expanded').children('ul')
                  .slideUp('fast', function() {
                    // Doing the accessibility trick after hiding it.
                    $(this).closest('li').removeClass('sf-expanded').end().addClass('sf-hidden').show();
                  })
                  // Assuming Expand\Collapse buttons do exist, resetting captions, in those hidden sub-menus.
                  .parent().children('a.sf-accordion-button');
              }
            }

        });

    }, 75);
  });

})(jQuery, Drupal, this, this.document);
