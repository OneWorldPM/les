<div class="main-content" >
    <div class="wrap-content container" id="container">
        <form name="frm_credit" id="frm_credit" method="POST" action="" enctype="multipart/form-data">
            <div class="container-fluid container-fullw bg-white">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-primary" id="panel5">
                            <div class="panel-heading">
                                <h4 class="panel-title text-white">Add Presentation Resources</h4>
                            </div>
                            <div class="panel-body bg-white" style="border: 1px solid #b2b7bb;">
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="form-group">
                                            <label class="text-large">Presentation Title:</label>
                                            <input type="text" name="title" id="title" placeholder="Presentation Title" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-large">Select File:</label>
                                            <input type="file" name="resources_file" id="resources_file" class="form-control" accept=".pdf">
                                        </div>
                                        <h5 class="over-title margin-bottom-15">
                                            <button type="button" id="save_presentation" name="save_presentation" class="btn btn-green add-row">
                                                Submit
                                            </button>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">                     
                    <div class="col-md-12">
                        <div class="panel panel-light-primary" id="panel5">
                            <div class="panel-heading">
                                <h4 class="panel-title text-white">Presentation</h4>
                            </div>
                            <div class="panel-body bg-white" style="border: 1px solid #b2b7bb;">
                                <span id="errortxtsendemail" style="color:red;"></span>
                                <h5 class="over-title margin-bottom-15 margin-top-5">Presentation<span class="text-bold"></span></h5>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-full-width" id="plan_table">
                                        <thead>
                                            <tr>
                                                <th>Presentation Title</th>
                                                <th>File</th>
                                                <th>Action</th>                      
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($presentation)) {
                                                foreach ($presentation as $val) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $val->title ?></td>
                                                        <td>
                                                            <h6 class="panel-title">
                                                                <i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i>
                                                                <span style="font-size: 20px;"> <?= $val->resources_file ?> </span>
                                                            </h6>
                                                        </td>
                                                        <td> 
                                                            <a href="<?= base_url() ?>uploads/presentation_resources/<?= $val->resources_file ?>" download="" type="button" class="btn btn-info btn-sm">Download</a>
                                                          <!--  <a href="<?= base_url() ?>uploads/presentation_resources/<?= $val->resources_file ?>" target="_black" type="button" class="btn btn-success btn-sm">Open</a>-->
                                                            <a href="<?= base_url() ?>admin/presentation/delete_presentation/<?= $val->presentation_resources_id ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
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
                        </div>
                    </div>
                </div>
            </div>
        </form>   
        <!-- end: DYNAMIC TABLE -->
    </div>
</div>

</div>

<?php
$msg = $this->input->get('msg');
switch ($msg) {
    case "S":
        $m = "Presentation Resources Added Successfully...!!!";
        $t = "success";
        break;
    case "U":
        $m = "Presentation Resources Updated Successfully...!!!";
        $t = "success";
        break;
    case "D":
        $m = "Presentation Resources Delete Successfully...!!!";
        $t = "success";
        break;
    case "E":
        $m = "Something went wrong, Please try again!!!";
        $t = "error";
        break;
    default:
        $m = 0;
        break;
}
?>

<script>
    $(document).ready(function () {

<?php if ($msg): ?>
            alertify.<?= $t ?>("<?= $m ?>");
<?php endif; ?>

        $('#plan_table').dataTable({
            "aaSorting": []
        });

        $('#save_presentation').click(function () {
            if ($('#title').val() == '') {
                alertify.error('Please Enter Title');
                return false;
            } else if ($('#resources_file').val() == '') {
                alertify.error('Select File');
                return false;
            } else {
                $('#frm_credit').attr('action', '<?= base_url() ?>admin/presentation/add_presentation');
                $('#frm_credit').submit();
                return true;
            }
        });

    });

</script>









