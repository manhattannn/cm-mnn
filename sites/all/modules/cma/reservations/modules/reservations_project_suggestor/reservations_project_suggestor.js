(function ($) {
    
    Drupal.behaviors.reservationsProjectPopulate = {
	attach: function (context, settings) {
	    $('.rps_pick', context).live('click', function() {
	      var project_button_id = $(this).attr('id').substring(16);
	      var project_title = $(this).attr('name');

	      var field_type = 
		$("#reservations_project_suggestor_field_selector").val();

	      $("input[id^=" + field_type + "]").each(function() {
		$(this).focus();
		$(this).val(project_title+" ("+project_button_id+")");
		$(this).blur();
	      });

	    });
	}
    };    
    Drupal.behaviors.reservationsProjectSuggestor = {
	attach: function (context, settings) {
	    $('#rps_button', context).click(function() {
		$('#project_suggestor_div').html("<h2>Loading...</h2>");
		$("input[id^=edit-name]").each(function() {
		    if ($(this).attr('type') == 'text') {
			var cm_agd_url = 
			    '/reservations_project_suggestor_detail/'
			    + $(this).attr('value')
			
			$.getJSON(cm_agd_url, function(data){
			    $('#project_suggestor_div').html(data.projects);
			    
			});
		    }
		});
	    });
	}
    };
}) (jQuery);

