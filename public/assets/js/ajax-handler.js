// Wait for the document to be ready
$(document).ready(function() {
    // Check if the handler is already attached
    if (!$.data(this, 'handler_attached')) {
        // Attach a submit event handler to all elements with the class 'ajax-form'
        $('.ajax-form').submit(function(e) {
            // Prevent the default form submission
            e.preventDefault();

            // Get the form, its action URL, method, and the error container
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var errorContainer = form.find('.error');

            // Make an AJAX request
            $.ajax({
                type: method, // The HTTP method to use for the request
                url: url, // The URL to which the request is sent
                data: form.serialize(), // The data to send to the server
                dataType: 'json', // The type of data expected from the server
                success: function(data) {
                    // If there's an error, display it in the error container
                    if (data.error) {
                        errorContainer.text(data.error).show();
                    } else {
                        // If there's a redirect, navigate to the new URL
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // If there's an error with the request, display it in the error container
                    errorContainer.text('Error processing request: ' + textStatus).show();
                }
            });
        }).data('handler_attached', true); // Mark the handler as attached
    }
});