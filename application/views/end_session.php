<style>
    .jumbotron{
        width: 900px;
        margin: 50px auto;
        text-align: center;
        max-width: 100%;
    }
    .jumbotron p{
     width: 100%;
    }
    .jumbotron h2{
               font-size: 45px;
    }

    .jumbotron .lounge{
        color: black;
        font-weight: 500;
    }.jumbotron .lounge a{
             font-weight: bold;
             text-decoration: underline !important;
    }

</style>
<div class="container">
    <div class="jumbotron">
        <h2>Thank you, this session is now closed</h2>
        <p>Please return to the Sessions Page. <br> If you would like to continue the conversation, please navigate to the Networking Lounge.</p>
        <p class="lounge">You can visit <a href="<?=base_url()."lounge"?>">lounge</a></p>
        <p style="font-size: 25px">OR</p>
        <p><a class="btn btn-primary btn-lg" href="<?=base_url()."sessions"?>" role="button">Go Sessions</a></p>
    </div>
</div>