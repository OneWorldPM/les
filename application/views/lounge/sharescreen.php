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

        <button class="sharescreen-btn btn btn-success">Start Sharing Screen</button>

    </main>

    <input type="hidden" class="screenshare-status" value="not-sharing">


    <script>
        var page_link = $(location).attr('href');
        var user_id = <?= $this->session->userdata("cid") ?>;
        var base_url = "<?= base_url() ?>";
        var user_name = "<?= $this->session->userdata('fullname') ?>";
        user_name = (user_name == '') ? 'No Name' : user_name;

        var meeting_id = "<?=$meeting->id?>";

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

    <script src="<?= base_url() ?>assets/lounge/video-meet/share-screen.js?v=<?= rand(1, 100) ?>"></script>

    <?php
}
?>
