var videoCallEngaged = false;
var myVideoArea = document.querySelector("#myVideoTagOTOLounge");
var theirVideoArea = document.querySelector("#theirVideoTagOTOLounge");
var rtcPeerConn;
var nameOtherEnd;
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

$(function() {

    socket.emit('joinLoungeOtoVideo', {"room":socket_lounge_oto_video, "name":user_name, "userId":user_id, "userType":user_type});

    socket.on('incoming-call', function (fromId, fromName, to) {
        if (to == user_id)
        {
            if (videoCallEngaged == false)
            {
                Swal.fire({
                    title: 'Incoming Call',
                    text: fromName+' is calling...',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#15b015',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Accept',
                    cancelButtonText: 'Reject'
                }).then((result) => {
                    if (result.isConfirmed) {
                        videoCallEngaged = true;

                        // get a local stream, show it in our video tag and add it to be sent
                        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                        navigator.getUserMedia({
                            'audio': true,
                            'video': true
                        }, function (stream) {

                            myVideoArea.srcObject = stream;

                            $('.user-to-call-title-name').text('Connecting '+fromName+'...');

                            //Send a first signaling message to anyone listening
                            //This normally would be on a button click
                            socket.emit('joinPersonalVideoRoom', socket_lounge_oto_video+'_'+fromId);
                            socket.emit('signal',{"type":"user_here", "message":"Are you ready for a call?", "room":socket_lounge_oto_video+'_'+fromId});

                            nameOtherEnd = fromName;

                            $('#video-call-modal').modal('show');

                        }, logOTOVideoCallError);

                    }else{
                        Swal.fire(
                            'Done!',
                            'Call Rejected!',
                            'error'
                        )
                    }
                })
            }else{

            }
        }
    });

    socket.on('signaling_message', function(data) {
        displaySignalMessage("Signal received: " + data.type);

        //Setup the RTC Peer Connection object
        if (!rtcPeerConn)
            startSignaling();

        if (data.type != "user_here") {
            var message = JSON.parse(data.message);
            if (message.sdp) {
                rtcPeerConn.setRemoteDescription(new RTCSessionDescription(message.sdp), function () {
                    // if we received an offer, we need to answer
                    if (rtcPeerConn.remoteDescription.type == 'offer') {
                        rtcPeerConn.createAnswer(sendLocalDesc, logOTOVideoCallError);
                    }
                }, logOTOVideoCallError);
            } else {
                rtcPeerConn.addIceCandidate(new RTCIceCandidate(message.candidate));
            }
        }
    });

    $('.lounge-video-call-btn').on('click', function () {

        var userToCall = $(this).attr('user-id');
        var userName = $(this).attr('user-name');
        var userToCallActiveStatus = $('.attendees-chat-list > .attendees-chat-list-item[userid="'+userToCall+'"]').attr('status');

        nameOtherEnd = userName;

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
                userName+' is offline!',
                'error'
            );
            return;
        }

        $('.user-to-call-title-name').text('Calling '+userName+'...');

        // get a local stream, show it in our video tag and add it to be sent
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
        navigator.getUserMedia({
            'audio': true,
            'video': true
        }, function (stream) {

            myVideoArea.srcObject = stream;

            //Send a first signaling message to anyone listening
            //This normally would be on a button click
            socket.emit('joinPersonalVideoRoom', socket_lounge_oto_video+'_'+user_id);
            socket.emit('signal',{"type":"user_here", "message":"Are you ready for a call?", "room":socket_lounge_oto_video+'_'+user_id});
            socket.emit('ring', socket_app_name, socket_lounge_oto_video, user_id, user_name, userToCall);

            $('#video-call-modal').modal('show');

        }, logOTOVideoCallError);
    });

    $('.hang-up-btn').on('click', function () {
        location.reload();
    });
});


function logOTOVideoCallError(error) {
    console.log(error.name + ': ' + error.message);
}

function startSignaling() {
    displaySignalMessage("starting signaling...");

    rtcPeerConn = new RTCPeerConnection(configuration);

    // send any ice candidates to the other peer
    rtcPeerConn.onicecandidate = function (evt) {
        if (evt.candidate)
            socket.emit('signal',{"type":"ice candidate", "message": JSON.stringify({ 'candidate': evt.candidate }), "room":SIGNAL_ROOM});
        displaySignalMessage("completed that ice candidate...");
    };

    // let the 'negotiationneeded' event trigger offer generation
    rtcPeerConn.onnegotiationneeded = function () {
        displaySignalMessage("on negotiation called");
        rtcPeerConn.createOffer(sendLocalDesc, logOTOVideoCallError);
    }

    // get a local stream, show it in our video tag and add it to be sent
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
    navigator.getUserMedia({
        'audio': true,
        'video': true
    }, function (stream) {
        displaySignalMessage("going to display my stream...");
        rtcPeerConn.addStream(stream);
    }, logOTOVideoCallError);

    // once remote stream arrives, show it in the remote video element
    rtcPeerConn.ontrack = function (evt) {
        displaySignalMessage("going to add their stream...");
        theirVideoArea.srcObject = evt.streams[0];

        $('.myVideoTagOTOLounge').addClass('otherUserPickedUp');

        $('.user-to-call-title-name').text(nameOtherEnd);

        // if(evt.track.kind == 'video')
        // {
        //     var resolution = screen.width + "x " + screen.height + "y";
        //     $.post("/tiadaannualconference/sponsor/add_viewsessions_history_open",
        //         {
        //             sponsor_id: sponsor_id,
        //             resolution: resolution,
        //             action: 'vcall started',
        //         });
        // }
    };

    rtcPeerConn.oniceconnectionstatechange = function() {
        if(rtcPeerConn.iceConnectionState == 'disconnected') {
            //Releasing previous connections on reload!
            // $.post("/tiadaannualconference/sponsor-admin/VideoChatApi/releaseSponsor",
            //     {
            //         roomId: SIGNAL_ROOM,
            //         sponsorId: sponsor_id
            //     });

            $('#videoCallModal').modal('hide');
            Swal.fire(
                'TIADA left the video chat!',
                'if this was a connection problem, please try again!',
                'warning'
            ).then(function () {
                location.reload();
            });
            location.reload();

            // myVideoArea.srcObject.getVideoTracks().forEach(track => {
            //     track.stop();
            //     myVideoArea.srcObject.removeTrack(track);
            // });
            //
            // theirVideoArea.srcObject.getVideoTracks().forEach(track => {
            //     track.stop();
            //     theirVideoArea.srcObject.removeTrack(track);
            // });
            //
            // rtcPeerConn.close();
        }
    }

}

function sendLocalDesc(desc) {
    rtcPeerConn.setLocalDescription(desc, function () {
        displaySignalMessage("sending local description");
        socket.emit('signal',{"type":"SDP", "message": JSON.stringify({ 'sdp': rtcPeerConn.localDescription }), "room":SIGNAL_ROOM});
    }, logOTOVideoCallError);
}

function displaySignalMessage(message) {
    console.log(message);
}
