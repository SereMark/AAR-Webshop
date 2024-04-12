$(document).ready(function() {
    if (!$.data(this, 'handler_attached')) {
        $('.ajax-form').submit(function(e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var errorContainer = form.find('.error');

            $.ajax({
                type: method,
                url: url,
                data: form.serialize(),
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        errorContainer.text(data.error).show();
                    } else {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    errorContainer.text('Error processing request: ' + textStatus).show();
                }
            });
        }).data('handler_attached', true);
    }
});