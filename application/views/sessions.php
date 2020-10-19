<style>
    .post-info {
        margin-bottom: 0px; 
        opacity: 1; 
    }
    .post-item {
        border-bottom: 2px solid #9b9b9b;
    }

    .hidden {
        visibility: hidden;
    }
    a:hover {
        color: #000 !important;
    }
    section{
        padding: 25px 0px;
    }

    .icon-home {
        color: #337ab7;
        font-size: 1.5em;
        font-weight: 700;
        vertical-align: middle;
    }

    .box-home {
        background-color: #444;
        border-radius: 20px;
        background: rgb(223 223 223 / 60%);
        min-height: 150px;
        max-height: 150px;
        padding: 15px;
        border-bottom: 5px solid;
    }

    .box_home_active {
        background-color: #337ab7;
        border-radius: 20px;
        min-height: 150px;
        max-height: 150px;
        padding: 15px;
        border-bottom: 5px solid;
        color: #fff !important;
    }

    .box-home:hover {
        background-color: #ef9d45;
        color: #fff !important;
    }
    .presenter_open_modul:hover{
        color: #ef9d45 !important; 
    }

    .alertify {
        top: 200px;
    }
    .colorBlueOne{
        color:#337ab7 !important;
    }
    .colorBlueOne:hover{
        color:#337ab7 !important;
    }
    .blueBgOne{
        background-color: #337ab7 !important;
        border-color: #006fce94 !important;
    }
    .post-item{
        width: 1500px;
        background: rgb(223 223 223 / 60%);
        float: unset;
        margin: 0 auto;
        display: table;

    }
    .videoWindow{
        background-color: white;
        width: 640px;
        height: 320px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 50px;
        box-shadow: inset 0 0 2px 2px #d6d6d6;
    }
    @media screen and (max-width: 1600px) {
        .post-item{
            width: 90% !important;
        }
    }
    @media screen and (max-width: 750px) {
        .post-item{
            width: 100% !important;
            padding: 0;
        }
        .container-fullscreen{
            padding: 0 5px;
        }
        .post-content, .post-content-single{
            padding: 0;
        }
        .videoWindow{
            width: 100%;
            max-width: 100%;
            height: max-content;
        }
    }

    .videoWindow .fluid-width-video-wrapper{
        background-color: #3c497e;
    }

