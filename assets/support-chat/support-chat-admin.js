// var firstUrl="/tiadaannualconference";
var firstUrl = "";


// var socketServer = "https://socket.yourconference.live:443";
var socketServer = "https://127.0.0.1:3080";


let socket = io(socketServer);
socket.on('serverStatus', function (data) {
    //console.log(data);
});


function addChat(data,type) {
    var attendee_id="";
    var attendee_name="";

    if(type=="first_click"){
        attendee_id=data.attendee.id;
        attendee_name=data.attendee.name;
    }else{
        attendee_id=data.attendee_id;
        attendee_name=data.attendee_name;
    }

    console.log("geldi23");
    console.log(attendee_id);
    $('.support-chat-boxes').prepend('' +
        '<div class="chat-popup" id="chat_box_' + attendee_id + '">\n' +
        '        <form action="#" class="form-container">\n' +
        '            <h3>Support Chat</h3>\n' +
        '\n' +
        '            <label for="msg"><b class="person-name">' + attendee_name + '</b></label>\n' +
        '            <div class="support-chat-body">\n' +
        '                <ul class="support-chat-list support-chat-list_' + attendee_id + '">\n' +
        '\n' +
        '                </ul>\n' +
        '            </div>\n' +
        '\n' +
        '            <input type="text" class="form-control support-chat-message_' + attendee_id + '" placeholder="Enter your message here...">\n' +
        '            <button attendee_id="' + attendee_id + '" attendee_name="' + attendee_name + '" type="button" class="btn chat_send_btn">Send</button>\n' +
        '            <button attendee_id="' + attendee_id + '" attendee_name="' + attendee_name + '" socket="' + data.socket + '" type="button" class="btn cancel chat_close_btn" >Close</button>\n' +
        '        </form>\n' +
        '    </div>');

    $.get(firstUrl + "/user/SupportChat/getAllChats/" + attendee_id, function (chats) {

        chats = JSON.parse(chats);

        $('.support-chat-list_' + attendee_id).html('');

        $.each(chats, function (number, chat) {

            if (chat.message_from == 'admin') {
                $('.support-chat-list_' + attendee_id).append('' +
                    '<li class="support-chat-item admin clearfix">\n' +
                    '  ' + chat.message + ' <span class="support-chat-name">Admin</span>\n' +
                    '</li>');
            }
            else {
                $('.support-chat-list_' + attendee_id).append('' +
                    '<li class="support-chat-item left clearfix">\n' +
                    '  <span class="support-chat-name">' + chat.attendee_name + '</span> ' + chat.message + '\n' +
                    '</li>');
            }
        });

        setTimeout(function () {
            $('.support-chat-body').scrollTop($('.support-chat-body')[0].scrollHeight);
        })
        $('#chat_box_' + attendee_id).css('display', 'inline-block');
    });
}

socket.on('new-support-chat-request', function (data) {
    console.log("yeni_chat");
    if ($("#chat_box_" + data.id).length<=0) {
        addChat(data,"first_click")
    }
});

socket.on('newSupportText', function (data) {
    console.log("mesaj geldi");
    console.log()
    if (data.message_from == 'admin') {
        $('.support-chat-list_' + data.attendee_id).append('' +
            '<li class="support-chat-item admin clearfix">\n' +
            '  ' + data.message + ' <span class="support-chat-name">Admin</span>\n' +
            '</li>');
    }
    else {
        console.log(data);
        if ($("#chat_box_" + data.attendee_id).length<=0) {
            console.log("yok chat");
            addChat(data,"no_chat")
        }else{
            $('.support-chat-list_' + data.attendee_id).append('' +
                '<li class="support-chat-item left clearfix">\n' +
                '  <span class="support-chat-name">' + data.attendee_name + '</span> ' + data.message + '\n' +
                '</li>');
            $('#chat_box_' + data.attendee_id).css('display', 'inline-block');
        }

    }


    setTimeout(function () {
        $('.support-chat-body').scrollTop( $('.support-chat-body .support-chat-list').height()+100)

   })
});

socket.on('support-chat-closed', function (attendee) {
    $('#chat_box_' + attendee).css('display', 'none');
});

$('body').on('click', 'button.chat_close_btn', function () {
    var attendee_id = $(this).attr('attendee_id');
    var socketId = $(this).attr('socket');

    socket.emit('admin-closed-support-chat', {'attendee_id': attendee_id, 'socket': socketId});
    $(this).parent().parent().remove();
});

$('body').on('click', 'button.chat_send_btn', function () {
    var attendee_id = $(this).attr('attendee_id');
    var attendee_name = $(this).attr('attendee_name');

    var message = $('.support-chat-message_' + attendee_id).val();

    if (message == '') {
        return;
    }

    $.post(firstUrl + "/user/SupportChat/sendMessage",
        {
            'message': message,
            'attendee_id': attendee_id,
            'message_from': 'admin'
        },
        function (data, status) {
            if (status == 'success') {
                var dataFromDb = JSON.parse(data);

                $('.support-chat-message_' + attendee_id).val('');

                socket.emit('newSupportText',
                    {
                        'message': dataFromDb.message,
                        'attendee_id': dataFromDb.attendee_id,
                        'attendee_name': attendee_name,
                        'message_from': dataFromDb.message_from,
                        "datetime": dataFromDb.datetime
                    });

            }
            else {
                toastr["error"]("Network problem!");
            }
        });
});
