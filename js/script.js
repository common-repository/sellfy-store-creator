jQuery(document).ready(function ($) {
    $('#sellfy_create_page').on('submit', function () {
        var data = $(this).serialize(),
            _this = this,
            error = $('#sellfy_store_error_message');
        error.fadeOut();
        $.post(ajaxurl, data, function (response) {
            if (response && response.success) {
                error.removeClass('error updated created')
                    .addClass('updated')
                    .fadeIn()
                    .find('a').attr('href', response.page_url);
                $(_this).find('#submit_holder').removeClass().addClass('update-page');
                if (response.is_new) {
                    error.addClass('created');
                }
                ga('send', 'event', 'Wordpress', 'Create store', response.page_url);
            }
            else {
                error.removeClass('updated')
                     .addClass('error')
                     .show()
                     .children('.error-text')
                     .text(response.error);
            }
        });
        return false;
    });
    $('#sellfy_delete_page').on('click', function () {
        var confirmed = confirm('Are you really want to remove your Sellfy store page?');
        if (confirmed) {
            var data = {
                action: 'sellfy_delete_store',
                security: $('#sellfy_security').val()
            };
            $.post(ajaxurl, data, function (response) {
                if (response && response.success) {
                    document.location.reload(true);
                }
                else {
                    alert('Unfortunately, I can\'t find the store page. The page now would be reloaded');
                    document.location.reload(true);
                }
            });
        }
    });
});
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-48368790-1', 'auto', {'allowLinker': true});

