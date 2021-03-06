
$(function()
{
    $('#installForm').on('submit', function(event)
    {
        event.preventDefault();

        var loadingDialog = bootbox.dialog(
        {
            message: '<div class="text-center"><i class="icon icon-spinner-indicator icon-spin"></i>&nbsp;&nbsp;' + instanceNotices.installing + '</div>',
        });

        $.post($('#installForm').attr('action'), $('#installForm').serializeArray()).done(function(response)
        {
            loadingDialog.modal('hide');

            let res = JSON.parse(response);
            if(res.result == 'success')
            {
                config.onlybody = 'no';
                window.parent.$.apps.open(createLink('space', 'browse'), 'space');
            }
            else
            {
                alert(res.message);
            }
        });
    });
});
