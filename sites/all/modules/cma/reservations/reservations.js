/*
 +---------------------------------------------------------------------------+
 | Copyright (C) 2009 Openflows, Inc. + Blue Bag. All rights reserved.       |
 |                                                                           |
 | This work is published under the GNU AGPLv3 license without any           |
 | warranty. For full license and copyright information, see                 |
 | https://www.gnu.org/licenses/agpl-3.0.html                                |
 +---------------------------------------------------------------------------+
 */

 (function ($) {

  Drupal.behaviors.reservationsCheckAll = {
    attach: function (context, settings) {
      $("#reservations-check-all").click(function () {
	$(".reservations-check-in").attr('checked', $(this).attr('checked'));
      });

      $(document).ready(function() {

      });
    }
  };


  Drupal.behaviors.reservationConfirmation = {
      attach: function (context, settings) {

        //If we have a the charity poll overlay
        if ($('#reservations_dialog').length > 0) {
            // Open the overlay and set the dialog settings.
            $('#reservations_dialog').dialog({
                modal: true,
                resizable: false,
                title: "Confirmation requiered",
                width: "auto",
                dialogClass: 'reservations-dialog',
                buttons: {
                    "Delete selected item(s)": function () {
                         $('input[name=dialog_delete_items_confirmation_value]').val(1);

                        $(this).dialog("close");
                        $('#edit-submit').trigger('click');
                    },
                    Cancel: function () {
                        $(this).dialog("close");
                    }

                },
                create: function (event, ui) {
                    // Set maxWidth
                    $(this).css("maxWidth", "500px");
                }
            });
        }

      }
  };

}) (jQuery);
