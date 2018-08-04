(function($) {

	$(document).ready(function() {

		// List.js list initialization
		var options = {
		  valueNames: [ 'name' ]
		};
		var userList = new List('icos', options);

		// Sticky rows (sticky to the menu, not to the screen)
		var menuHeight = $('.wrap-menu').height();
		var icoHeadline = $('.icoHeadline');
		icoHeadline.addClass('stick-it').css('top',menuHeight);

		// Closing expanded rows during search
		$('.search').click(function() {
			$('.icoDetails').addClass('d-none');
			$('.btnSave').addClass('d-none');
		});

		// Loading fields with AJAX
		$('.parentRow' ).on('click', '.btnEdit', function(event) {

			var $button = $(this);

			$button.width($button.width()).text('...').prop( 'disabled',true);  

			var post_id = $button.data('post_id');

			// Hiding all Save buttons
			var btns_save = $('.btnSave');
			btns_save.addClass('d-none')

			// Showing Save button for clicked element
			var btn_save = '.btnSave' + post_id;
			$(btn_save).removeClass('d-none');

			// Hiding all details' containers
			var ico_details_all = $('.icoDetails');
			ico_details_all.addClass('d-none');

			// Showing details container for clicked element
			var ico_details = '.icoDetails' + post_id;
			$(ico_details).removeClass('d-none');

			// AJAX variables
			var data = {
				'action' : 'load_fields',
				'nonce' : $button.data('nonce'),
				'post_id' : post_id,		
			};	

			var load_output = '.load_output' + post_id;

			// AJAX processing
			$.post(settings.ajaxurl, data, function(response) {

				if (response.success == true) {
					$(load_output).html(response.data);
				} else {
					$(load_output).text('Something went wrong.');
				}

				$button.html('<i class="fas fa-pencil-alt"></i>').prop('disabled', false);

			});

		});

		// AJAX saving fields
		$('.parentRow' ).on('click', '.btnSave', function(event) {

			var $button = $(this);

			$button.width($button.width()).text('...').prop( 'disabled',true);

			var post_id = $button.data('post_id');
			var success_output = '.msg-success' + post_id;

			// Fields to save
			var field_reviewer = '.reviewer' + post_id;
			var field_ico_status = '.ico-status' + post_id;

			// AJAX variables
			var data = {
				'action' : 'save_fields',
				'post_id' : $button.data('post_id'),
				'nonce' : $button.data('nonce'),
				'reviewer' : $(field_reviewer).val(),
				'ico_status' : $(field_ico_status).val(),
			};

			var load_output = '.load_output' + post_id;

			// Processing AJAX
			$.post(settings.ajaxurl, data, function(response) {

				if (response.success == true) {    	
					$(load_output).html(response.data);
				} else {
					$(load_output).text('Something went wrong.');
				}

				$button.html('<i class="fas fa-save"></i>').prop('disabled', false);

			});

		});

	});

}) (jQuery);
