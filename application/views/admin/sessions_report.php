<style>
    #example_wrapper .dt-buttons .buttons-csv{
        background-color: #1fbba6;
        padding: 5px 15px 5px 15px;
    }
</style>
<div class="main-content">
    <div class="wrap-content container" id="container">
        <!-- start: PAGE TITLE -->
        <section id="page-title">
            <div class="row">
                <div class="col-sm-8">
                    <h1 class="mainTitle">List Of Sessions Report</h1>
                </div>
            </div>
        </section>
        <!-- end: PAGE TITLE -->
        <!-- start: DYNAMIC TABLE -->
        <div class="container-fluid container-fullw">
            <div class="row">
                <div class="panel panel-primary" id="panel5">
                    <div class="panel-heading">
                        <h4 class="panel-title text-white">Sessions Report</h4>
                    </div>
                    <div class="panel-body bg-white" style="border: 1px solid #b2b7bb!important;">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped text-center " id="example">
                                    <thead class="th_center">
                                        <tr>
                                            <th>Date</th>
                                            <th>Presenter</th>
                                            <th>User</th>
                                            <th>Phone Number</th>
                                            <th>Company</th>
                                            <th>City</th>
                                            <th>Session Title</th>
                                            <th>Question</th>
                                            <th>Answer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($sessions_report) && !empty($sessions_report)) {
                                            foreach ($sessions_report as $val) {
                                                ?>
                                                <tr>
                                                    <td><?= date("Y-m-d", strtotime($val->reg_question_date)) ?></td>
                                                    <td><?= $val->presenter_name ?></td>
                                                    <td><?= $val->first_name . " " . $val->last_name ?></td>
                                                    <td><?= $val->phone ?></td>
                                                    <td><?= $val->company_name ?></td>
                                                    <td><?= $val->city ?></td>
                                                    <td><?= $val->session_title ?></td>
                                                    <td><?= $val->question ?></td>
                                                    <td><?= $val->answer ?></td>
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
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#example").dataTable({
            "dom": 'Bfrtip',
            "buttons": [
                'csv'
            ],
        });
        $('.buttons-csv').text('Export CSV');
    });
</script>