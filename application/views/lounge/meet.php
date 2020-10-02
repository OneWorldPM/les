<?php
if ($meeting_status['status'] == false)
{?>

    <main role="main" class="container" style="text-align: center;">

        <div class="starter-template">
            <h1>Sorry!</h1>
            <p class="lead"><?=$meeting_status['message']?></p>
        </div>

    </main>

<?php
}else{ ?>
<link href="<?= base_url() ?>assets/lounge/video-meet/video-meet.css?v=<?= rand(1, 100) ?>" rel="stylesheet">

    <main role="main" class="container" style="text-align: center;">

        <div class="starter-template">
            <h1><?= $meeting->topic ?></h1>
        </div>

        <div class="row m-t-20 camera-feeds">

            <div class="col-md-3">
                <video id="localVideo" autoplay muted playsinline width="100%"></video>
                <span class="name-tag">You</span>
                <!-- <div class="soundbar"><span class="currentVolume"></span></div> -->
            </div>
        </div>
        <div class="col-md-12 control-icons-col">
            <div class="feed-control-icons" style="display: inline;">

                <div class="mute-mic-btn" style="display: inline;">
<!--                    <i class="fa fa-microphone-slash fa-3x mute-mic-btn-icon" aria-hidden="true" style="color:#ff422b;"></i>-->
                    <i class="fa fa-microphone fa-3x mute-mic-btn-icon" aria-hidden="true" style="color:#12b81c;"></i>

                </div>

                <div class="share-screen-btn" style="display: inline;">
                    <i class="fa fa-desktop fa-3x share-screen-btn-icon" aria-hidden="true" style="color:#6f8de3;"></i>
                </div>

                <div class="leave-btn" style="display: inline;">
                    <i class="fa fa-sign-out fa-3x leave-btn-icon" aria-hidden="true" style="color:#e36f7a;"></i>
                </div>
            </div>
        </div>

    </main>

    <script>
        var page_link = $(location).attr('href');
        var user_id = <?= $this->session->userdata("cid") ?>;
        var base_url = "<?= base_url() ?>";
        var user_name = "<?= $this->session->userdata('fullname') ?>";
        user_name = (user_name == '') ? 'No Name' : user_name;

        var round_table_id = "<?=$meeting->id?>";

        <?php
        foreach ($socket_config as $config_name => $config_value)
        {
            echo "\n var {$config_name} = '{$config_value}';";
        }
        echo"\n";
        ?>

        $(function() {
            pageReady();
        });
    </script>


    <!--- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.3.5/dist/sweetalert2.all.min.js"></script>

    <script src="<?= base_url() ?>assets/lounge/video-meet/video-meet.js?v=<?= rand(1, 100) ?>"></script>

<?php
}
?>
