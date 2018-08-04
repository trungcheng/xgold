<div class="container">
    
    <div class="row">
	    <div class="col-xs-12">
	        <div class="page-title-box">
	            <div class="pull-left">
	                <h4 class="page-title">PROFILE</h4>                                    
	                <div class="clearfix"></div>
	            </div>
                <?php if (validation_errors()) { ?>
                    <div style="width:35%;position:absolute;left:25%;text-align:center;z-index:99999" class="alert alert-danger alert-result">
                        <?php echo validation_errors(); ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div style="width:35%;position:absolute;left:25%;text-align:center;z-index:99999" class="alert alert-danger alert-result">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('success')) { ?>
                    <div style="width:35%;position:absolute;left:25%;text-align:center;z-index:99999" class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                <?php } ?>
	            <div class="pull-right price_box">
	                <p>
	                    <i class="mdi mdi-gift"></i> Total BGC: <span><b><?= $tokenCount ?></b> BGC</span>
	                </p>
	                <!--<p class="text-right">
	                    <a href="#" class="color_blue">Withdraw</a> BGC to MyEtherwallet
	                </p>-->
	            </div>
	        </div>
	    </div>
	</div>

	<div class="row">
	    <div class="col-xs-12"></div>
	</div>        
	
	<div class="row">
        <div class="col-md-4">
            <!-- Personal-Information -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="img-center text-center">
                        <p class="text-muted font-13">
                            <img src="<?= $avatar ?>" alt="" class="thumb-lg img-circle" style="cursor:pointer;">
                            <input type="file" id="avatar" class="hide" accept="image/*" />
                        </p>
                        <h3 class="panel-title m-t-20"><?= $user_id ?></h3>
                        <span><?= ($is_admin) ? '(Admin)' : '(Member)' ?></span>
                    </div>
                    <hr>
                    <div class="text-left">
                        <p class="text-muted font-13">
                            <strong>BGC</strong><span class="m-l-15 pull-right"><?= $tokenCount ?></span>
                        </p>
                        <p class="text-muted font-13">
                            <strong>Email</strong><span class="m-l-15 pull-right"><?= $email ?></span>
                        </p>
                        <p class="text-muted font-13">
                            <strong>Phone</strong><span class="m-l-15 pull-right"><?= $mobile ?></span>
                        </p>
                        <p class="text-muted font-13">
                            <strong>Address</strong><span class="m-l-15 pull-right"><?= $address ?></span>
                        </p>
                    </div>                                       
                </div>
            </div>
            <!-- Personal-Information -->
        </div>

        <div class="col-md-8">
            <div class="card-box">
                <ul class="nav nav-tabs tabs-bordered">
                    <li class="">
                        <a href="<?= base_url('profile') ?>" >
                            <span class="visible-xs"><i class="fa fa-user"></i></span>
                            <span class="hidden-xs">My Profile</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="<?= base_url('profile/password') ?>">
                            <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                            <span class="hidden-xs">Change Password</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="profile-b1">
                        
                        <form id="form_profile" action="<?= base_url('profile/changePassword') ?>" method="post">
							<input type="hidden" name="_csrf" value="QQ1fvT5Rvvm66YSfpjfIPvEoGPpkudhOn8lsb4bDIl8WaTrpVTT11OuP6aefXaN8tEV_yTzfthzmgCAiq_sVKg==">

							<div class="form-group field-passwordform-oldpass required">
								<div class="form-group">
	                                <label class="col-md-4 control-label"><label class="control-label" for="passwordform-oldpass">Current password</label></label>
	                                <div class="col-md-8">
	                                    <input type="password" id="passwordform-oldpass" class="form-control" name="Password[oldpass]" aria-required="true"><div class="help-block"></div>
	                                </div>
	                            </div>
							</div>

							<div class="form-group field-passwordform-newpass required">
								<div class="form-group">
	                                <label class="col-md-4 control-label"><label class="control-label" for="passwordform-newpass">New password</label></label>
	                                <div class="col-md-8">
	                                    <input type="password" id="passwordform-newpass" class="form-control" name="Password[newpass]" aria-required="true"><div class="help-block"></div>
	                                </div>
	                            </div>
							</div>                            

							<div class="form-group field-passwordform-repeatnewpass required">
								<div class="form-group">
	                                <label class="col-md-4 control-label"><label class="control-label" for="passwordform-repeatnewpass">Re-password</label></label>
	                                <div class="col-md-8">
	                                    <input type="password" id="passwordform-repeatnewpass" class="form-control" name="Password[confirmnewpass]" aria-required="true"><div class="help-block"></div>
	                                </div>
	                            </div>
							</div>

							<div class="form-group m-t-30">
	                            <div class="col-md-12" style="margin-top:30px;">
	                                <button type="submit" class="btn btn-custom waves-effect waves-light change-pass-btn"><i class="fa fa-edit" ></i> Change password</button>
	                                <button style="margin-left:0px;width:40%;" type="reset" class="btn btn-default btn-reset waves-effect waves-light"><i style="margin-left:-20px;" class="glyphicon glyphicon-refresh" ></i> Reset</button>
	                            </div>
                        	</div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>

</div> <!-- container -->

<script type="text/javascript">
    $(function() {
        $('.img-circle').click(function() {
            $(this).next().trigger("click");      
        });
    });
    $(document).on("change", "#avatar", function(evt) {
        var file = evt.currentTarget.files;
        if (file.length > 0) {
            if (file[0].type.match(/image.*/)) {
                var fd = new FormData();
                fd.append("image", file[0]);
                $.ajax({
                    url: "<?php echo base_url('profile/uploadAvatar') ?>",
                    method: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    success: function(res) {
                        var res = JSON.parse(res);
                        if (res.status) {
                            $('.img-circle').attr('src', res.image);
                            toastr.success(res.message, 'SUCCESS');
                        } else {
                            toastr.error(res.message, 'ERROR');
                        }
                    }
                });
            } else {
                toastr.error('File chưa đúng định dạng ảnh!', 'ERROR');
            }
        }
    });
</script>
