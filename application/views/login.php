<style>
    @media (min-width: 300px) and (max-width: 768px)  {
        #tiada_members{
            margin-left: 0px;
        }
        #tiada_non_members{
            margin-left: 0px;  
        }
        .fullscreen{
            height: 1000px !important;
        }
    }

    @media (min-width: 768px) and (max-width: 100000px)  {
        #tiada_members{
            margin-left: 440px;
        }
        #tiada_non_members{
            margin-left: 28px;  
        }
    }
</style>
<!-- SECTION -->
<section class="parallax fullscreen" style="background-image: url(<?= base_url() ?>front_assets/images/tiada.jpg); top: 0; padding-top: 0px;">
    <div class="container container-fullscreen" style="margin-top: 20px;">
        <div class="text-middle">
            <div class="row">
                <div class="col-md-4 col-xs-12 col-sm-12 center p-50 background-white" style="border-radius: 10px; margin-top: 180px; ">
                    <div class="row">
                        <h4>Welcome Back!</h4>
                        <p>Sign in Below</p>
                        <?php
                        echo ($this->session->flashdata('msg')) ? $this->session->flashdata('msg') : '';
                        ?> 
                        <form id="login-form" name="frm_login" method="post" action="<?= base_url() ?>login/authentication">
                            <div class="form-group">
                                <label class="sr-only">Username</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Username">
                                <span id="erroremail" style="color:red"></span>
                            </div>
                            <div class="form-group m-b-5">
                                <label class="sr-only">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                <span id="errorpassword" style="color:red"></span>
                            </div>
                            <div class="form-group form-inline text-left ">
                                <a href="<?= base_url() ?>forgotpassword" class="right"><small>Forgot Password?</small></a>
                            </div>
                            <div class="text-left form-group">
                                <button type="submit" id="btn_login" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        $("#btn_login").on("click", function () {
            if ($("#email").val().trim() == "") {
                $("#erroremail").text("Please Enter Username").fadeIn('slow').fadeOut(5000);

                return false;
            } else if ($("#password").val() == "") {
                $("#errorpassword").text("Please Enter Password").fadeIn('slow').fadeOut(5000);
                return false;
            } else {
                return true; //submit form
            }
            return false; //Prevent form to submitting
        });
    });
</script>
