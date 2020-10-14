<style>
    .modal-footer, .modal-header{
        border-color:#e5e5e5;
    }
    .modal-content{
        box-shadow: 0 5px 15px rgba(0,0,0,.5);
        background-color: #fff;

    }
    .modal-content .btn-default {
        color: #333;
        background-color: #fff;
        border-color: #ccc;
    }
    .modal-content .form-control {
        border-radius: 5px !important;
    }
</style>
<div class="main-content">
    <div class="wrap-content container" id="container">
        <!-- start: PAGE TITLE -->
        <section id="page-title">
            <div class="row">
                <div class="col-sm-8">
                    <h1 class="mainTitle">List Of Sessions</h1>
                </div>
            </div>
        </section>
        <!-- end: PAGE TITLE -->
        <!-- start: DYNAMIC TABLE -->
        <div class="container-fluid container-fullw">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-primary" id="panel5">
                        <div class="panel-heading">
                            <h4 class="panel-title text-white">Import CSV for Sessions</h4>
                        </div>
                        <form class="form-login" id="frm_import_sessions" name="frm_import_sessions" enctype="multipart/form-data" method="post" action="<?= base_url() ?>admin/sessions/import_sessions">
                            <div class="panel-body bg-white" style="border: 1px solid #b2b7bb;">
                                <div class="form-body">
                                    <div class="form-group">
                                        <a href="<?= base_url() ?>uploads/sessions_import_example.csv" download>Download Sample CSV</a>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-large">Select Choose File :</label>
                                        <label id="projectinput8" class="file center-block">
                                            <input type="file" name="import_file" accept=".csv" id="import_file">
                                            <span class="file-custom"></span>
                                        </label><br>
                                        <span id="errorimport_file" style="color:red;"></span>
                                    </div>
                                </div>
                                <div class="form-actions center">
                                    <button type="submit" id="btn_import" class="btn btn-info">
                                        <i class="la la-check-square-o"></i> Import
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="panel panel-primary" id="panel5">
                    <div class="panel-heading">
                        <h4 class="panel-title text-white">Filter Data</h4>
                        <div class="panel-tools">
                            <a data-original-title="Collapse" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm panel-collapse" href="#"><i class="ti-minus collapse-off"></i><i class="ti-plus collapse-on"></i></a>
                        </div>
                    </div>
                    <div class="panel-body bg-white" style="border: 1px solid #b2b7bb!important;">
                        <form action="<?= base_url() ?>admin/sessions/filter" name="filter_frm" id="filter_frm" method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date Range:</label>
                                        <div class="input-group input-daterange datepicker">
                                            <input type="text" placeholder="Start Date" name="start_date" value="" id="from_date" class="form-control">
                                            <span class="input-group-addon bg-primary">to</span>
                                            <input type="text" placeholder="End Date" name="end_date" value="" id="to_date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Session Type:</label>
                                        <select name="session_type" id="session_type" class="form-control">
                                            <option value="">Select</option>
                                            <?php
                                            if (!empty($session_types)) {
                                                foreach ($session_types as $type) {
                                                    if ($type->sessions_type != '') {
                                                        ?>
                                                        <option value="<?= $type->sessions_type_id ?>"><?= $type->sessions_type ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="submit" name="filter_btn" class="btn btn-primary" style="margin-top: 22px;" id="filter_btn" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php if (isset($import_sessions_details) && !empty($import_sessions_details)) { ?>
                <div class="row">
                    <div class="panel panel-primary" id="panel5">
                        <div class="panel-heading">
                            <h4 class="panel-title text-red">Import Fail Sessions</h4>
                        </div>
                        <div class="panel-body bg-white" style="border: 1px solid #b2b7bb!important;">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-bordered table-striped text-center" id="user">
                                        <thead class="th_center">
                                            <tr>
                                                <th>ID</th>
                                                <th>Session Title</th>
                                                <th>Sessions Description</th>
                                                <th>Sessions Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($import_sessions_details) && !empty($import_sessions_details)) {
                                                foreach ($import_sessions_details as $key => $val) {
                                                    $key++;
                                                    ?>
                                                    <tr>
                                                        <td><?= $key ?></td>
                                                        <td><?= $val['session_title'] ?></td>
                                                        <td><?= $val['sessions_description'] ?></td>
                                                        <td><?= $val['sessions_date'] ?></td>
                                                        <td><b style="color: red"><?= $val['status'] ?></b></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="panel panel-primary" id="panel5">
                    <div class="panel-heading">
                        <h4 class="panel-title text-white">Sessions</h4>
                    </div>
                    <div class="panel-body bg-white" style="border: 1px solid #b2b7bb!important;">
                        <form id="frm_sessions_fm" name="frm_sessions_fm" action="#" method="post">
                            <h5 class="over-title margin-bottom-15">
                                <a href="<?= base_url() ?>admin/sessions/add_sessions" class="btn btn-green add-row">
                                    Add Sessions  &nbsp;<i class="fa fa-plus"></i>
                                </a>
                                <button type="button" id="btndeleteall" class="btn btn-sm btn-danger"><i class="ti-trash"></i> Delete</button>
                                <button type="button" id="btndeleteall" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-film"></i> Update Sessions Iframe</button>

                            </h5>
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-bordered table-striped text-center " id="sessions_table">
                                        <thead class="th_center">
                                            <tr>
                                                <td style="width: 60px; text-align: center;"><input type="checkbox" id="select_all" name="select_all"></td>
                                                <th>Date</th>
                                                <th>Photo</th>
                                                <th>Title</th>
                                                <th>Session Type</th>
                                                <th>Type</th>
                                                <th>Registrants</th>
                                                <th>Presenter</th>
                                                 <th>Zoom Meeting Link</th>
                                                <th>Time Slot</th>
                                                <th>Visible</th>
                                                <th style="border-right: 0px solid #ddd;">Action</th>
                                                <th style="border-left: 0px solid #ddd; border-right: 0px solid #ddd;"></th>
                                                <th style="border-left: 0px solid #ddd;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($sessions) && !empty($sessions)) {
                                                foreach ($sessions as $val) {
                                                    ?>
                                                    <tr>
                                                        <td align="center">
                                                            <div>
                                                                <input type="checkbox" class="grid_checkbox" id="sessions[]" name="sessions[]" value="<?= $val->sessions_id ?>"/>                                                
                                                            </div>
                                                        </td>
                                                        <td style="white-space: pre;"><?= date("Y-m-d", strtotime($val->sessions_date)) ?></td>
                                                        <td>
                                                            <?php if ($val->sessions_photo != "") { ?>
                                                                <img src="<?= base_url() ?>uploads/sessions/<?= $val->sessions_photo ?>" style="height: 40px; width: 40px;">
                                                            <?php } else { ?>
                                                                <img src="<?= base_url() ?>front_assets/images/session_avtar.jpg" style="height: 40px; width: 40px;">
                                                            <?php } ?>    
                                                        </td>
                                                        <td style="text-align: left;"><?= $val->session_title ?></td>
                                                        <td style="text-align: left;">
                                                            <?php
                                                            if (isset($val->session_type_details) && !empty($val->session_type_details)) {
                                                                foreach ($val->session_type_details as $value) {
                                                                    echo $value->sessions_type . " <br>";
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?= $val->sessions_type_status ?></td>
                                                        <td>
                                                            <?php if ($val->sessions_type_status == "Private") { ?>
                                                                <?= $val->total_sign_up_sessions ?>/<?= $val->sissions_limit ?>
                                                            <?php } ?>
                                                        </td>

                                                        <td style="text-align: left;">
                                                            <?php
                                                            if (isset($val->presenter) && !empty($val->presenter)) {
                                                                foreach ($val->presenter as $value) {
                                                                    echo $value->presenter_name . " <br>";
                                                                }
                                                            }
                                                            ?>
                                                        </td>
            <!--                                                    <td>
                                                        <?php
                                                        if (isset($val->presenter) && !empty($val->presenter)) {
                                                            foreach ($val->presenter as $value) {
                                                                echo $value->title . " <br>";
                                                            }
                                                        }
                                                        ?>
                                                        </td>-->
                                                         <td><a target="_blank" href="<?= $val->zoom_link ?>"><?= $val->zoom_link ?></a></td>
                                                        <td style="white-space: pre; text-align: right;"><?= date("h:i A", strtotime($val->time_slot)) . ' - ' . date("h:i A", strtotime($val->end_time)) ?></td>
                                                        <td>
                                                            <?php if ($val->sessions_type_status == "Private") { ?>
                                                                <a href="<?= base_url() ?>private_sessions/view/<?= $val->sessions_id ?>" style="margin: 3px;"><?= base_url() ?>private_sessions/view/<?= $val->sessions_id ?></a>
                                                            <?php } else { ?>
                                                                <a href="<?= base_url() ?>sessions/view/<?= $val->sessions_id ?>" style="margin: 3px;"><?= base_url() ?>sessions/view/<?= $val->sessions_id ?></a> 
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url() ?>admin/Attendee_Chat/chat/<?= $val->sessions_id ?>" class="btn btn-warning btn-sm" style="margin: 3px;">Attendee Chat</a>
                                                            <button type="button" class="btn btn-danger btn-sm endSessionSocket" style="margin: 3px;" data-session-id="<?=getAppName($val->sessions_id) ?>">End Session</button>


                                                            <a href="<?= base_url() ?>admin/sessions/view_session/<?= $val->sessions_id ?>" class="btn btn-info btn-sm" style="margin: 3px;">View Session</a>
                                                            <a href="<?= base_url() ?>admin/sessions/edit_sessions/<?= $val->sessions_id ?>" class="btn btn-green btn-sm" style="margin: 3px;">Edit</a>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url() ?>admin/sessions/create_poll/<?= $val->sessions_id ?>" class="btn btn-success btn-sm" style="margin: 3px;">Create Poll</a>
                                                            <a href="<?= base_url() ?>admin/sessions/view_poll/<?= $val->sessions_id ?>" class="btn btn-info btn-sm" style="margin: 3px;">View Poll</a>
                                                            <a href="<?= base_url() ?>admin/sessions/view_question_answer/<?= $val->sessions_id ?>" class="btn btn-primary btn-sm" style="margin: 3px;">View Q&A</a>
                                                            <a href="<?= base_url() ?>admin/sessions/report/<?= $val->sessions_id ?>" class="btn btn-grey btn-sm" style="margin: 3px;">Report</a>
                                                            <a href="<?= base_url() ?>admin/groupchat/sessions_groupchat/<?= $val->sessions_id ?>" class="btn btn-blue btn-sm" style="margin: 3px;">Create Chat</a>
                                                            <a href="<?= base_url() ?>admin/sessions/resource/<?= $val->sessions_id ?>" class="btn btn-success btn-sm" style="margin: 3px;">Resources</a>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url() ?>admin/sessions/delete_sessions/<?= $val->sessions_id ?>" class="btn btn-danger btn-sm" style="font-size: 10px !important;">Delete Session</a>
                                                            <?php if ($val->sessions_type_status == "Private") { ?>
                                                                <a href="<?= base_url() ?>admin/sessions/user_sign_up/<?= $val->sessions_id ?>" class="btn btn-grey btn-sm" style="margin: 3px;">Registrants</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="sessionsIframe">Update Sessions Iframe:</label>
                    <input type="text" class="form-control" id="sessionsIframe" value="<?=$iframe->value?>">
                </div>

                <button class="btn btn-success" id="updateIframe" data-url="<?= base_url() ?>admin/Settings/setSessionIframe">Save</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        let socket = io("<?=getSocketUrl()?>");
        $(".endSessionSocket").on("click", function () {
            var sesionId=$(this).data("session-id");
            alertify.confirm("Are you sure you want to end the session?", function (e) {
                if (e)
                {
                    socket.emit("endSession",sesionId);

                }
            });

        })
        $("#updateIframe").on("click", function () {
          var sessionsIframe=$("#sessionsIframe").val();
          var url=$(this).data("url");
          console.log(url);
          $.post(url,{"iframe":sessionsIframe},function (response) {

              if(response=="success"){
                  alertify.alert('Update Complete');
              }
          })
        });


        $("#btn_import").on("click", function () {
            if ($('#import_file').val() == '') {
                alertify.error('Select File');
                return false;
            } else {
                return true; //submit form
            }
            return false; //Prevent form to submitting
        });
        
         $('#select_all').click(function () {
            if (this.checked)
            {
                $('.grid_checkbox').each(function () {
                    this.checked = true;
                });
            } else
            {
                $('.grid_checkbox').each(function () {
                    this.checked = false;
                });
            }
        });
        
       $('#btndeleteall').on("click", function () {
            var checkValues = $('.grid_checkbox:checked').map(function ()
            {
                return $(this).val();
            }).get();
            if (checkValues.length != 0)
            {
                alertify.confirm("Are you sure to delete " + checkValues.length + " record?", function (e) {
                    if (e)
                    {
                        $('#frm_sessions_fm').attr('action', '<?= base_url() ?>admin/sessions/alldelete/' + checkValues);
                        $('#frm_sessions_fm').submit();
                        return true;
                    }
                });
            } else
            {
                alertify.error('Select any record for delete!');
                return false;
            }
            return false;
        });


        $("#sessions_table").dataTable({
            "ordering": false,
        });

        $('.datepicker').datepicker();
    });
</script>