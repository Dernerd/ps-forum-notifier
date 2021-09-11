jQuery(document).ready(function($) {
    $('#ps-forum-notifier-toggle-subscription').live('click', function(e) {
        e.preventDefault();
        var subscribe_or_unsubscribe = $(this).data('action');
        var nonce = $(this).data('nonce');
        var group_id = $(this).data('group_id');

        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action: 'ps_forum_notifier_toggle_subscription',
                nonce: nonce,
                group_id: group_id,
                subscribe_or_unsubscribe: subscribe_or_unsubscribe,
            },
            success: function(response) {
                if (response[0] != '-') {
                    $('#ps-forum-notifier-wrapper').html(response);
                }
            }
        }, "JSON");
    });

    // since this plugin handles the mailsubscriptions, lets remove the checkbox from the form.
    $('#psf_topic_subscription').remove();
    $("label[for='psf_topic_subscription']").remove();

});