<!DOCTYPE html>
<html lang="en" data-ng-app="Bitgame">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-param" content="_csrf">
        <meta name="csrf-token" content="d0chSEubJ8HssoqhYutZwvS1Bk5Wr6QgyZP4OGQnDdoZNGsGOe1FitrH2ugooxyNpPtzeQ_E7Ffk5olMHnd8kw==">
        
        <title><?= $pageName ?> | Bitgame</title>

        <link href="<?php echo base_url(); ?>assets/v2/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap SweetAlert Style -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css" />
        <!-- Toaster Notify Style -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
        
        <link href="<?php echo base_url(); ?>assets/v2/css/core.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/v2/css/components.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/v2/css/icons.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/v2/css/pages.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/v2/css/menu.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/v2/css/responsive.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/main_v2.css" rel="stylesheet">

        <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>

    </head>

    <body class="bg-accpunt-pages">

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="wrapper-page">
                            <div class="account-pages col-md-6 col-md-offset-3">
                                <div class="account-logo-box">
                                    <div class="pull-left">
                                        <h2 class="text-uppercase text-center">
                                            <a href="/" class="text-success">
                                                <span style="color:#64c5b1">BITGAME</span>
                                            </a>
                                        </h2> 
                                    </div>
                                    <div class="pull-right p-t-20 login_right_in">
                                        <ul class="list-inline">
                                            <li class="signup"><a href="<?= base_url('auth/register') ?>">Sign Up</a></li>
                                            <li class="signin active"><a href="<?= base_url('auth/login') ?>">Sign In</a></li>
                                        </ul>
                                    </div>                                       
                                </div>
                                <?= $auth_contents ?>
                            </div>
                            <!-- end card-box-->
                        </div>
                        <!-- end wrapper -->
                    </div>
                </div>
            </div>
        </section>
        <!-- END HOME -->

        <script src="<?php echo base_url(); ?>assets/js/yii.js"></script>
        <script src="<?php echo base_url(); ?>assets/v2/js/modernizr.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/v2/js/bootstrap.min.js"></script>

        <!-- Bootstrap SweetAlert Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
        <!-- Toaster Notify Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/v2/js/metisMenu.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/v2/js/waves.js"></script>
        <script src="<?php echo base_url(); ?>assets/v2/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url(); ?>assets/v2/js/jquery.core.js"></script>
        <script src="<?php echo base_url(); ?>assets/v2/js/jquery.app.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/angular/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-sanitize.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/angular-animate.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/angular-messages.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/angular-ui-bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/qrcode.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/angular-qr.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/angular-moment.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/ngclipboard.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/ng-sortable.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/md5.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/bootbox.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/countdown.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/angular/app.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/utils.js"></script>

        <script type="text/javascript">
            $(function () {
                var baseUrl = window.location.origin + window.location.pathname;
                $('.login_right_in ul li').removeClass('active');
                if (baseUrl.indexOf('login') !== -1) {
                    $('.signin').addClass('active');
                }
                if (baseUrl.indexOf('register') !== -1) {
                    $('.signup').addClass('active');
                }
                if (baseUrl.indexOf('forgotpwd') !== -1) {
                    $('.signup').addClass('active');
                }
            });
            $(document).on('click', '.refreshCaptcha', function () {
                $.get('<?php echo base_url().'auth/refreshCaptcha'; ?>', function(data) {
                    var response = JSON.parse(data);
                    $('#captImg').html(response.data);
                    $('#captImg').append('<i style="font-size:18px;margin-left:10px;cursor:pointer;" class="fa fa-refresh refreshCaptcha"></i>');
                });
            });
        </script>
        
    </body>
</html>