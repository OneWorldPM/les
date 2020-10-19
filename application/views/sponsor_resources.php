<style>
    thead tr th{
        text-align: center;
    }
    tbody tr td{
        text-align: center;
    }
    .files{
        width: 1300px;
        max-width: 100%;
        margin: 0 auto;
    }
    .files img{
        object-fit: contain;
        width: 90px;
        height: 70px;
    }
    .files td{
        vertical-align: middle !important;
    }
</style>
<section class="parallax" style="background-image: url(<?= base_url() ?>front_assets/images/expo_background.jpg); top: 20; padding-top: 20px;">
    <div class="container" style="min-height: 1000px;">
        <h3 style="margin-bottom: 15px; margin-left: 0px; color: #000; font-weight: 700; text-transform: uppercase; text-align: center;">The Greenblum and Bernstein Resource Library</h3>
        <div class="files well">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sponsor</th>
                        <th>Item Name</th>
                        <th>File Name</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($resources as $val) {
                        ?>
                        <tr>
                            <td><img src="<?= base_url() ?>uploads/sponsors/<?= $val["sponsors_logo"] ?>" alt="welcome"></td>
                            <td><?= $val["item_name"] ?></td>
                            <td><?= $val["file_name"] ?></td>
                            <td><a href="<?= base_url() ?>front_assets/sponsor/resources/<?= $val["file_name"] ?>" download type="button" data-resources_file="<?= $val["item_name"] ?>" data-resources_title="<?= $val["file_name"] ?>" class="btn btn-info btn-sm download_btn">Download</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <br>
        <div class="files well">
            <h2 style="text-align: center;">Resources</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Presentation Title</th>
                        <th>File Name</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($presentation_resources) && !empty($presentation_resources)) {
                        foreach ($presentation_resources as $val) {
                            ?>
                            <tr>
                                <td><?= $val->title ?></td>
                                <td><?= $val->resources_file ?></td>
                                <td>
                                    <a href="<?= base_url() ?>uploads/presentation_resources/<?= $val->resources_file ?>"  download="" type="button" data-resources_file="<?= $val->resources_file ?>" data-resources_title="<?= $val->title ?>" class="btn btn-info btn-sm download_btn">Download</a>
                                    <!--<a href="<?= base_url() ?>uploads/presentation_resources/<?= $val->resources_file ?>" target="_black" type="button" class="btn btn-success btn-sm">Open</a>-->
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
</section>
<script type="text/javascript">
    $(document).ready(function () {
        $('.download_btn').click(function (event) {
           var resources_file_name = $(this).attr("data-resources_file");
           var resources_title = $(this).attr("data-resources_title");
            $.ajax({
                url: "<?= base_url() ?>sponsor/add_resources_activity",
                type: "post",
                data: {'resources_file_name':resources_file_name,'resources_title':resources_title},
                dataType: "json",
                success: function (data) {
                }
            });
        });
    });
</script>