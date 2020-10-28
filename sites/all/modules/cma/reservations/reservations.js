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

        //If we have a the reservations dialog
        if ($('#reservations_dialog').length > 0) {
            // Open the dialog and set the dialog settings.
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

  Drupal.behaviors.variationDetails = {
    attach: function (context, settings) {
      $(document).ready(function() {
        hideVariationDetails();
      });

      $( document ).delegate( '#edit-field-reservable-variances .multiselect_remove', 'click', function(e) {
        hideVariationDetails();
      });

      $( document ).delegate( '#edit-field-reservable-variances .multiselect_add', 'click', function(e) {
        hideVariationDetails();
      });

      function hideVariationDetails() {
        var variance_selected = $("#edit-field-reservable-variances .field_reservable_variances_sel").children();

        //has the variance select options box got any values?
        if (variance_selected.length > 0 ) {
          $('#edit-field-variance-reason').show();
          $('#edit-field-variance-date').show();
        } else {
          $('#edit-field-variance-reason').hide();
          $('#edit-field-variance-date').hide();
        }


      }
    }
  };

}) (jQuery);
