<link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<?php
if (isset($user_activity_tracking) && !empty($user_activity_tracking)) {
    $unique_list = [];
    foreach ($user_activity_tracking as $val) {
        $unique_list[] = $val->cust_id;
    }

    $unique_list = array_unique($unique_list);
}
?>
<style>
    #example_wrapper .dt-buttons .buttons-csv{
        background-color: #1fbba6;
        padding: 5px 15px 5px 15px;
    }
</style>
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

    .modal-dialog-xl {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .modal-content-xl {
        height: auto;
        min-height: 100%;
        border-radius: 0;
    }

    #tracking-info-table_info{
        font-weight: bold;
    }
</style>

<div class="main-content">
    <div class="wrap-content container" id="container">
        <!-- start: PAGE TITLE -->
        <section id="page-title">
            <div class="row">
                <div class="col-sm-8">
                    <h1 class="mainTitle">User Tracking</h1>
                </div>
            </div>
        </section>
        <!-- end: PAGE TITLE -->
        <!-- start: DYNAMIC TABLE -->
        <div class="container-fluid container-fullw">
            <div class="row">
                <div class="panel panel-primary" id="panel5">
                    <div class="panel-heading">
<!--                        <span style="font-size: 20px;font-weight: bold;margin-right: 90px;">Sum of visits: --><?//=sizeof($booth_tracking)?><!--</span>-->
<!--                        <span style="font-size: 20px;font-weight: bold;margin-right: 90px;">Number of unique visitors: --><?//=sizeof($unique_list)?><!--</span>-->
                    </div>
                    <div class="panel-body bg-white" style="border: 1px solid #b2b7bb!important;">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="example" class="table table-bordered table-striped text-center ">
                                    <thead class="th_center">
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Phone No.</th>
                                            <th>Email</th>
                                            <th>City</th>
                                            <th>Date & Time</th>
                                            <th>Page</th>
                                            <th>Link</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($user_activity_tracking) && !empty($user_activity_tracking)) {
                                            foreach ($user_activity_tracking as $val) {
                                                ?>
                                                <tr>
                                                    <td><?= $val->first_name . ' ' . $val->last_name ?></td>
                                                    <td><?= $val->phone ?></td>
                                                    <td><?= $val->email ?></td>
                                                    <td><?= $val->city ?></td>
                                                    <td><?= date("Y-m-d h:i:s", strtotime($val->activity_date_time)) ?></td>
                                                    <td><?= $val->page_name ?></td>
                                                    <td><a href="<?= $val->page_link ?>" target="_blank"><?= $val->page_link ?></a></td>
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

<script>
    $(document).ready(function () {

        $('#example thead th').each(function () {
            var title = $(this).text();
            $(this).html('<b>' + title + '</b><br><input type="text" placeholder="Search ' + title + '" />');
        });
        var trackingTable = $('#example').DataTable({
            "order": [[6, "desc"]],
            "dom": 'Bfrtip',
            "buttons": [
                'csv'
            ],
            initComplete: function () {
                // Apply the search
                this.api().columns().every(function () {
                    var that = this;

                    $('input', this.header()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that
                                    .search(this.value)
                                    .draw();
                        }
                    });
                });
            }
        });
        $('.buttons-csv').text('Export CSV');
    });
</script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

