
jQuery(document).ready(function() {
	
    /*
        Background slideshow
    */
    $('.c-form-container').backstretch("assets/img/backgrounds/bg.jpg");
    
    /*
        Wow
    */
    new WOW().init();
    
    /*
	    Contact form
	    We can do it OOP but we don't need to complicate for this purpose
	*/
	$('.c-form-box form').submit(function(e) {
		e.preventDefault();
		resetForm();

		var nameError = $('.c-form-box form label[for="c-form-name"] .contact-error');
		var emailError = $('.c-form-box form label[for="c-form-email"] .contact-error');
		var subjectError = $('.c-form-box form label[for="c-form-subject"] .contact-error');
		var msgError = $('.c-form-box form label[for="c-form-message"] .contact-error');

		var emailField = $('.c-form-box form .c-form-email').val();

		var error = false;
		if ($('.c-form-box form .c-form-name').val() == '') {
			nameError.html('The field is required').fadeIn('fast');
			error = true;
		}

        if (emailField == '') {
            emailError.html('The field is required').fadeIn('fast');
            error = true;
        } else {
		    if (!validateEmail(emailField)) {
                emailError.html('Email address is not valid').fadeIn('fast');
                error = true;
            }
        }

        if ($('.c-form-box form .c-form-subject').val() == '') {
            subjectError.html('The field is required').fadeIn('fast');
            error = true;
        }

        if ($('.c-form-box form .c-form-message').val() == '') {
            msgError.html('The field is required').fadeIn('fast');
            error = true;
        }

        // Do POST if there are no validation errors
        if (!error) {
            var this_form_parent = $(this).parents('.c-form-box');
            var postdata = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '/send',
                data: postdata,
                dataType: 'json',
                success: function(res) {
                    if(res.status == 1) {
                        this_form_parent.find('.c-form-top').fadeOut('fast');
                        this_form_parent.find('.c-form-bottom').fadeOut('fast', function() {
                            this_form_parent.append('<p>Thanks for contacting us! We will get back to you very soon.</p>' +
                                '<p><a href="/">Send another one.</a> </p>');
                            // reload background
                            $('.c-form-container').backstretch("resize");
                        });
                    } else {
                        // If there's some issue with the validation on backend display the errors
                        // Loop through the errors array and append inside html error divs
                    }
                }
            });
		}
	});
	
    function resetForm() {
        $('.c-form-box form label[for="c-form-name"] .contact-error').html('');
        $('.c-form-box form label[for="c-form-email"] .contact-error').html('');
        $('.c-form-box form label[for="c-form-subject"] .contact-error').html('');
        $('.c-form-box form label[for="c-form-message"] .contact-error').html('');
    }
    
    function validateEmail(email) {
        var re = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
        return re.test(email);
    }
});
