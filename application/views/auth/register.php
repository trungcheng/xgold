<div class="box-register account-box">                                   
    <div class="clearfix"></div>
    <div class="sign_title_box text-center">
        <h5 class="text-uppercase font-bold m-b-5 m-t-50">SIGN UP</h5>
    </div>
    <div class="account-content">
        <?php if (validation_errors()) { ?>
            <div class="alert alert-danger alert-result">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-result"><?= $this->session->flashdata('error') ?></div>
        <?php } ?>
        <form class="form-horizontal" action="<?= base_url('auth/actionCreate') ?>" method="post">
            <input type="hidden" name="_method" value="">
            <input type="hidden" name="_csrf" value="GT0jsN59nH_ItgLoCYeJGz7f2-EySS6miH0IJWcJRth3Tmn-rAv-NP7DUqFDz8xUbpGu1msiZtGlCHlRHVk3kQ==">

            <div class="form-group m-b-20">
                <div class="col-xs-12 col-lg-6">
                    <div class="icon_before icon_before_all">
                        <input type="text" id="registerform-email" class="form-control" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <div class="icon_before_place icon_before_all">
                        <input type="text" id="address" class="form-control" name="address" placeholder="Address">
                    </div>
                </div>
            </div>

            <div class="form-group m-b-20">
                <div class="col-xs-12 col-lg-6">
                    <div class="icon_before2 icon_before_all">        
                        <input type="password" id="registerform-password" class="form-control" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <div class="icon_before2 icon_before_all">
                        <input type="password" id="registerform-retypepassword" class="form-control" name="retypePassword" placeholder="Retype password">
                    </div>
                </div>
            </div>

            <div class="form-group m-b-20">
                <div class="col-xs-12 col-lg-6">
                    <div class="icon_before_phone icon_before_all">
                        <input type="text" id="registerform-phone" class="form-control" name="phone" placeholder="Phone">                                              
                    </div>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <div class="icon_before_username icon_before_all">
                        <input type="text" id="registerform-sponsor" class="form-control" name="sponsor" placeholder="Sponsor ID" value="<?= isset($sponsor) ? $sponsor : '' ?>">
                    </div>
                </div>
            </div>

            <div class="form-group m-b-20">
                <div class="col-xs-12 col-lg-6">
                    <input placeholder="Enter captcha..." class="form-control col-md-6" type="text" required name="captcha" value="" />
                </div>
                <div class="col-xs-12 col-lg-6">
                    <p id="captImg">
                        <?= $image ?>
                        <i class="fa fa-refresh refreshCaptcha" title="Refresh captcha image"></i>
                    </p>
                </div>
            </div>

            <div class="form-group m-b-20">
                <div class="col-xs-12">
                    <div class="checkbox checkbox-success">
                        <input id="remember" type="checkbox" checked="">
                        <label for="remember">
                            I agree with Terms of Services
                        </label>
                    </div>
                </div>
            </div>

            <div class="alert alert-danger" style="display:none"><p>Please fix the following errors:</p><ul></ul></div>
            <div class="form-group text-center m-t-10">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-md btn-block btn-custom waves-effect waves-light">SIGN UP</button>                                            
                </div>
            </div>

        </form>

        <div class="row m-t-20">
            <div class="col-sm-12 text-center">
                <p class="text-muted">Already have an account? <a href="<?= base_url('auth/login') ?>" class="text-dark m-l-5"><b>Sign In</b></a></p>
                <a href="<?php echo base_url('auth/forgotpwd') ?>" class="text-dark m-l-5">Forgot your password?</a>
            </div>
        </div>

    </div>
</div>
</div>
<!-- end card-box-->

