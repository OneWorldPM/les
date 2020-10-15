$(function() {
    var firstUrl=$("body").data("base-url");

    var socketServer = "https://socket.yourconference.live:443";
    // var socketServer = "https://127.0.0.1:3080";

    let socket = io(socketServer);
    socket.on('serverStatus', function(data) {
        //console.log(data);
    });



    $('.support-chat').on('click', function () {

        $.get(firstUrl+"/home/getSupportChatStatus", function (status) {

            if (status == 0)
            {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sorry!',
                    text: 'Live Chat is now turned off and  available during show hours only; if this is an emergency, please call (512) 244-6060'
                });
            }else{
                socket.emit('support-chat-request', {'id': user_id, 'name': user_name});
            }
        });

        socket.on('contacting-support', function() {
            $.get( firstUrl+"/user/SupportChat/getAllChats/"+user_id, function(chats) {

                var connecting_msg = 'Please wait while we connect you with one of our support agents.  Closing this box will cancel your support request.';

                chats = JSON.parse(chats);

                $('.support-chat-list').html('');

                $.each( chats, function( number, chat ) {

                    if (chat.message_from == 'admin')
                    {
                        $('.support-chat-list').append('' +
                            '<li class="support-chat-item admin clearfix">\n' +
                            '<span class="support-chat-name pull-right m-l-5">Admin</span>' +
                            '<p style="display: inline-block">'+chat.message+'</p>\n' +
                            '</li>');
                    }else{
                        $('.support-chat-list').append('' +
                            '<li class="support-chat-item left clearfix">\n' +
                            '  <span class="support-chat-name">'+chat.attendee_name+'</span> '+chat.message+'\n' +
                            '</li>');
                    }
                });

                $('.support-chat-list').append('' +
                    '<li class="support-chat-item admin clearfix">\n' +
                    '<span class="support-chat-name pull-right">Admin</span>' +
                    '<p style="display: inline-block;color: red;font-style: italic;">'+connecting_msg+'</p>\n' +
                    '</li>');

                $('.support-chat-body').scrollTop($('.support-chat-body')[0].scrollHeight);

                openForm();
            });
        });

        socket.on('support-chat-busy', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Sorry!',
                text: 'All support chat rooms are busy at the moment, please try again shortly!'
            });
        });
    });

    socket.on('newSupportText', function(data) {
        var attendee_id=data.attendee_id;
        console.log("geldi");
        console.log(data);
        if (data.message_from == 'admin')
        {
            $('.support-chat-list_'+attendee_id).append('' +
                '<li class="support-chat-item admin clearfix">\n' +
                '<span class="support-chat-name pull-right">Admin</span>' +
                '<p style="display: inline-block">'+connecting_msg+'</p>\n' +
                '</li>');
        }else{
            $('.support-chat-list_'+attendee_id).append('' +
                '<li class="support-chat-item left clearfix">\n' +
                '  <span class="support-chat-name">'+data.attendee_name+'</span> '+data.message+'\n' +
                '</li>');
        }

        $('.support-chat-body').scrollTop($('.support-chat-body')[0].scrollHeight);
    });

    $('#close-support-request').on('click', function () {
        socket.emit('close-support-request');
        closeForm();
    });



    $('.support-chat-message').on("keypress", function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#send-support-message-btn').click();
        }
    });

    $('#send-support-message-btn').on('click', function () {
        var message = $('.support-chat-message').val();

        if (message == ''){
            return;
        }

        $.post(firstUrl+"/user/SupportChat/sendMessage",

            {
                'message': message,
                'attendee_id': user_id,
                'message_from': user_id
            },
            function(data, status){
                if(status == 'success')
                {
                    var dataFromDb = JSON.parse(data);

                    $('.support-chat-message').val('');

                    socket.emit('newSupportText',
                        {
                            'message': dataFromDb.message,
                            'attendee_id': dataFromDb.attendee_id,
                            'attendee_name': dataFromDb.user_name,
                            'message_from': dataFromDb.message_from,
                            "datetime":dataFromDb.datetime
                        });

                }else{
                    toastr["error"]("Network problem!");
                }
            });
    });

    socket.on('admin-closed-support-chat', function() {
        console.log('Admin closed chat!');
    });

    socket.on('already-chatting', function() {
        Swal.fire({
            icon: 'error',
            title: 'One place at a time!',
            text: 'You are already chatting from another tab or browser, please either close that tab or continue chatting there!'
        });
    });



});

function openForm() {

    document.getElementById("supportChat").style.display = "block";
}

function closeForm() {
    document.getElementById("supportChat").style.display = "none";
}
