<div class="main-content">
    <div class="wrap-content container" id="container">
        <!-- start: DYNAMIC TABLE -->
        <div class="container-fluid container-fullw">
            <div class="row">
                <div class="panel panel-primary" id="panel5">
                    <div class="panel-heading">
                        <h4 class="panel-title text-white">Resources Download Tracking</h4>
                    </div>
                    <div class="panel-body bg-white" style="border: 1px solid #b2b7bb!important;">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped text-center" id="user">
                                    <thead class="th_center">
                                        <tr>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Item Name</th>
                                            <th>File Name</th>
                                            <th>IP Address</th>
                                            <th>Operating System</th>
                                            <th>Browser</th>
                                            <th>Date Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($resources_download_tracking) && !empty($resources_download_tracking)) {
                                            foreach ($resources_download_tracking as $val) {
                                                ?>
                                                <tr>
                                                    <td><?= $val->first_name . ' ' . $val->last_name ?></td>
                                                    <td><?= $val->email ?></td>
                                                       <td><?= $val->resources_title ?></td>
                                                       <td><?= $val->resources_file_name ?></td>
                                                    <td><?= $val->ip_address ?></td>
                                                    <td><?= $val->operating_system ?></td>
                                                    <td><?= $val->computer_type ?></td>
                                                    <td><?= date("Y-m-d h:i:s", strtotime($val->date_time)) ?></td>
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
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#user").dataTable({
            "ordering": false,
        });
    });
</script>








