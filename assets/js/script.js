var stickyId = document.querySelector("header.site-header");
window.onscroll = function () {
    window.pageYOffset > 180 ? stickyId.classList.add("sticky") : stickyId.classList.remove("sticky");
}


// Contact Form JS 

jQuery(document).ready(function ($) {
    $('.mrifat-form').on('submit', function (e) {
        e.preventDefault();

        var form = $(this);
        var submitBtn = form.find('.mrifat-submit-button');
        var buttonText = submitBtn.find('.mrifat-button-text');
        var loadingText = submitBtn.find('.mrifat-button-loading');
        var messageDiv = form.find('.mrifat-form-message');

        // Disable submit button
        submitBtn.prop('disabled', true);
        buttonText.hide();
        loadingText.show();
        messageDiv.html('').removeClass('mrifat-error mrifat-success').hide();

        // Get form data
        var formData = new FormData(this);
        // The nonce is now part of the form data, so we don't need to append it separately.

        $.ajax({
            url: mrifat_contact_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    // Show success message and hide form
                    form.html('<div class="mrifat-success-message"><h3>Thank You!</h3><p>' + response.data + '</p></div>');
                } else {
                    // Show error message
                    showMessage(response.data, 'error', messageDiv);

                    // Re-enable submit button
                    submitBtn.prop('disabled', false);
                    buttonText.show();
                    loadingText.hide();

                    // Reset reCAPTCHA if enabled
                    if (typeof grecaptcha !== 'undefined' && form.find('.g-recaptcha').length) {
                        grecaptcha.reset();
                    }
                }
            },
            error: function () {
                showMessage('Something went wrong. Please try again.', 'error', messageDiv);

                // Re-enable submit button
                submitBtn.prop('disabled', false);
                buttonText.show();
                loadingText.hide();

                // Reset reCAPTCHA if enabled
                 if (typeof grecaptcha !== 'undefined' && form.find('.g-recaptcha').length) {
                    grecaptcha.reset();
                }
            }
        });
    });

    function showMessage(message, type, messageDiv) {
        messageDiv.html(message).addClass('mrifat-' + type).fadeIn();

        // Auto-hide after 5 seconds
        setTimeout(function () {
            messageDiv.fadeOut();
        }, 5000);
    }
});




/**
 * Progressive Image Loading
 */
(function ($) {
    'use strict';

    // Progressive image loading
    function loadProgressiveImages() {
        $('.progressive-image.loading').each(function () {
            const img = $(this);
            const src = img.data('src');

            if (src) {
                // Create a new image object
                const newImg = new Image();
                newImg.src = src;

                // When the image is loaded
                newImg.onload = function () {
                    // Remove the loading class
                    img.removeClass('loading').addClass('loaded');
                };
            }
        });
    }

    // Run on document ready
    $(document).ready(function () {
        loadProgressiveImages();

        // Handle mobile menu toggle
        $('.mobile-menu-button').on('click', function () {
            $('.mobile-menu').slideToggle();
        });
    });

    // Run when new content is loaded via AJAX
    $(document).on('ajaxComplete', function () {
        loadProgressiveImages();
    });

})(jQuery);

// Project Filter JS 

