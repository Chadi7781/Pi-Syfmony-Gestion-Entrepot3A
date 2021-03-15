// contact form
jQuery(document).ready(function($) {
		
$(document).find('form#btn_con_frm_one').submit(function(event) {
			

			$.post('contact.php',$(this).serialize(), function(data, textStatus, xhr) {
				
				
				$('#success-msg').html(data.msg);
                               $('#success-msg').show().delay(500).fadeOut(2500);
							   $('#btn_con_frm_one').trigger('reset');

			});

			return false;
		});

	
 
// subscribe form

		
$(document).find('form#btn_sub_frm_one').submit(function(event) {
			/* Act on the event */
			
			//var formData $(this).serialize();

			$.post('subscribe.php',$(this).serialize(), function(data, textStatus, xhr) {
				
				
				$('#success').html(data.msg);
                               $('#success').show().delay(500).fadeOut(2500);
							   $('#btn_sub_frm_one').trigger('reset');
							  

			});

			return false;
		});

	});	