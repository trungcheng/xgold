<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box" style="min-height:65px;">
                <div class="pull-left">
                    <h4 class="page-title">PROFILE</h4>                    
                    <div class="clearfix"></div>
                </div>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div style="width:35%;position:absolute;left:25%;text-align:center" class="alert alert-danger alert-result">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('success')) { ?>
                    <div style="width:35%;position:absolute;left:25%;text-align:center" class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                <?php } ?>
                <div class="pull-right price_box">
                    <p>
                        <i class="mdi mdi-gift"></i> Your TKC Balance: <span><b><?= $tokenCount ?></b> TKC</span>
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
                            <img src="<?= $avatar ?>" alt="" class="thumb-lg img-circle">
                        </p>
                        <h3 class="panel-title m-t-20"><?= $user_id ?></h3>
                        <span><?= ($is_admin) ? '(Admin)' : '(Member)' ?></span>
                    </div>
                    <hr>
                    <div class="text-left">
                        <p class="text-muted font-13">
                            <strong>TKC</strong><span class="m-l-15 pull-right"><?= $tokenCount ?></span>
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
                        
                        <form id="form_profile" action="<?= base_url('profile/updateInfo') ?>" method="post">
                            <input type="hidden" name="_csrf" value="J0grpYWA6UWSyGSQaQhBt6ajKyp4PqP5PIrNppHxKJlwLE7x7uWiaMOuCahQYir1485MGSBYzatFw4HrvMkf7A==">

                            <div class="form-group field-member-phone" style="line-height:35px;">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-phone">Xgold ID</label></label>
                                    <div class="col-md-8">
                                        <input readonly type="text" id="member-phone" class="form-control" value="<?= $user_id ?>"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group field-member-phone" style="line-height:35px;">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-phone">Sponsor</label></label>
                                    <div class="col-md-8">
                                        <input readonly type="text" id="member-phone" class="form-control" value="<?= isset($sponsor) ? $sponsor : '' ?>"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group field-member-phone" style="line-height:35px;">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-phone">Email</label></label>
                                    <div class="col-md-8">
                                        <input readonly type="text" id="member-phone" class="form-control" value="<?= $email ?>"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group field-member-phone" style="line-height:35px;">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-phone">Phone</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-phone" class="form-control" name="Profile[phone]" value="<?= $mobile ?>"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group field-member-address" style="line-height:35px;">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-address">Address</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-address" class="form-control" name="Profile[address]" value="<?= $address ?>"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>                      
                            
                            <!-- <div class="form-group field-member-tkcaddress">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-tkcaddress">Your address to receive TKC</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-tkcaddress" class="form-control" name="Coin[xgoldAddr]" value="<?php ($coinAddr['coin_type'] == 'xgold') ? $coinAddr['coin_addr'] : '' ?>"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="form-group">
                                <div class="col-md-8 col-md-offset-4 m-t-20">
                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                        You have to use here your personal Ethereum wallets like MyEtherWallet, Metamask, Parity, Mist, imToken, Ledger (hardware wallet) or ask support about your wallet. WARNING NOT SUPPORTED: Coinbase wallet, all wallets from exchanges, Free Ethereum Wallet for Android.
                                    </div>
                                </div>
                            </div>   -->

                            <!-- <?php
                                foreach ($coinAddr as $coin) {
                                    ?>
                                    <div class="form-group field-member-ethaddress" style="line-height:35px;">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">
                                                <label style="font-size:13px;" class="control-label"><?= $coin['coin_name'] ?> address
                                                </label>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="Coin[<?= $coin['coin_type'] ?>]" value="<?= $coin['coin_addr'] ?>"><div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div> 
                                    <?php
                                }
                            ?>  -->                        
                        
                            <!-- <div class="form-group field-member-ethaddress">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-ethaddress">ETH address to contribute</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-ethaddress" class="form-control" name="Coin[ethAddr]" value="<?php ($coinAddr['coin_type'] == 'eth') ? $coinAddr['coin_addr'] : '' ?>"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>                            

                            <div class="form-group field-member-btcaddress">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-btcaddress">BTC address to contribute</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-btcaddress" class="form-control" name="Coin[btcAddr]" value="<?php ($coinAddr['coin_type'] == 'btc') ? $coinAddr['coin_addr'] : '' ?>"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>                            

                            <div class="form-group field-member-ltcaddress">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-ltcaddress">LTC address to contribute</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-ltcaddress" class="form-control" name="Coin[ltcAddr]" value="<?php ($coinAddr['coin_type'] == 'ltc') ? $coinAddr['coin_addr'] : '' ?>"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group field-member-usdtaddress">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><label class="control-label" for="member-usdtaddress">USDT address to contribute</label></label>
                                    <div class="col-md-8">
                                        <input type="text" id="member-usdtaddress" class="form-control" name="Coin[usdtAddr]" value="<?php ($coinAddr['coin_type'] == 'usdt') ? $coinAddr['coin_addr'] : '' ?>"><div class="help-block"></div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="form-group m-t-30">
                                <div class="col-md-12" style="margin-top:30px;">
                                    <button type="submit" class="btn btn-custom waves-effect waves-light profile-btn"><i class="fa fa-edit" ></i> Update</button>
                                    <button style="margin-left:0px" type="reset" class="btn btn-default btn-reset waves-effect waves-light"><i class="glyphicon glyphicon-refresh" ></i> Reset</button>
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