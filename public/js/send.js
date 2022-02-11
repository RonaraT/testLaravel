$(document).ready(function () {
    $('#contactform').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/sendmail',
            data: $('#contactform').serialize()
		}).done(function (data) {
            if (data == 200) {
                $('#senderror').hide();
                $('#sendmessage').show();
            } else {
                $('#senderror').show();
                $('#sendmessage').hide();
            }
            
        });
    });
});