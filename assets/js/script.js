var stickyId = document.querySelector("header.site-header");
window.onscroll = function () {
    window.pageYOffset > 180 ? stickyId.classList.add("sticky") : stickyId.classList.remove("sticky");
}


// Contact Form JS 

jQuery(document).ready(function ($) {
    $('#mrifat-contact-form').on('submit', function (e) {
        e.preventDefault();

        var form = $(this);
        var submitBtn = form.find('.mrifat-submit-button');
        var buttonText = submitBtn.find('.mrifat-button-text');
        var loadingText = submitBtn.find('.mrifat-button-loading');

        // Disable submit button
        submitBtn.prop('disabled', true);
        buttonText.hide();
        loadingText.show();

        // Get form data
        var formData = new FormData(this);
        formData.append('action', 'mrifat_submit_contact');
        formData.append('nonce', mrifat_contact_ajax.nonce);

        $.ajax({
            url: mrifat_contact_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    // Show success message
                    form.html('<div class="mrifat-success-message"><h3>Thank You!</h3><p>' + response.data + '</p></div>');
                } else {
                    // Show error message
                    showMessage(response.data, 'error');

                    // Re-enable submit button
                    submitBtn.prop('disabled', false);
                    buttonText.show();
                    loadingText.hide();

                    // Reset reCAPTCHA if enabled
                    if (typeof grecaptcha !== 'undefined') {
                        grecaptcha.reset();
                    }
                }
            },
            error: function () {
                showMessage('Something went wrong. Please try again.', 'error');

                // Re-enable submit button
                submitBtn.prop('disabled', false);
                buttonText.show();
                loadingText.hide();

                // Reset reCAPTCHA if enabled
                if (typeof grecaptcha !== 'undefined') {
                    grecaptcha.reset();
                }
            }
        });
    });

    function showMessage(message, type) {
        var messageDiv = '<div class="mrifat-form-message mrifat-' + type + '">' + message + '</div>';

        // Remove existing messages
        $('.mrifat-form-message').remove();

        // Add new message
        $('#mrifat-contact-form').prepend(messageDiv);

        // Auto-hide after 5 seconds
        setTimeout(function () {
            $('.mrifat-form-message').fadeOut();
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

