<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box" style="min-height:65px;">
                <div class="pull-left">
                    <h4 class="page-title">GENERAL SETTING</h4>                    
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
        <div class="col-md-6 col-md-offset-3">
			
        	<form id="form_profile" action="<?= base_url('setting/update') ?>" method="post">
                
                <div class="form-group">
                    <label class="control-label" for="member-phone">Affiliate bonus (%)</label>
                    <input type="text" id="member-phone" class="form-control" name="Setting[aff_bonus]" value="<?= isset($setting[0]['aff_bonus']) ? $setting[0]['aff_bonus'] : '' ?>"><div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="member-address">BTC rate</label>
                    <input type="text" class="form-control" name="Setting[btc_rate]" value="<?= isset($setting[0]['btc_rate']) ? $setting[0]['btc_rate'] : '' ?>"><div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="member-address">ETH rate</label>
                    <input type="text" class="form-control" name="Setting[eth_rate]" value="<?= isset($setting[0]['eth_rate']) ? $setting[0]['eth_rate'] : '' ?>"><div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="member-address">LTC rate</label>
                    <input type="text" class="form-control" name="Setting[ltc_rate]" value="<?= isset($setting[0]['ltc_rate']) ? $setting[0]['ltc_rate'] : '' ?>"><div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="member-address">BCH rate</label>
                    <input type="text" class="form-control" name="Setting[bch_rate]" value="<?= isset($setting[0]['bch_rate']) ? $setting[0]['bch_rate'] : '' ?>"><div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="member-address">SMTP Username</label>
                    <input type="text" class="form-control" name="Setting[mail_sender]" value="<?= isset($setting[0]['mail_sender']) ? $setting[0]['mail_sender'] : '' ?>"><div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="member-address">SMTP Password</label>
                    <input id="passwordSender" style="position:relative;" type="password" class="form-control" name="Setting[pass_mail_sender]" value="<?= isset($setting[0]['pass_mail_sender']) ? $setting[0]['pass_mail_sender'] : '' ?>">
                    <i onclick="enablePass()" style="position:absolute;right:25px;margin-top:-25px;cursor:pointer" class="fa fa-eye"></i>
                    <div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="member-address">Withdraw fee (%)</label>
                    <input type="text" class="form-control" name="Setting[withdraw_fee]" value="<?= isset($setting[0]['withdraw_fee']) ? $setting[0]['withdraw_fee'] : '' ?>"><div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="member-address">Notification</label>
                    <textarea name="Setting[notification]" class="form-control"><?= isset($setting[0]['notification']) ? $setting[0]['notification'] : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label class="control-label" for="member-address">Link API (for withdraw token)</label>
                    <input type="text" class="form-control" name="Setting[link_api]" value="<?= isset($setting[0]['link_api']) ? $setting[0]['link_api'] : '' ?>"><div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="member-address">Contract address (for withdraw token)</label>
                    <input type="text" class="form-control" name="Setting[contract_addr]" value="<?= isset($setting[0]['contract_addr']) ? $setting[0]['contract_addr'] : '' ?>"><div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="member-address">From address (for withdraw token)</label>
                    <input type="text" class="form-control" name="Setting[from_addr]" value="<?= isset($setting[0]['from_addr']) ? $setting[0]['from_addr'] : '' ?>"><div class="help-block"></div>
                </div>

                <div class="form-group pull-right">
                	<button type="submit" class="btn btn-primary">Update</button>
                	<button type="reset" class="btn btn-default">Cancel</button>
                </div>

            </form>

        </div>
    </div>

</div> <!-- container -->

<script type="text/javascript">
    // CKEDITOR.replace('register_temp');
    // CKEDITOR.replace('reset_temp');
    // CKEDITOR.replace('withdraw_temp');
</script>