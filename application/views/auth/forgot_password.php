<div class="account-box">                                   
    <div class="clearfix"></div>
    <div class="sign_title_box text-center">
        <h5 class="text-uppercase font-bold m-b-5 m-t-50">Input your email address to reset password</h5>
    </div>
    <div class="account-content">
        <?php if (validation_errors()) { ?>
            <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <?php if (!empty($this->input->get('msg')) && $this->input->get('msg') == 1) { ?>
            <div class="alert alert-danger">
                Please Enter Your Valid Information.
            </div>
        <?php } elseif (!empty($this->input->get('msg')) && $this->input->get('msg') == 2) { ?>
            <div class="alert alert-success">
                Your password has been reset successfully. Please check your email.
            </div>
        <?php } ?>
        <form class="form-horizontal" action="<?= base_url('auth/actionForgotPassword') ?>" method="post">
            <input type="hidden" name="_method" value="">
            <input type="hidden" name="_csrf" value="lbs_WHNQvUofDCHG_0NgLiUlmv1KEU-t6czTsBrhr3H7yHUWASbfASl5cY-1CyVhdWvvyhN6B9rEuaLEYLHeOA==">
            
            <div class="form-group m-b-20">
                <div class="col-xs-12 col-lg-12">
                    <div class="icon_before icon_before_all">
                        <input class="form-control" name="email"  type="email" id="emailaddress" required="" placeholder="Email" />
                    </div>
                </div>
            </div>

            <div class="form-group text-center m-t-10">
                <div class="col-xs-12">
                    <button class="btn btn-md btn-block btn-custom waves-effect waves-light" type="submit">SUBMIT</button>
                </div>
            </div>

        </form>  

        <div class="row m-t-20">
            <div class="col-sm-12 text-center">
                <p class="text-muted">Don't have an account? <a href="<?php echo base_url('auth/register') ?>" class="text-dark m-l-5"><b>Sign Up</b></a></p>
            </div>
        </div>

    </div>
</div>
<!-- end card-box-->