</style>
<section class="parallax" style="background-image: url(<?= base_url() ?>front_assets/images/bubble_bg_1920.jpg); top: 0; padding-top: 0px;" data-roundtable="<?=$roundtable->roundtable?>">
<!--<section class="parallax" style="background-image: url(<?= base_url() ?>front_assets/images/Sessions_BG_screened.jpg); top: 0; padding-top: 0px;">-->
    <div class="container container-fullscreen" style="min-height: 900px;">
        <div class="col-md-12 m-t-50" style="text-align: -webkit-center;">
            <?php
            if (isset($all_sessions_week) && !empty($all_sessions_week)) {
                foreach ($all_sessions_week as $val) {
                    ?>
                    <div class="col-md-2 col-sm-12" style="margin-bottom:30px;">
                        <a class="icon-home" href="<?= base_url() ?>sessions/getsessions_data/<?= $val->sessions_date ?>">
                            <?php
                            $current_date = $this->uri->segment(3);
                            if ($current_date == "") {
                                $current_date = isset($selected_date) ? $selected_date : $all_sessions_week[0]->sessions_date;
                            }
                            if ($val->sessions_date == $current_date) {
                                ?>
                                <div class="col-lg box_home_active text-center">
                                <?php } else { ?>
                                    <div class="col-lg box-home text-center">
                                    <?php } ?>
                                    <label style="margin-bottom: 20px; margin-top: 20px;   font-size: 30px; font-weight: 700;"><?= $val->dayname ?></label><br>
                                    <label><?= date('M-d-Y', strtotime($val->sessions_date)); ?></label>
                                </div>
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <!-- CONTENT -->
        <section class="content">
            <div>
                <?php
                $session_date_from_url = '';
                $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$current_date = $this->uri->segment(3);
                            if ($current_date == "") {
                                $current_date = isset($selected_date) ? $selected_date : $all_sessions_week[0]->sessions_date;
                            }
                $session_date_from_url = $current_date;
                if ($session_date_from_url == '2020-10-15') { ?>
                <div class="videoWindow">
                    <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/467905249" allowfullscreen></iframe>
                </div>
                <?php }elseif ($session_date_from_url == '2020-10-16'){ ?>
                    <div class="videoWindow">
                        <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/467905166" allowfullscreen></iframe>
                    </div>
                <?php }elseif ($session_date_from_url == '2020-10-17'){ ?>
                    <div class="videoWindow">
                        <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/467905224" allowfullscreen></iframe>
                    </div>
                <?php }elseif ($session_date_from_url == '2020-10-18'){ ?>
				      <div class="videoWindow">
                        <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/467905245" allowfullscreen></iframe>
                    </div>
				 <?php }elseif ($session_date_from_url == '2020-10-19' && date("Y-m-d") == '2020-10-19'){ ?>
		            <div class="videoWindow">
                        <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/467905182" allowfullscreen></iframe>
                    </div>	
				<?php } ?>

                <!-- Blog post-->
                <div class="post-content post-single">
                    <?php
                    $session_limit = $this->common->get_roundtable_setting();
                    ?>
                    <input type="hidden" value="<?= $session_limit->per_attendee ?>" id="per_attendee">
                    <!-- Blog image post-->
                    <?php
                    if (isset($all_sessions) && !empty($all_sessions)) {
                        foreach ($all_sessions as $val) {
                            if ($val->sessions_visibility != "hidden") {
                                ?>
                                <?php
                                if ($val->sessions_type_status == "Private") {
                                    $time = $val->time_slot;
                                    $datetime = $val->sessions_date . ' ' . $time;
//                                    $datetime = date("Y-m-d H:i", strtotime($datetime));
//                                    $datetime = new DateTime($datetime);
//                                    $datetime1 = new DateTime();
//                                    $diff = $datetime->getTimestamp() - $datetime1->getTimestamp();
//                                    if ($diff >= 60) {
//                                        $diff = $diff - 60;
//                                    } else {
//                                        $diff = 0;
//                                    }

//                                    var_dump($datetime);
                                    ?>
                                    <div class="timerPost" data-date='<?=$datetime?>' data-session-id="<?=getAppName($val->sessions_id)?>" style="display: none"></div>
                                    <?php
                                    $user_detias = $this->common->get_user_details($this->session->userdata("cid"));
                                    if ($user_detias->customer_type != "Dummy users" && $user_detias->customer_type != "full_conference_no_roundtables" && $user_detias->customer_type != "Associate - Full Payment" && $user_detias->customer_type != "Associate Branch" && $user_detias->customer_type != "Associate - Monthly") {
                                        if ($val->total_sign_up_sessions < $session_limit->roundtable) {
                                            if ($val->status_sign_up_sessions == 0) {
                                                ?>
                                                <div class="post-item post-item<?=getAppName($val->sessions_id) ?>">
                                                    <div class="post-image col-md-3 m-t-20">
                                                        <a> <?php if ($val->sessions_photo != "") { ?> <img alt="" src="<?= base_url() ?>uploads/sessions/<?= $val->sessions_photo ?>"> <?php } else { ?>  <img alt="" src="<?= base_url() ?>front_assets/images/session_avtar.jpg"> <?php } ?>  </a>
                                                    </div>
                                                    <div class="post-content-details col-md-9 m-t-30">
                                                        <div class="post-title">
                                                            <h6 style="font-weight: 600; font-size: 15px;"><?= $val->sessions_date . ' ' . date("h:i A", strtotime($val->time_slot)) . ' - ' . date("h:i A", strtotime($val->end_time)) ?> ET</h6>
                                                            <h3><a class="colorBlueOne" style="font-weight: 900;"><?= $val->session_title ?></a></h3>
                                                        </div>
                                                        <?php
                                                        if (isset($val->presenter) && !empty($val->presenter)) {
                                                            foreach ($val->presenter as $value) {
                                                                ?>
                                                                <div class="post-info" style="color: #000 !important; font-size: larger; font-weight: 700;"><span class="post-autor"><a href="#" style="color: #000;" data-presenter_photo="<?= $value->presenter_photo ?>" data-presenter_name="<?= $value->presenter_name ?>" data-designation="<?= $value->designation ?>" data-email="<?= $value->email ?>" data-company_name="<?= $value->company_name ?>" data-twitter_link="<?= $value->twitter ?>" data-facebook_link="<?= $value->facebook ?>" data-linkedin_link="<?= $value->linkin ?>" data-bio="<?= $value->bio ?>"  class="presenter_open_modul" style="color: #337ab7;"><u><?= $value->presenter_name ?></u><?= ($value->degree != "") ? "," : "" ?> </a></span> <span class="post-category"> <?= $value->degree ?></span> </div>
                                                                <div class="post-info" style="color: #337aba !important; font-size: larger; font-weight: 700;"><span class="post-category"> <?= $value->company_name ?></span> </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <div class="post-description" style="margin-top: 10px;">
                                                            <p style="margin-bottom: 10px; color: black;"><?= $val->sessions_description ?></p>

                                                            <?php
                                                            if($val->status==0){
                                                                ?>
                                                                <a class="button black-light button-3d rounded right btn-danger" style="margin: 0px 0px 0px 5px; "><span>This session is closed</span></a>

                                                                <?php
                                                            }else{
                                                                ?>
                                                            <a class="button black-light button-3d rounded right btn_sign_up blueBgOne" style="margin: 0px 0;" data-sessions_id="<?= $val->sessions_id ?>" data-user_limit="<?= $val->total_sign_up_sessions_user ?>" data-session-type="<?=$val->sessions_type_status?>" data-session-id="<?=getAppName($val->sessions_id) ?>" data-url="<?= base_url() ?>sessions/attend/<?= $val->sessions_id ?>"><span>Attend</span></a>
                                                                <a class="button black-light button-3d rounded right save_to_swag_bag blueBgOne" data-sessions_id="<?= $val->sessions_id ?>" data-swag_bag_btn_status="0"   style="margin: 0px 5px 0px 0px"><?= ($val->status_my_swag_bag == 0) ? "Save to Itinerary" : "Remove from Itinerary" ?> </a>

                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="post-item post-item<?=getAppName($val->sessions_id) ?>">
                                                    <div class="post-image col-md-3 m-t-20">
                                                        <a href="<?= base_url() ?>sessions/attend/<?= $val->sessions_id ?>"> <?php if ($val->sessions_photo != "") { ?> <img alt="" src="<?= base_url() ?>uploads/sessions/<?= $val->sessions_photo ?>"> <?php } else { ?>  <img alt="" src="<?= base_url() ?>front_assets/images/session_avtar.jpg"> <?php } ?>  </a>
                                                    </div>
                                                    <div class="post-content-details col-md-9 m-t-30">
                                                        <div class="post-title">
                                                            <h6 style="font-weight: 600; font-size: 15px;"><?= $val->sessions_date . ' ' . date("h:i A", strtotime($val->time_slot)) . ' - ' . date("h:i A", strtotime($val->end_time)) ?> ET</h6>
                                                            <h3><a href="<?= base_url() ?>sessions/attend/<?= $val->sessions_id ?>" class="colorBlueOne" style="font-weight: 900;"><?= $val->session_title ?></a></h3>
                                                        </div>
                                                        <?php
                                                        if (isset($val->presenter) && !empty($val->presenter)) {
                                                            foreach ($val->presenter as $value) {
                                                                ?>
                                                                <div class="post-info" style="color: #000 !important; font-size: larger; font-weight: 700;"><span class="post-autor"><a href="#" style="color: #000;" data-presenter_photo="<?= $value->presenter_photo ?>" data-presenter_name="<?= $value->presenter_name ?>" data-designation="<?= $value->designation ?>" data-email="<?= $value->email ?>" data-company_name="<?= $value->company_name ?>" data-twitter_link="<?= $value->twitter ?>" data-facebook_link="<?= $value->facebook ?>" data-linkedin_link="<?= $value->linkin ?>" data-bio="<?= $value->bio ?>"  class="presenter_open_modul" style="color: #337ab7;"><u><?= $value->presenter_name ?></u><?= ($value->degree != "") ? "," : "" ?> </a></span> <span class="post-category"> <?= $value->degree ?></span> </div>
                                                                <div class="post-info" style="color: #337aba !important; font-size: larger; font-weight: 700;"><span class="post-category"> <?= $value->company_name ?></span> </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <div class="post-description" style="margin-top: 10px;">
                                                            <p style="margin-bottom: 10px; color: black;"><?= $val->sessions_description ?></p>


                                                            <?php
                                                            if($val->status==0){
                                                                ?>
                                                                <a class="button black-light button-3d rounded right btn-danger" style="margin: 0px 0px 0px 5px; "><span>This session is closed</span></a>

                                                                <?php
                                                            }else{
                                                                ?>
                                                            <a class="button black-light button-3d rounded right blueBgOne goWaitHall" data-session-type="<?=$val->sessions_type_status?>" data-session-id="<?=getAppName($val->sessions_id) ?>" style="margin: 0px 0px 0px 5px; " data-url="<?= base_url() ?>sessions/attend/<?= $val->sessions_id ?>"><span>Attend</span></a>

                                                                <a class="button black-light button-3d rounded right btn_unregister blueBgOne" style="margin: 0px 0;" data-sessions_id="<?= $val->sessions_id ?>" ><span>Unregister</span></a>

                                                                <a class="button black-light button-3d rounded right save_to_swag_bag blueBgOne" data-sessions_id="<?= $val->sessions_id ?>" data-swag_bag_btn_status="0"   style="margin: 0px 5px 0px 0px"><?= ($val->status_my_swag_bag == 0) ? "Save to Itinerary" : "Remove from Itinerary" ?> </a>

                                                                <?php
                                                            }
                                                            ?>


                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <div class="post-item post-item<?=getAppName($val->sessions_id) ?>">
                                                <div class="post-image col-md-3 m-t-20">
                                                    <a> <?php if ($val->sessions_photo != "") { ?> <img alt="" src="<?= base_url() ?>uploads/sessions/<?= $val->sessions_photo ?>"> <?php } else { ?>  <img alt="" src="<?= base_url() ?>front_assets/images/session_avtar.jpg"> <?php } ?>  </a>
                                                </div>
                                                <div class="post-content-details col-md-9 m-t-30">
                                                    <div class="post-title">
                                                        <h6 style="font-weight: 600; font-size: 15px;"><?= $val->sessions_date . ' ' . date("h:i A", strtotime($val->time_slot)) . ' - ' . date("h:i A", strtotime($val->end_time)) ?> ET</h6>
                                                        <h3><a class="colorBlueOne" style="font-weight: 900;"><?= $val->session_title ?></a></h3>
                                                    </div>
                                                    <?php
                                                    if (isset($val->presenter) && !empty($val->presenter)) {
                                                        foreach ($val->presenter as $value) {
                                                            ?>
                                                            <div class="post-info" style="color: #000 !important; font-size: larger; font-weight: 700;"><span class="post-autor"><a href="#" style="color: #000;" data-presenter_photo="<?= $value->presenter_photo ?>" data-presenter_name="<?= $value->presenter_name ?>" data-designation="<?= $value->designation ?>" data-email="<?= $value->email ?>" data-company_name="<?= $value->company_name ?>" data-twitter_link="<?= $value->twitter ?>" data-facebook_link="<?= $value->facebook ?>" data-linkedin_link="<?= $value->linkin ?>" data-bio="<?= $value->bio ?>"  class="presenter_open_modul" style="color: #337ab7;"><u><?= $value->presenter_name ?></u><?= ($value->degree != "") ? "," : "" ?> </a></span> <span class="post-category"> <?= $value->degree ?></span> </div>
                                                            <div class="post-info" style="color: #337aba !important; font-size: larger; font-weight: 700;"><span class="post-category"> <?= $value->company_name ?></span> </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <div class="post-description" style="margin-top: 10px;">
                                                        <p style="margin-bottom: 10px; color: black;"><?= $val->sessions_description ?></p>
                                                        <?php
                                                        if ($val->status_sign_up_sessions == 1) {
                                                            ?>

                                                            <?php
                                                            if($val->status==0){
                                                                ?>
                                                                <a class="button black-light button-3d rounded right btn-danger" style="margin: 0px 0px 0px 5px; "><span>This session is closed</span></a>

                                                                <?php
                                                            }else{
                                                                ?>
                                                            <a class="button black-light button-3d rounded right blueBgOne goWaitHall" data-session-type="<?=$val->sessions_type_status?>" data-session-id="<?=getAppName($val->sessions_id) ?>" style="margin: 0px 0px 0px 5px; " data-url="<?= base_url() ?>sessions/attend/<?= $val->sessions_id ?>"><span>Attend</span></a>
                                                                <a class="button black-light button-3d rounded right btn_unregister blueBgOne" style="margin: 0px 0;" data-sessions_id="<?= $val->sessions_id ?>" ><span>Unregister</span></a>

                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                        } else {
                                                            ?>
                                                            <a class="button black-light button-3d rounded right blueBgOne" style="margin: 0px 0;"><span>Roundtable Full</span></a>
                                                            <?php
                                                        }
                                                        ?>
                                                        <a class="button black-light button-3d rounded right save_to_swag_bag blueBgOne" data-sessions_id="<?= $val->sessions_id ?>" data-swag_bag_btn_status="0"   style="margin: 0px 5px 0px 0px"><?= ($val->status_my_swag_bag == 0) ? "Save to Itinerary" : "Remove from Itinerary" ?> </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                <?php } else { ?>
                                    <div class="post-item">
                                        <div class="post-image col-md-3 m-t-20">
                                        <?php if($val->sessions_id == 198) { ?>
                                            <a href="#" data-toggle="modal" data-target="#presidentRemarksModal"> <?php if ($val->sessions_photo != "") { ?> <img alt="" src="<?= base_url() ?>uploads/sessions/<?= $val->sessions_photo ?>"> <?php } else { ?>  <img alt="" src="<?= base_url() ?>front_assets/images/session_avtar.jpg"> <?php } ?>  </a>
                                        <?php }elseif($val->sessions_id == 42){ ?>
                                            <a target="_blank" href="https://zoom.us/j/92714977803"> <?php if ($val->sessions_photo != "") { ?> <img alt="" src="<?= base_url() ?>uploads/sessions/<?= $val->sessions_photo ?>"> <?php } else { ?>  <img alt="" src="<?= base_url() ?>front_assets/images/session_avtar.jpg"> <?php } ?>  </a>
                                        <?php }elseif($val->sessions_id == 43){ ?>
                                            <a target="_blank" href="https://us02web.zoom.us/j/82286796031"> <?php if ($val->sessions_photo != "") { ?> <img alt="" src="<?= base_url() ?>uploads/sessions/<?= $val->sessions_photo ?>"> <?php } else { ?>  <img alt="" src="<?= base_url() ?>front_assets/images/session_avtar.jpg"> <?php } ?>  </a>
                                        <?php }elseif($val->sessions_id == 197){ ?>
                                            <a target="_blank" href="https://zoom.us/j/93326270074"> <?php if ($val->sessions_photo != "") { ?> <img alt="" src="<?= base_url() ?>uploads/sessions/<?= $val->sessions_photo ?>"> <?php } else { ?>  <img alt="" src="<?= base_url() ?>front_assets/images/session_avtar.jpg"> <?php } ?>  </a>
                                        <?php }elseif($val->sessions_id == 204){ ?>
                                            <a target="_blank" href="https://zoom.us/j/94150667111"> <?php if ($val->sessions_photo != "") { ?> <img alt="" src="<?= base_url() ?>uploads/sessions/<?= $val->sessions_photo ?>"> <?php } else { ?>  <img alt="" src="<?= base_url() ?>front_assets/images/session_avtar.jpg"> <?php } ?>  </a>
                                        <?php }else{ ?>
                                            <a href="<?= base_url() ?>sessions/attend/<?= $val->sessions_id ?>"> <?php if ($val->sessions_photo != "") { ?> <img alt="" src="<?= base_url() ?>uploads/sessions/<?= $val->sessions_photo ?>"> <?php } else { ?>  <img alt="" src="<?= base_url() ?>front_assets/images/session_avtar.jpg"> <?php } ?>  </a>
                                        <?php } ?>
                                        </div>
                                        <div class="post-content-details col-md-9 m-t-30">
                                            <div class="post-title">
                                                <h6 style="font-weight: 600; font-size: 15px;"><?= $val->sessions_date . ' ' . date("h:i A", strtotime($val->time_slot)) . ' - ' . date("h:i A", strtotime($val->end_time)) ?> ET</h6>
                                                <h3>
                                                    <?php if($val->sessions_id == 198) { ?>
                                                        <a href="#" class="colorBlueOne" style="font-weight: 900;" data-toggle="modal" data-target="#presidentRemarksModal"><?= $val->session_title ?></a>
                                                    <?php }elseif($val->sessions_id == 42){ ?>
                                                        <a target="_blank" href="https://zoom.us/j/92714977803" class="colorBlueOne" style="font-weight: 900;"><?= $val->session_title ?></a>
                                                    <?php }elseif($val->sessions_id == 43){ ?>
                                                        <a target="_blank" href="https://us02web.zoom.us/j/82286796031" class="colorBlueOne" style="font-weight: 900;"><?= $val->session_title ?></a>
                                                    <?php }elseif($val->sessions_id == 197){ ?>
                                                        <a target="_blank" href="https://zoom.us/j/93326270074" class="colorBlueOne" style="font-weight: 900;"><?= $val->session_title ?></a>
                                                    <?php }elseif($val->sessions_id == 204){ ?>
                                                        <a target="_blank" href="https://zoom.us/j/94150667111" class="colorBlueOne" style="font-weight: 900;"><?= $val->session_title ?></a>
                                                    <?php }else{ ?>
                                                        <a href="<?= base_url() ?>sessions/attend/<?= $val->sessions_id ?>" class="colorBlueOne" style="font-weight: 900;"><?= $val->session_title ?></a>
                                                    <?php } ?>
                                                    <span style="float: right; font-size: 15px; font-weight: 700;"><?php
                                                        if (isset($val->sessions_tracks_data) && !empty($val->sessions_tracks_data)) {
                                                            foreach ($val->sessions_tracks_data as $value) {
                                                                ?> <?= $value->sessions_tracks ?> <?php
                                                            }
                                                        }
                                                        ?>
                                                    </span>
                                                </h3>
                                            </div>
                                            <?php
                                            if (isset($val->presenter) && !empty($val->presenter)) {
                                                foreach ($val->presenter as $value) {
                                                    ?>
                                                    <div class="post-info" style="color: #000 !important; font-size: larger; font-weight: 700;"><span class="post-autor"><a href="#" style="color: #000;" data-presenter_photo="<?= $value->presenter_photo ?>" data-presenter_name="<?= $value->presenter_name ?>" data-designation="<?= $value->designation ?>" data-email="<?= $value->email ?>" data-company_name="<?= $value->company_name ?>" data-twitter_link="<?= $value->twitter ?>" data-facebook_link="<?= $value->facebook ?>" data-linkedin_link="<?= $value->linkin ?>" data-bio="<?= $value->bio ?>"  class="presenter_open_modul" style="color: #337ab7;"><u><?= $value->presenter_name ?></u><?= ($value->degree != "") ? "," : "" ?> </a></span> <span class="post-category"> <?= $value->degree ?></span> </div>
                                                    <div class="post-info" style="color: #337aba !important; font-size: larger; font-weight: 700;"><span class="post-category"> <?= $value->company_name ?></span> </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <div class="post-description" style="margin-top: 10px;">
                                                <p style="margin-bottom: 10px; color: black;"><?= $val->sessions_description ?></p>
                                                <?php if($val->sessions_id == 198) { ?>
                                                    <a class="button black-light button-3d rounded right blueBgOne" style="margin: 0px 0;" href="" data-toggle="modal" data-target="#presidentRemarksModal"><span>Watch</span></a>
                                                <?php }elseif($val->sessions_id == 42){ ?>
                                                    <a target="_blank" class="button black-light button-3d rounded right blueBgOne" style="margin: 0px 0;" href="https://zoom.us/j/92714977803"><span>Attend</span></a>
                                                    <a class="button black-light button-3d rounded right save_to_swag_bag blueBgOne" data-sessions_id="<?= $val->sessions_id ?> " data-swag_bag_btn_status="0"   style="margin: 0px 5px 0px 0px"> <?= ($val->status_my_swag_bag == 0) ? "Save to Itinerary" : "Remove from Itinerary" ?> </a>
                                                <?php }elseif($val->sessions_id == 43){ ?>
                                                    <a target="_blank" class="button black-light button-3d rounded right blueBgOne" style="margin: 0px 0;" href="https://us02web.zoom.us/j/82286796031"><span>Attend</span></a>
                                                    <a class="button black-light button-3d rounded right save_to_swag_bag blueBgOne" data-sessions_id="<?= $val->sessions_id ?> " data-swag_bag_btn_status="0"   style="margin: 0px 5px 0px 0px"> <?= ($val->status_my_swag_bag == 0) ? "Save to Itinerary" : "Remove from Itinerary" ?> </a>
                                                <?php }elseif($val->sessions_id == 197){ ?>
                                                    <a target="_blank" class="button black-light button-3d rounded right blueBgOne" style="margin: 0px 0;" href="https://zoom.us/j/93326270074"><span>Attend</span></a>
                                                    <a class="button black-light button-3d rounded right save_to_swag_bag blueBgOne" data-sessions_id="<?= $val->sessions_id ?> " data-swag_bag_btn_status="0"   style="margin: 0px 5px 0px 0px"> <?= ($val->status_my_swag_bag == 0) ? "Save to Itinerary" : "Remove from Itinerary" ?> </a>
                                                <?php }elseif($val->sessions_id == 204){ ?>
                                                    <a target="_blank" class="button black-light button-3d rounded right blueBgOne" style="margin: 0px 0;" href="https://zoom.us/j/94150667111"><span>Attend</span></a>
                                                    <a class="button black-light button-3d rounded right save_to_swag_bag blueBgOne" data-sessions_id="<?= $val->sessions_id ?> " data-swag_bag_btn_status="0"   style="margin: 0px 5px 0px 0px"> <?= ($val->status_my_swag_bag == 0) ? "Save to Itinerary" : "Remove from Itinerary" ?> </a>
                                                <?php }else{ ?>

                                                    <?php
                                                    if($val->status==0){
                                                        ?>
                                                        <a class="button black-light button-3d rounded right btn-danger" style="margin: 0px 0px 0px 5px; "><span>This session is closed</span></a>

                                                        <?php
                                                    }else{
                                                        ?>
                                                        <a class="button black-light button-3d rounded right blueBgOne" style="margin: 0px 0;" href="<?= base_url() ?>sessions/attend/<?= $val->sessions_id ?>"><span>Attend</span></a>
                                                        <a class="button black-light button-3d rounded right save_to_swag_bag blueBgOne" data-sessions_id="<?= $val->sessions_id ?> " data-swag_bag_btn_status="0"   style="margin: 0px 5px 0px 0px"> <?= ($val->status_my_swag_bag == 0) ? "Save to Itinerary" : "Remove from Itinerary" ?> </a>

                                                        <?php
                                                    }
                                                    ?>

                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </div>
                <!-- END: Blog post-->
            </div>
        </section>
        <!-- END: SECTION -->
    </div>
</div>
</section>
<!-- Modal -->
<div class="modal fade" id="presidentRemarksModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" style="background-color: #3c497e;">
                <iframe id="presidentRemarksIframe" src="https://player.vimeo.com/video/467905144" width="100%" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
            </div>
            <div class="modal-footer" style="background-color: #3c497e;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#presidentRemarksModal').on('hidden.bs.modal', function () {
            $('#presidentRemarksIframe').attr('src', $('#presidentRemarksIframe').attr('src'));
        })
    });
</script>
<div class="modal fade" id="modal" tabindex="-1" role="modal" aria-labelledby="modal-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row" style="padding-top: 10px; padding-bottom: 20px;">
                    <div class="col-sm-12">
                        <div class="col-sm-4" id="social_link_div_show">
                            <div id="social_link_div" style="text-align: center; background-color: #ff095c; text-align: center; background-color: #ff095c; position: absolute; padding: 0px 50px 0px 50px; margin-top: 100px; border-bottom-left-radius: 41px; border-bottom-right-radius: 41px;">
                                <ul style="list-style: none; display: inline-flex; padding-left: 0px; padding-top: 10px;">
                                    <li data-placement="top" data-original-title="Twitter">
                                        <a id="twitter_link" target="_blank">
                                            <i class="fa fa-twitter" style="color: #fff;"></i>
                                        </a>
                                    </li>
                                    <li data-placement="top" data-original-title="Facebook" style="padding-left: 15px; padding-right: 20px;">
                                        <a id="facebook_link" target="_blank">
                                            <i class="fa fa-facebook" style="color: #fff;"></i>
                                        </a>
                                    </li>
                                    <li data-placement="top" data-original-title="LinkedIn">
                                        <a id="linkedin_link" target="_blank">
                                            <i class="fa fa-linkedin" style="color: #fff;"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <img src="" id="presenter_profile" class="img-circle" style="height: 170px; width: 170px;">


                        </div>
                        <div class="col-sm-8" style="padding-top: 15px;">
                            <h3 id="presenter_title" style="font-weight: 700"></h3>
<!--                        <p style="border-bottom: 1px dotted; margin-bottom: 10px; padding-bottom: 10px;"><b style="color: #000;">Email </b> <span id="email" style="padding-left: 10px;"></span></p>-->
                            <p style="border-bottom: 1px dotted; margin-bottom: 10px; padding-bottom: 10px;"><b style="color: #000;" id="company_lbl">Company </b> <span id="company" style="padding-left: 10px;"></span></p>
                            <p style="padding-bottom: 0px; margin-bottom: 0px;"><span id="bio_text" style="padding-left: 10px;"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="push_notification" tabindex="-1" role="modal" aria-labelledby="modal-label" aria-hidden="true" style="display: none; text-align: left; right: unset;">
    <input type="hidden" id="push_notification_id" value="">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 1px solid #ef9d45;">
            <div class="modal-body">
                <div class="row" style="padding-top: 10px; padding-bottom: 20px;">
                    <div class="col-sm-12">
                        <div style="color:#ef9d45; font-size: 16px; font-weight: 800; " id="push_notification_message"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="close push_notification_close" style="padding: 10px; color: #fff; background-color: #ef9d45; opacity: 1;" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha512-v8ng/uGxkge3d1IJuEo6dJP8JViyvms0cly9pnbfRxT6/31c3dRWxIiwGnMSWwZjHKOuY3EVmijs7k1jz/9bLA==" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function () {
        let socket = io("<?=getSocketUrl()?>");
        var roundTable=parseInt($(".parallax").data("roundtable"));


        function waitHallButtonControl(){
            $(".timerPost").each(function () {
                var date=$(this).data("date");
                var sessionId=$(this).data("sessionId");

                $.post("<?=base_url()?>sessions/waitHallButtonControl",{"date":date},function (response) {
                    if (response <= 60) {
                        var post= $(".post-content .post-item"+sessionId)
                        var hall=post.find(".goWaitHall");
                        hall.html("Roundtable full");
                        hall.attr("data-url","");
                    }
                })

            })
        }
        waitHallButtonControl()
       setInterval(function () {
           waitHallButtonControl()
       },1000)

        $(".post-content .post-item").each(function () {
            var hall=$(this).find(".goWaitHall");
            var sessionType=hall.data("session-type");
            var sesionId=hall.data("session-id")

            if(sessionType=="Private"){
                socket.emit("gettHallViewUsers",sesionId,function (data) {
                    var users=data.users;
                    if(users>=roundTable){
                        hall.html("Roundtable full");
                    }
                })
            }
        })

        $('.goWaitHall').on('click', function () {
            var sesionId=$(this).data("session-id")
            var url=$(this).data("url")
            var sessionType=$(this).data("session-type")
            if(sessionType=="Private"){
                socket.emit("gettHallViewUsers",sesionId,function (data) {
                    var users=data.users;
                    if(roundTable>users) {
                        if(url)   window.location.href=url;

                    }else{
                        alertify.error('Roundtable is full!');
                    }
                })
            }
        })

        socket.on("hallViewUsers",function (response) {
            var sesionId=response.sessionId;
            var users=response.users;

            console.log(users);

            console.log(users);
            console.log(roundTable);
            var post= $(".post-content .post-item"+sesionId)
            var hall=post.find(".goWaitHall");
            if(users>=roundTable) {
                hall.html("Roundtable full");
            }else{
                hall.html("Attend");

            }
        })


        $('.btn_sign_up').on('click', function () {
            var sessions_id = $(this).attr("data-sessions_id");
            var user_limit = $(this).attr("data-user_limit");
            var total_user_limit = $("#per_attendee").val();
            if (user_limit < total_user_limit) {
                alertify.confirm('Are you sure you want to sign up for this roundtable session?', function (e) {
                    if (e) {
                        $.ajax({
                            url: "<?= base_url() ?>sessions/sign_up_sessions",
                            type: "post",
                            data: {'sessions_id': sessions_id},
                            dataType: "json", success: function (data) {
                                if (data.status == "success") {
                                    window.location.reload();
                                } else if (data.status == "exist") {
                                    alertify.alert('This is not available. Registration is limited to one concurrent roundtable per registrant.');
                                }
                            }
                        });
                    }
                });
            } else {
                alertify.alert('You have reached your roundtable limitation');
            }
        });

        $('.btn_unregister').on('click', function () {
            var sessions_id = $(this).attr("data-sessions_id");
            alertify.confirm('Are you sure you want to unregister for this roundtable session?', function (e) {
                if (e) {
                    $.ajax({
                        url: "<?= base_url() ?>sessions/unregister_sessions",
                        type: "post",
                        data: {'sessions_id': sessions_id},
                        dataType: "json", success: function (data) {
                            window.location.reload();
                        }
                    });
                }
            });
        });

        $('.save_to_swag_bag').on('click', function () {
            var sessions_id = $(this).attr("data-sessions_id");
            var status = $(this).attr("data-swag_bag_btn_status");
            var $this = $(this);
            $.ajax({
                url: "<?= base_url() ?>sessions/save_to_swag_bag",
                type: "post",
                data: {'sessions_id': sessions_id},
                dataType: "json",
                success: function (data) {
                    if (data.status == "save") {
                        $this.text("Remove from Itinerary");
                    } else if (data.status == "remove") {
                        $this.text("Save to Itinerary");
                    }
                }
            });
        });

        $('#sessions_tracks').on('change', function () {
            $("#frm_search_data").submit();
        });

        $('#social_link_div').addClass('hidden');
        $("#social_link_div_show").hover(function () {
            $('#social_link_div').removeClass('hidden');
        }, function () {
            $('#social_link_div').addClass('hidden');
        });
        $(".presenter_open_modul").click(function () {
            var presenter_photo = $(this).attr("data-presenter_photo");
            var presenter_name = $(this).attr("data-presenter_name");
            var designation = $(this).attr("data-designation");
            var company_name = $(this).attr("data-company_name");
            var email = $(this).attr("data-email");
            var twitter_link = $(this).attr("data-twitter_link");
            var facebook_link = $(this).attr("data-facebook_link");
            var linkedin_link = $(this).attr("data-linkedin_link");
            var bio = $(this).attr('data-bio');
            if (presenter_photo != "" && presenter_photo != null) {
                $.ajax({
                    url: '<?= base_url() ?>uploads/presenter_photo/' + presenter_photo,
                    type: 'HEAD',
                    error: function ()
                    {
                        $('#presenter_profile').attr('src', "<?= base_url() ?>uploads/presenter_photo/presenter_avtar.png");
                    },
                    success: function ()
                    {
                        $('#presenter_profile').attr('src', "<?= base_url() ?>uploads/presenter_photo/" + presenter_photo);
                    }
                });
            } else {
                $('#presenter_profile').attr('src', "<?= base_url() ?>uploads/presenter_photo/presenter_avtar.png");
            }
            if (designation != "" && designation != null) {
                $('#presenter_title').text(presenter_name + ", " + designation);
            } else {
                $('#presenter_title').text(presenter_name);
            }

            $('#email').text(email);
            if (company_name != "" && company_name != null) {
                $('#company').text(company_name);
                $('#company_lbl').text("Company");
            } else {
                $('#company').text("");
                $('#company_lbl').text("");
            }
            $("#twitter_link").attr("href", twitter_link);
            $("#facebook_link").attr("href", facebook_link);
            $("#linkedin_link").attr("href", linkedin_link);
            $("#bio_text").text(bio);
            $('#modal').modal('show');
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var page_link = $(location).attr('href');
        var user_id = <?= $this->session->userdata("cid") ?>;
        var page_name = "Sessions";
        $.ajax({
            url: "<?= base_url() ?>home/add_user_activity",
            type: "post",
            data: {'user_id': user_id, 'page_name': page_name, 'page_link': page_link},
            dataType: "json",
            success: function (data) {
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        push_notification_admin();
        setInterval(push_notification_admin, 4000);

        $('.push_notification_close').on('click', function () {
            var push_notification_id = $("#push_notification_id").val();
            $.ajax({
                url: "<?= base_url() ?>push_notification/push_notification_close",
                type: "post",
                data: {'push_notification_id': push_notification_id},
                dataType: "json",
                success: function (data) {
                }
            });
        });

        function push_notification_admin()
        {
            var push_notification_id = $("#push_notification_id").val();

            $.ajax({
                url: "<?= base_url() ?>push_notification/get_push_notification_admin",
                type: "post",
                dataType: "json",
                success: function (data) {
                    if (data.status == "success") {
                        if (push_notification_id == "0") {
                            $("#push_notification_id").val(data.result.push_notification_id);
                        }
                        if (push_notification_id != data.result.push_notification_id) {
                            $.ajax({
                                url: "<?= base_url() ?>push_notification/get_push_notification_admin_check_status",
                                type: "post",
                                data: {'push_notification_id': data.result.push_notification_id},
                                dataType: "json",
                                success: function (dt) {
                                    if (dt.status == "success") {
                                        $("#push_notification_id").val(data.result.push_notification_id);
                                        $('#push_notification').modal('show');
                                        $("#push_notification_message").text(data.result.message);
                                    }
                                }
                            });
                        }
                    } else {
                        $('#push_notification').modal('hide');
                    }
                }
            });
        }
    });
</script>



