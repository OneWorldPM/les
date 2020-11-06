<link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<?php
if (isset($loungereport) && !empty($loungereport)) {
    $unique_list = [];
    foreach ($loungereport as $val) {
        $unique_list[] = $val->id;
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
                    <h1 class="mainTitle">Lounge Report</h1>
                </div>
            </div>
        </section>
        <!-- end: PAGE TITLE -->
        <!-- start: DYNAMIC TABLE -->
        <div class="container-fluid container-fullw">
            <div class="row">
                <div class="panel panel-primary" id="panel5">
                    <div class="panel-body bg-white" style="border: 1px solid #b2b7bb!important;">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="example" class="table table-bordered table-striped text-center ">
                                    <thead class="th_center">
                                        <tr>
                                            <th>Topic</th>
                                            <th>Meeting From</th>
                                            <th>Meeting To</th>
                                            <th>Host Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($loungereport) && !empty($loungereport)) {
                                            foreach ($loungereport as $val) {
                                                ?>
                                                <tr>
                                                    <td><?= $val->topic ?></td>
                                                    <td><?= date("Y-m-d h:i:s", strtotime($val->meeting_from)) ?></td>
                                                    <td><?= date("Y-m-d h:i:s", strtotime($val->meeting_to)) ?></td>
                                                    <td><?= $val->host_name ?></td>
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

