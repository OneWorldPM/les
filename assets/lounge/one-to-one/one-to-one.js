$(function() {

    var myVideoArea = document.querySelector("#myVideoTagOTOLounge");
    var theirVideoArea = document.querySelector("#theirVideoTagOTOLounge");

    var SIGNAL_ROOM = socket_lounge_oto_video;
    var configuration = {
        'iceServers': [
            { 'urls': 'stun:stun.l.google.com:19302' },
            { 'urls': 'stun:stun1.l.google.com:19302' },
            {
                url: 'turn:numb.viagenie.ca',
                credential: 'muazkh',
                username: 'webrtc@live.com'
            },
            {
                url: 'turn:192.158.29.39:3478?transport=udp',
                credential: 'JZEOEt2V3Qb0y27GRntt2u2PAYA=',
                username: '28224511:1379330808'
            }
        ]
    };

    $('.lounge-video-call-btn').on('click', function () {

        var userToCall = $(this).attr('user-id');
        var userName = $(this).attr('user-name');
        var userToCallActiveStatus = $('.attendees-chat-list > .attendees-chat-list-item[userid="'+userToCall+'"]').attr('status');

        if (userToCall == user_id)
        {
            Swal.fire(
                'Problem!',
                "You can't call yourself!",
                'error'
            );
            return;
        }

        if (userToCallActiveStatus == 'offline')
        {
            Swal.fire(
                'Problem!',
                'User you are trying to call is offline!',
                'error'
            );
            return;
        }

        toastr['warning']('Network issue, please try after a while!');

        $('.user-to-call-title-name').text(userName);

        // get a local stream, show it in our video tag and add it to be sent
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
        navigator.getUserMedia({
            'audio': true,
            'video': true
        }, function (stream) {
            myVideoArea.srcObject = stream;
        }, logOTOVideoCallError);

        $('#video-call-modal').modal('show');
    });

    $('.hang-up-btn').on('click', function () {
        location.reload();
    });
});

function logOTOVideoCallError(error) {
    console.log(error.name + ': ' + error.message);
}
