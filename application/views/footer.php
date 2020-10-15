</div>
<div id="video-call-modal" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="user-to-call-title-name"></span></h5>
            </div>
            <div class="modal-body" style="text-align: center">
                <div class="oto-video-call-div">
                    <video class="myVideoTagOTOLounge" id="myVideoTagOTOLounge" autoplay muted="muted"></video>
                    <video class="theirVideoTagOTOLounge" id="theirVideoTagOTOLounge" autoplay></video>
                </div>
            </div>
            <div class="modal-footer text-center">
                <div class="hang-up-btn" style="display: inline;">
                    <i class="fa fa-times-circle fa-3x leave-btn-icon" aria-hidden="true" style="color:#e3491b;"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: WRAPPER -->
<!-- GO TOP BUTTON -->
<a class="gototop gototop-button" href="#"><i class="fa fa-chevron-up"></i></a>

<!-- Theme Base, Components and Settings -->
<script src="<?= base_url() ?>front_assets/js/theme-functions.js"></script>

<!-- Custom js file -->
<script src="<?= base_url() ?>front_assets/js/custom.js"></script>
<script src="<?= base_url() ?>assets/alertify/alertify.min.js" type="text/javascript"></script>

<script src="https://blueimp.github.io/JavaScript-MD5/js/md5.js"></script>

<script src="https://meet.yourconference.live/socket.io/socket.io.js"></script>


<script>

    var socketServer = "<?=getSocketUrl()?>";
    let socket = io(socketServer);

    var user_name = "<?= $this->session->userdata('fullname') ?>";
    var user_id = <?= $this->session->userdata("cid") ?>;
    var base_url = "<?=base_url()?>";
    var user_name = "<?= $this->session->userdata('fullname') ?>";
    var user_type = "attendee";
    var user_logo = "";
    user_name = (user_name == '')?'No Name':user_name;
    var nameAcronym = user_name.match(/\b(\w)/g).join('');
    var color = md5(nameAcronym+user_id).slice(0, 6);
    var user_logo_url = (user_logo == '')?"https://placehold.it/50/"+color+"/fff&amp;text="+nameAcronym:base_url+'uploads/customer_profile/'+user_logo;

    function extract(variable) {
        for (var key in variable) {
            window[key] = variable[key];
        }
    }

    $.get("<?=base_url()?>socket_config.php", function (data) {
        var config = JSON.parse(data);
        extract(config);

        $.getScript( "<?= base_url() ?>assets/lounge/one-to-one/one-to-one.js?v=<?= rand(1, 100) ?>", function( data, textStatus, jqxhr )
        {
        });
    });

    function fillUnreadMessages() {
        $('.unread-msg-count').html('0');
        $('.unread-msgs-list').html('');
        $.get("<?= base_url() ?>user/UnreadMessages/getUnreadMessages", function (messages) {
            messages = JSON.parse(messages);
            var count = Object.keys(messages).length;
            if (count > 0) {
                $('.badge-notify').css('background', '#f11');
            }
            else {
                $('.badge-notify').css('background', '#727272');
            }
            $('.unread-msg-count').html(count);

            $.each(messages, function (number, message) {
                if (message.from_room_type == 'sponsor'){
                    $('.unread-msgs-list').append('' +
                        '<a target="_blank" class="dropdown-item waves-effect waves-light m-b-20" href="<?= base_url() ?>sponsor/view/' + message.sponsor_id + '"><i class="fa fa-commenting-o" aria-hidden="true"></i><strong>New message from ' + message.company_name + '</strong></a>');
                    //$('.unread-msgs-list').append('' +
                    //    '<a target="_blank" class="dropdown-item waves-effect waves-light" href="<?//= base_url() ?>//sponsor/view/' + message.sponsor_id + '"><strong>New message from ' + message.company_name + '</strong></a>' +
                    //    '<a href="<?//= base_url() ?>//sponsor/view/' + message.sponsor_id + '" target="_blank">' + message.text + '</a>');
                }else{
                    $('.unread-msgs-list').append('' +
                        '<a target="_blank" class="dropdown-item waves-effect waves-light m-b-20"><i class="fa fa-commenting-o" aria-hidden="true"></i><strong>New message from ' + message.from_name + '</strong></a>');
                }


            });
        });
    }

    var user_id = <?= $this->session->userdata("cid") ?>;
    var user_name = "<?= $this->session->userdata('fullname') ?>";


    $(function () {

        fillUnreadMessages();

        // var $unreadMsgCount=$(".unread-msg-count");
        socket.on('unreadMessage', function (data) {
            if(data.chat_to == user_id)
                fillUnreadMessages();
            /** Why did you do this Hayreddin? you could just call the fillUnreadMessages function **/
            // if($(".chat-users-list").length<=0){
            //     data["clicked"]=false;
            //     localStorage.setItem("unreadMessage", JSON.stringify(data));
            //     $unreadMsgCount.html("1");
            // }

        });


        //$(".badge-notify").click(function () {
        //    var data=localStorage.getItem("unreadMessage");
        //    if(data){
        //        data=JSON.parse(data);
        //        data["clicked"]=true;
        //        localStorage.setItem("unreadMessage", JSON.stringify(data));
        //        window.location.href="<?//=base_url()?>//lounge";
        //    }
        //})
        //
        //var unreadMessage=localStorage.getItem("unreadMessage");
        //if(unreadMessage){
        //    unreadMessage=JSON.parse(unreadMessage);
        //
        //    if(unreadMessage["clicked"]!=true){
        //        $unreadMsgCount.html("1");
        //    }
        //}






        socket.on('serverStatus', function (data) {
            socket.emit('addMeToActiveListPerApp', {'user_id': user_id, 'app': socket_app_name, 'room': socket_active_user_list});

            setTimeout(function () {
                socket.emit('getActiveUserListPerApp', socket_app_name);
            }, 5000); // Wait 5 seconds and request for new list of active users
        });

        // Active again
        function resetActive() {
            socket.emit('userActiveChangeInApp', {"app": socket_app_name, "room": socket_active_user_list, "name": user_name, "userId": user_id, "status": true});
        }

        // No activity let everyone know
        function inActive() {
            socket.emit('userActiveChangeInApp', {"app": socket_app_name, "room": socket_active_user_list, "name": user_name, "userId": user_id, "status": false});
        }

        $(window).on("blur focus", function (e) {
            var prevType = $(this).data("prevType");

            if (prevType != e.type) {   //  reduce double fire issues
                switch (e.type) {
                    case "blur":
                        inActive();
                        break;
                    case "focus":
                        resetActive();
                        break;
                }
            }

            $(this).data("prevType", e.type);
        });
    });
</script>


</body>
</html>
