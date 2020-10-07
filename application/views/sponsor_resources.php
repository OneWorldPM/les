<style>
    thead tr th{
        text-align: center;
    }
    tbody tr td{
        text-align: center;
    }
    .files{
        width: 1000px;
        max-width: 100%;
        margin: 0 auto;
    }
</style>
<section class="parallax">
    <div class="container">

        <div class="files well">
            <table class="table">
                <thead>
                <tr>
                    <th>Item Name</th>
                    <th>File Name</th>
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($resources as $val){
                    ?>
                    <tr>
                        <td><?=$val["item_name"]?></td>
                        <td><?=$val["file_name"]?></td>
                        <td><a href="<?= base_url() ?><?=$val["file_name"]?>" download type="button" class="btn btn-info btn-sm">Download</a></td>
                    </tr>
                    <?php
                }
                ?>


                </tbody>
            </table>
        </div>
    </div>
</section>