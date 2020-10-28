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
  Drupal.behaviors.checkinoptions = {
    attach: function (context, settings) {
      //Initial set-up of the fields.

      /* //Disable checkboxes for option 1
      $(".reservations-check-in").click(function() {
        var selopt = $("#edit-checkout-options option:selected").val();
        if (selopt == 1) {
          return false;
        }
      });

      // Disable the status.
      $('input[name ="reservations_reservation_status"]').click(function() {
        return false;
      }); */

      //Enalbe all fields when a submit button is clicked.
      $("input[type=submit]").click(function() {
        enableAllFields();
      });

      setupCheckInFields(true);

      $("#edit-checkout-options").change(function () {
        setupCheckInFields(false);
      });
    }
  };

  //Function to enable all the fields so that they get submitted.
  function enableAllFields() {
    //Enable the date fields
    $("#edit-field-reservations-date-und-0-value-datepicker-popup-0").prop( "disabled", false );
    $("#edit-field-reservations-date-und-0-value-timeEntry-popup-1").prop( "disabled", false );
    $("#edit-field-reservations-date-und-0-value2-datepicker-popup-0").prop( "disabled", false );
    $("#edit-field-reservations-date-und-0-value2-timeEntry-popup-1").prop( "disabled", false )

    //Enable the check boxes
    $("#reservations-check-all").prop( "disabled", false );
    $(".reservations-check-in").prop( "disabled", false );

    //enable the status
    $('input[name ="reservations_reservation_status"').prop( "disabled", false );
  }

  //Function to enable /disable required fields
  function setupCheckInFields(pageload = false){
    var extend_date = $("div.form-item-checkout-extend-date");
    var checkout_options = $("#edit-checkout-options").val();

    //if (initial_state == "3") {
      //If the initial status is Checked OUt (3)

      //Disable the start and end dates
      $("#edit-field-reservations-date-und-0-value-datepicker-popup-0").prop( "disabled", true );
      $("#edit-field-reservations-date-und-0-value-timeEntry-popup-1").prop( "disabled", true );
      $("#edit-field-reservations-date-und-0-value2-datepicker-popup-0").prop( "disabled", true );
      $("#edit-field-reservations-date-und-0-value2-timeEntry-popup-1").prop( "disabled", true );

      switch (checkout_options) {
        case '1':
          // Checkin all items on the reservation

          //Hide extend date
          extend_date.fadeOut();

          //Check all items.
          $(".reservations-check-in").attr('checked', 'checked');

          //disable checkboxes
          $("#reservations-check-all").prop( "disabled", true );
          $(".reservations-check-in").prop( "disabled", true );

          // //Enable end date
          $("#edit-field-reservations-date-und-0-value2-datepicker-popup-0").prop( "disabled", false );
          $("#edit-field-reservations-date-und-0-value2-timeEntry-popup-1").prop( "disabled", false );

          //Set and disable the status
          $("#edit-reservations-reservation-status-4").prop("checked", true);
          $('input[name ="reservations_reservation_status"').prop( "disabled", true );

          $(this).trigger('formUpdated');
          break;

        case '2':
          // Extend all or part of the reservation

          //Show extend date
          extend_date.fadeIn();

          //Un-Check all items.
          if (pageload == false) {
            $(".reservations-check-in").attr('checked', false);
          }


          //Enable checkboxes
          $("#reservations-check-all").prop( "disabled", false );
          $(".reservations-check-in").prop( "disabled", false );

          // //Enable end date
          $("#edit-field-reservations-date-und-0-value2-datepicker-popup-0").prop( "disabled", false );
          $("#edit-field-reservations-date-und-0-value2-timeEntry-popup-1").prop( "disabled", false );

          //Set and disable the status
          $("#edit-reservations-reservation-status-4").prop("checked", true);
          $('input[name ="reservations_reservation_status"').prop( "disabled", true );
          //$(this).trigger('formUpdated');

          break;

          case '3':
            // Change status to reserved/confirmed.

            //Hide extend date
            extend_date.fadeOut();

            //Disable end date
            $("#edit-field-reservations-date-und-0-value2-datepicker-popup-0").prop( "disabled", true );
            $("#edit-field-reservations-date-und-0-value2-timeEntry-popup-1").prop( "disabled", true );

            //Un-Check all items.
            $(".reservations-check-in").attr('checked', false);

            //disable checkboxes
            $("#reservations-check-all").prop( "disabled", true );
            $(".reservations-check-in").prop( "disabled", true );

            //Set and disable the status
            $("#edit-reservations-reservation-status-2").prop("checked", true);
            $('input[name ="reservations_reservation_status"').prop( "disabled", true );


          break;

        default :
          // -- select item ---

          //Hide extend date
          extend_date.fadeOut();

          //Disable end date
          $("#edit-field-reservations-date-und-0-value2-datepicker-popup-0").prop( "disabled", true );
          $("#edit-field-reservations-date-und-0-value2-timeEntry-popup-1").prop( "disabled", true );

          //Un-Check all items.
          $(".reservations-check-in").attr('checked', false);

          //disable checkboxes
          $("#reservations-check-all").prop( "disabled", true );
          $(".reservations-check-in").prop( "disabled", true );

          //Set and disable the status
          $("#edit-reservations-reservation-status-3").prop("checked", true);
          $('input[name ="reservations_reservation_status"').prop( "disabled", true );

          $(this).trigger('formUpdated');


      }
    //}

  }

}) (jQuery);
