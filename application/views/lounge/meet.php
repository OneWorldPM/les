<?php
if ($meeting_status['status'] == false)
{?>

    <main role="main" class="container" style="text-align: center;">

        <div class="starter-template">
<!--            <h1>Sorry!</h1>-->
            <p class="lead"><?=$meeting_status['message']?></p>
            <p>This page will reload itself once the meeting starts</p>
        </div>

    </main>

    <script>
        // Meeting timer
        var _second = 1000;
        var _minute = _second * 60;
        var _hour = _minute * 60;
        var _day = _hour * 24;
        var end = new Date('<?=$meeting->meeting_from?>');
        var end_et = new Date(end.toLocaleString('en-US', { timeZone: 'America/Chicago' }));
        function meetingTimer() {
            var now = new Date();
            var now_ct = new Date(now.toLocaleString('en-US', { timeZone: 'America/Chicago' }));
            now_ct.setHours(now_ct.getHours() + 1 );

            var distance = end - now_ct;
            console.log(now_ct);
            console.log(end);
            console.log(distance);
            if (distance < 0) {
                clearInterval(timer);
                location.reload();
                return;
            }
            var days = Math.floor(distance / _day);
            var hours = Math.floor((distance % _day) / _hour);
            var minutes = Math.floor((distance % _hour) / _minute);
            var seconds = Math.floor((distance % _minute) / _second);

            if (days <= 0){
                if (hours <= 0){
                    if (minutes <= 0){
                        $('.meeting_starts_in').html(seconds+' seconds');
                    }else{
                        $('.meeting_starts_in').html(minutes+' minutes '+seconds+' seconds');
                    }
                }else{
                    $('.meeting_starts_in').html(hours+' hours '+minutes+' minutes '+seconds+' seconds');
                }
            }else{
                $('.meeting_starts_in').html(days+' day(s) '+hours+' hours '+minutes+' minutes '+seconds+' seconds');
            }
        }
        var timer = setInterval(meetingTimer, 1000);
    </script>

<?php
}else{ ?>
<link href="<?= base_url() ?>assets/lounge/video-meet/video-meet.css?v=<?= rand(1, 100) ?>" rel="stylesheet">

    <main role="main" class="container" style="text-align: center;">

        <div class="starter-template">
            <h1><?= $meeting->topic ?></h1>
        </div>

        <div class="row m-t-20 camera-feeds">

            <div class="col-md-3 localvideo-div">
                <div class="videoCover" style="display: none;"></div>
                <span class="name-tag">You</span>
                <video id="localVideo" autoplay muted playsinline width="100%"></video>
                <!-- <div class="soundbar"><span class="currentVolume"></span></div> -->
            </div>
        </div>
        <div class="col-md-12 control-icons-col" style="display: none;">
            <div class="feed-control-icons" style="display: inline;">

                <div class="mute-mic-btn" style="display: inline;">
                    <i class="fa fa-microphone fa-3x mute-mic-btn-icon" aria-hidden="true" style="color:#12b81c;"></i>

                </div>

                <div class="cam-btn" style="display: inline;">
                    <i class="fa fa-video-camera fa-3x cam-btn-icon" aria-hidden="true" style="color:#12b81c;"></i>
                </div>

                <div class="share-screen-btn" style="display: inline;" onclick="window.open('<?=base_url()?>lounge/sharescreen/<?=$meeting->id?>', '_blank');">
                    <i class="fa fa-desktop fa-3x share-screen-btn-icon" aria-hidden="true" style="color:#6f8de3;"></i>
                </div>

                <div class="leave-btn" style="display: inline;">
                    <i class="fa fa-sign-out fa-3x leave-btn-icon" aria-hidden="true" style="color:#e36f7a;"></i>
                </div>
            </div>
        </div>

    </main>

    <input id="muteStatus" type="hidden" value="unmuted">
    <input id="camStatus" type="hidden" value="on">

    <script>
        var page_link = $(location).attr('href');
        var user_id = <?= $this->session->userdata("cid") ?>;
        var base_url = "<?= base_url() ?>";
        var user_name = "<?= $this->session->userdata('fullname') ?>";
        user_name = (user_name == '') ? 'No Name' : user_name;

        var meeting_id = "<?=$meeting->id?>";
        var meeting_to = "<?=$meeting->meeting_to?>";


        <?php
        foreach ($socket_config as $config_name => $config_value)
        {
            echo "\n var {$config_name} = '{$config_value}';";
        }
        echo"\n";
        ?>

    </script>


    <!--- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.3.5/dist/sweetalert2.all.min.js"></script>

    <!--- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" />

    <script src="<?= base_url() ?>assets/lounge/video-meet/video-meet.js?v=<?= rand(1, 100) ?>"></script>

<?php
}
?>
