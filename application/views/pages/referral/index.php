<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box">
                <div class="pull-left">
                    <h4 class="page-title">REFERRAL</h4>                                    
                    <div class="clearfix"></div>
                    <p class="m-t-10 m-b-0 hidden-xs">Your reward amounts to 5.0% of all TKC tokens purchased by your referrals.</p>
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
        <div class="col-md-12">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30">Your referral link:</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input id="referral_text" readonly="" type="text" class="form-control" value="http://member.tekycorp.com/ref/levanluong.html">
                            <span id="referral_copy" class="input-group-addon copy_addon btn btn-primary" style="cursor: pointer" >COPY</span>
                        </div>
                        <div class="buy-tkc-button m-t-20">
                            <a href="<?= base_url('dashboard/index') ?>" class="btn btn-custom waves-light waves-effect w-md">BUY TKC NOW</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-top-10 alert alert-info alert-dismissible fade in" role="alert">
                            This is your TKC referral link. You can use it to share the project with your friends and other interested parties. If any of them sign up with this link, they will be added to your referral program. 
                        </div>
                    </div>
                </div>                                    
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0 dis_inline header-title m-b-20"><b>Your referral member:</b></h4>
                <div id="w0" class="grid-view">
                    <div class="form-inline m-b-20 pull-right">
                        <div class="row">
                            <div class="col-sm-12 text-xs-center text-right">
                                <div class="form-group">
                                    <label class="control-label m-r-5"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <table class="table table-striped table-bordered toggle-circle m-b-0">
                        <thead>
                            <tr>
                                <th>
                                    <a href="/referral/index?sort=name" data-sort="name">Name</a>
                                </th>
                                <th>
                                    <a href="/referral/index?sort=email" data-sort="email">Email</a>
                                </th>
                                <th>
                                    <a href="/referral/index?sort=joinTime" data-sort="joinTime">Join Time</a>
                                </th>
                                <th>Referral Bonus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4">
                                    <div class="empty">No results found.</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-sm-12 hidden-xs">
            <div class="card-box">
                <h4 class="m-t-0 dis_inline header-title m-b-20"><b>Referral transaction:</b></h4>
                <div id="w1" class="grid-view">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Buy detail 
                                    <div class="pull-right"><b>TKC delivery detail</b></div>
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr>
                                <td colspan="1"><div class="empty">No results found.</div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>