<div class="account-box">                               
    <div class="clearfix"></div>
    <div class="sign_title_box text-center">
        <h5 class="text-uppercase font-bold m-b-5 m-t-50">SIGN IN</h5>
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
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-result">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
        <?php } ?>
        <form class="form-horizontal" action="<?php echo base_url('auth/doLogin') ?>" method="post">
            <input type="hidden" name="_method" value="">
            <input type="hidden" name="_csrf" value="TQWaZnr9to6bBnDKxHikQfhZLNcuqgltkXuBcvfa7S0jdtAoCIvUxa1zIIOOMOEOqBdZ4HfBQRq8DvAGjYqcZA==">
            <div class="form-group m-b-20">
                <div class="col-xs-12">
                    <div class="icon_before">
                        <input name="email" class="form-control" type="email" id="emailaddress" required="" placeholder="Your email or username">
                    </div>
                </div>
            </div>

            <div class="form-group m-b-20">
                <div class="col-xs-12">
                    <div class="icon_before2">
                        <input name="password" class="form-control" type="password" required="" id="password" placeholder="Your password">
                    </div>
                </div>
            </div>

            <div class="form-group text-center m-t-10">
                <div class="col-xs-12">
                    <button class="btn btn-md btn-block btn-custom waves-effect waves-light" type="submit">SIGN IN</button>
                </div>
            </div>

        </form>

        <div class="row m-t-20">
            <div class="col-sm-12 text-center">
                <p class="text-muted">Don't have an account? <a href="<?php echo base_url('auth/register') ?>" class="text-dark m-l-5"><b>Sign Up</b></a></p>
                <a href="<?php echo base_url('auth/forgotpwd') ?>" class="text-dark m-l-5">Forgot your password?</a>
            </div>
        </div>

    </div>
</div>