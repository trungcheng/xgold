<div class="container">
    
    <div class="row">
	    <div class="col-xs-12">
	        <div class="page-title-box">
	            <div class="pull-left">
	                <h4 class="page-title">PROFILE</h4>                                    
	                <div class="clearfix"></div>
	            </div>
	            <div class="pull-right price_box">
	                <p>
	                    <i class="mdi mdi-gift"></i> Your TKC Balance: <span><b>0</b> TKC</span>
	                </p>
	                <!--<p class="text-right">
	                    <a href="#" class="color_blue">Withdraw</a> TKC to MyEtherwallet
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
                            <img src="<?= base_url() ?>assets/v2/images/users/no-avatar.jpg" alt="" class="thumb-lg img-circle">
                        </p>
                        <h3 class="panel-title m-t-20">Personal Information</h3>
                    </div>
                    <hr>
                    <div class="text-left">
                        <p class="text-muted font-13">
                            <strong>TKC</strong><span class="m-l-15 pull-right">0</span>
                        </p>
                        <p class="text-muted font-13">
                            <strong>Username</strong><span class="m-l-15 pull-right">levanluong</span>
                        </p>
                        <p class="text-muted font-13">
                            <strong>Phone</strong><span class="m-l-15 pull-right">0984661545</span>
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
                        
                        <form id="form_profile" action="/profile/password" method="post">
							<input type="hidden" name="_csrf" value="QQ1fvT5Rvvm66YSfpjfIPvEoGPpkudhOn8lsb4bDIl8WaTrpVTT11OuP6aefXaN8tEV_yTzfthzmgCAiq_sVKg==">

							<div class="form-group field-passwordform-oldpass required">
								<div class="form-group">
	                                <label class="col-md-4 control-label"><label class="control-label" for="passwordform-oldpass">Current password</label></label>
	                                <div class="col-md-8">
	                                    <input type="password" id="passwordform-oldpass" class="form-control" name="PasswordForm[oldpass]" aria-required="true"><div class="help-block"></div>
	                                </div>
	                            </div>
							</div>

							<div class="form-group field-passwordform-newpass required">
								<div class="form-group">
	                                <label class="col-md-4 control-label"><label class="control-label" for="passwordform-newpass">New password</label></label>
	                                <div class="col-md-8">
	                                    <input type="password" id="passwordform-newpass" class="form-control" name="PasswordForm[newpass]" aria-required="true"><div class="help-block"></div>
	                                </div>
	                            </div>
							</div>                            

							<div class="form-group field-passwordform-repeatnewpass required">
								<div class="form-group">
	                                <label class="col-md-4 control-label"><label class="control-label" for="passwordform-repeatnewpass">Re-password</label></label>
	                                <div class="col-md-8">
	                                    <input type="password" id="passwordform-repeatnewpass" class="form-control" name="PasswordForm[repeatnewpass]" aria-required="true"><div class="help-block"></div>
	                                </div>
	                            </div>
							</div>

							<div class="form-group m-t-30">
	                            <div class="col-md-12">
	                                <button type="submit" class="btn btn-custom waves-effect waves-light"><i class="fa fa-edit" ></i> Change password</button>
	                                <a class="btn btn-default btn-reset waves-effect waves-light" href="/profile/password"><i class="glyphicon glyphicon-refresh" ></i> Reset</a>
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
