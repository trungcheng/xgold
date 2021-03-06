<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box" style="min-height:65px;">
                <div class="pull-left">
                    <h4 class="page-title">WITHDRAW CONFIRM TEMPLATE</h4>                    
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

            <p style="color:red;margin-bottom:20px;">Note: These values "xxx@gmail.com!", "xxx" and "http://link" does not change.</p>
            
            <form id="form_profile" action="<?= base_url('mail/updateWithdraw') ?>" method="post">

                <div class="form-group">
                    <label class="control-label" for="member-address">From Name</label>
                    <input placeholder="From name..." type="text" class="form-control" name="from" value="<?= $temp->from ?>"><div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="member-address">Subject</label>
                    <input placeholder="Subject..." type="text" class="form-control" name="subject" value="<?= $temp->subject ?>"><div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="member-address">Content</label>
                    <textarea placeholder="Content to send..." name="content"><?= $temp->content ?></textarea>
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
    CKEDITOR.replace('content');
</script>