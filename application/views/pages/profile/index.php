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
                    <li class="active">
                        <a href="<?= base_url('profile') ?>" >
                            <span class="visible-xs"><i class="fa fa-user"></i></span>
                            <span class="hidden-xs">My Profile</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?= base_url('profile/password') ?>" >
                            <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                            <span class="hidden-xs">Change Password</span>
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active" id="profile-b1">
                        
                        <form id="form_profile" action="/profile/index" method="post">
                            <input type="hidden" name="_csrf" value="J0grpYWA6UWSyGSQaQhBt6ajKyp4PqP5PIrNppHxKJlwLE7x7uWiaMOuCahQYir1485MGSBYzatFw4HrvMkf7A==">
                            <div class="form-group field-member-name">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-name">Name</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-name" class="form-control" name="Member[name]"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group field-member-phone">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-phone">Phone</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-phone" class="form-control" name="Member[phone]" value="0984661545"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>                      
                            
                            <div class="form-group field-member-tkcaddress">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-tkcaddress">Your address to receive TKC</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-tkcaddress" class="form-control" name="Member[tkcAddress]"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4 m-t-20">
                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                        You have to use here your personal Ethereum wallets like MyEtherWallet, Metamask, Parity, Mist, imToken, Ledger (hardware wallet) or ask support about your wallet. WARNING NOT SUPPORTED: Coinbase wallet, all wallets from exchanges, Free Ethereum Wallet for Android.
                                    </div>
                                </div>
                            </div>                           
                        
                            <div class="form-group field-member-ethaddress">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-ethaddress">ETH address to contribute</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-ethaddress" class="form-control" name="Member[ethAddress]"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>                            

                            <div class="form-group field-member-btcaddress">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-btcaddress">BTC address to contribute</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-btcaddress" class="form-control" name="Member[btcAddress]"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>                            

                            <div class="form-group field-member-ltcaddress">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-ltcaddress">LTC address to contribute</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-ltcaddress" class="form-control" name="Member[ltcAddress]"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group field-member-usdtaddress">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-usdtaddress">USDT address to contribute</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-usdtaddress" class="form-control" name="Member[usdtAddress]"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group m-t-30">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-custom waves-effect waves-light"><i class="fa fa-edit" ></i> Update</button>                                    <a class="btn btn-default btn-reset waves-effect waves-light" href="/profile/index"><i class="glyphicon glyphicon-refresh" ></i> Reset</a>
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