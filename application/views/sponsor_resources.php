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
<section class="parallax fullscreen" style="background-image: url(<?= base_url() ?>front_assets/images/expo_background.jpg); top: 20; padding-top: 20px;">
    <div class="container">

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
                foreach ($resources as $val){
                    ?>
                    <tr>
                        <td><img src="<?= base_url() ?>uploads/sponsors/<?= $val["sponsors_logo"] ?>" alt="welcome"></td>
                        <td><?=$val["item_name"]?></td>
                        <td><?=$val["file_name"]?></td>
                        <td><a href="<?= base_url() ?>front_assets/sponsor/resources/<?=$val["file_name"]?>" download type="button" class="btn btn-info btn-sm">Download</a></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</section>