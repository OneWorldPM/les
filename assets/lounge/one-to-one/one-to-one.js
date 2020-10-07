$(function() {

    $('.lounge-video-call-btn').on('click', function () {

        var userToCall = $(this).attr('user-id');
        var userToCallActiveStatus = $('.attendees-chat-list > .attendees-chat-list-item[userid="'+userToCall+'"]').attr('status');

        if (userToCallActiveStatus == 'offline')
        {
            Swal.fire(
                'Problem!',
                'User you are trying to call is offline!',
                'error'
            );
            return;
        }

        toastr["warning"]("Network unavailable, please try after a while!");
    });
});
