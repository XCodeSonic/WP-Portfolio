jQuery(document).ready(function($) {

    $(document).on('click', '.notice-theme-info-class .notice-dismiss', function() {

        var notice = $(this).closest('.notice-theme-info-class');

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'pixel_personal_portfolio_dismiss_notice'
            },
            success: function(response) {
                if (response.success) {
                    notice.fadeOut();
                }
            }
        });

    });

});