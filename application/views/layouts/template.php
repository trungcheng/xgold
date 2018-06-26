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
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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

        <!-- <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script> -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        
    </head>

    <body>

        <div id="wrapper">

            <?= include('top_navbar.php') ?>

            <?= include('left_sidebar.php') ?>

            <div class="content-page">
                <div class="content">
                    <?= $contents ?>            
                </div>
            </div>

            <footer class="footer text-right">
                Copyright © 2018. Bitgame Team. All Rights Reserved.
            </footer>    
        </div>

        <script src="<?php echo base_url(); ?>assets/js/yii.js"></script>
        <script src="<?php echo base_url(); ?>assets/v2/js/modernizr.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/v2/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
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
        <!-- <script src="<?php echo base_url(); ?>assets/js/angular/angular-ui-bootstrap.min.js"></script> -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.14.3/ui-bootstrap-tpls.min.js"></script>
        
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

        <script src="<?php echo base_url(); ?>assets/js/angular/controllers/user.controller.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/controllers/event.controller.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/controllers/ico.controller.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/controllers/referral.controller.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/controllers/statistical.controller.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/angular/controllers/finance.controller.js"></script>

        <script type="text/javascript">
            $(function () {
                $('.alert-result').delay(3000).fadeOut();
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
            });
            $(document).on('click', '#referral_copy', function() {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($('#referral_text').val()).select();
                document.execCommand("copy");
                $temp.remove();
                toastr.success('Copied', 'SUCCESS');
            });

            function enablePass() {
                var x = document.getElementById("passwordSender");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
            function formatDate(num) {
                if (num.toString().length == 1) num = '0'+num;
                return num;
            }
        </script>

    </body>
</html>