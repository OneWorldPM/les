<link href="<?= base_url() ?>assets/lounge/lounge.css?v=<?= rand(200, 300) ?>" rel="stylesheet">
<style>
    .removeMessage{
        font-size: 20px;
        cursor: pointer;
    }
    .removeMessage:hover{
        color: #2c5da8;
    }
    .panel-body {
        height: 660px;
    }
</style>
<div class="main-content">
    <div class="wrap-content container" id="container">
        <div class="panel panel-danger panel-cco">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Attendee Group Chat
                </h3>
            </div>
            <div id="grp-chat-body" class="panel-body">
                <ul class="group-chat">
                    <?php
                    foreach ($chats as $chat) {
                        ?>
                        <li class="grp-chat left clearfix">
                            <div class="pull-left removeMessage" data-id="<?=$chat["id"]?>"><i class="fa fa-times-circle" aria-hidden="true"></i></div>
                   <span class="chat-img pull-left">

                    <img src="" onerror="this.src=&quot;https://placehold.it/50/067290/fff&amp;&quot;" alt="User Avatar" class="img-circle">

                   </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font pull-left"><?= $chat["user_name"] ?></strong>
                                </div>
                                <br>
                                <p class="pull-left"><?=$chat["message"]?></p>
                            </div>
                        </li>
                        <?php
                    }
                    ?>

                </ul>
            </div>

        </div>

    </div>
</div>


<script>
    $('#grp-chat-body').scrollTop($('#grp-chat-body')[0].scrollHeight);


    $(".removeMessage").click(function () {
        var sessionId=$(this).data("id");

        var row=$(this).parent();
        alertify.confirm('Do you want to delete this message?', function (e) {
            if (e) {
                $.post("<?=base_url()?>admin/Attendee_Chat/deleteMessage",{"sessionId":sessionId},function (response) {

                    if(response=="success"){
                        row.remove();
                    }
                })

            }
        })

    })


</script>






