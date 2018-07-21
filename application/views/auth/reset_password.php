<div class="account-box">                                   
    <div class="clearfix"></div>
    <div class="sign_title_box text-center">
        <h5 class="text-uppercase font-bold m-b-5 m-t-50">Input your new password to reset</h5>
    </div>
    <div class="account-content">
        <?php if (validation_errors()) { ?>
            <div class="alert alert-danger alert-result">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <?php if (!empty($this->input->get('msg')) && $this->input->get('msg') == 1) { ?>
            <div class="alert alert-danger alert-result">
                Email invalid or not existed! Or maybe have been a problem in change password process. Please try again!
            </div>
        <?php } elseif (!empty($this->input->get('msg')) && $this->input->get('msg') == 2) { ?>
            <div class="alert alert-success alert-result">
                Your password has been reset successfully!
            </div>
        <?php } ?>
        <form class="form-horizontal" action="<?= base_url('auth/actionChangePwd') ?>" method="post">
            <input type="hidden" name="_method" value="">
            <input type="hidden" id="email" name="email" value="">
            <input type="hidden" id="usid" name="usid" value="">
            <input type="hidden" name="_csrf" value="lbs_WHNQvUofDCHG_0NgLiUlmv1KEU-t6czTsBrhr3H7yHUWASbfASl5cY-1CyVhdWvvyhN6B9rEuaLEYLHeOA==">
            
            <div class="form-group m-b-20">
                <div class="col-xs-12 col-lg-12">
                    <div class="icon_before2 icon_before_all">
                        <input class="form-control" name="newpassword"  type="password" id="newpassword" required="" placeholder="Your new password" />
                    </div>
                </div>
            </div>

            <div class="form-group m-b-20">
                <div class="col-xs-12 col-lg-12">
                    <div class="icon_before2 icon_before_all">
                        <input class="form-control" name="cfnewpassword"  type="password" id="cfnewpassword" required="" placeholder="Repeat your new password" />
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
                <p class="text-muted">Remember password already ? <a href="<?php echo base_url('auth/login') ?>" class="text-dark m-l-5"><b>Sign In</b></a></p>
            </div>
        </div>

    </div>
</div>
<!-- end card-box-->

<script type="text/javascript">
    $(function () {
        $('#email').val(getParameterByName('m'));
        $('#usid').val(getParameterByName('usid'));
    });
</script>
