<!DOCTYPE html>
<html lang="en" data-ng-app="Xgold">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-param" content="_csrf">
        <meta name="csrf-token" content="d0chSEubJ8HssoqhYutZwvS1Bk5Wr6QgyZP4OGQnDdoZNGsGOe1FitrH2ugooxyNpPtzeQ_E7Ffk5olMHnd8kw==">
        
        <title><?= $pageName ?> | Xgold</title>

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
                Copyright © 2018. Teky Corp. All Rights Reserved.
            </footer>    
        </div>

        <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
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
        <script src="<?php echo base_url(); ?>assets/js/angular/angular-animate.min.js"></script>
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

        <script src="<?php echo base_url(); ?>assets/js/app.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/utils.js"></script>
        
        <script type="text/javascript">
            $(function () {
                var baseUrl = window.location.origin + window.location.pathname;
                if (baseUrl.indexOf('video') !== -1 || 
                    baseUrl == 'http://kinglive.dev/' || 
                    baseUrl == 'http://kinghub.vn/kinglive/') {
                        $('.videoLink').addClass('current-page');
                }
                if (baseUrl.indexOf('category') !== -1) {
                    $('.categoryLink').addClass('current-page');
                }
                if (baseUrl.indexOf('emotion') !== -1) {
                    $('.emotionLink').addClass('current-page');
                }
                $('.alert').delay(2000).fadeOut();
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
            })
            
            function getFormDataEvaluation(form) {
                var data = {};
                var obj_data = $(form).serializeArray();
                for (var i = 0; i < obj_data.length; i++){
                    var record = obj_data[i];
                    data[record.name] = record.value;
                }

                return data;
            }

            function changeToSlug(title) {
                //Đổi chữ hoa thành chữ thường
                var slug = title.toLowerCase();
             
                //Đổi ký tự có dấu thành không dấu
                slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
                slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
                slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
                slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
                slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
                slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
                slug = slug.replace(/đ/gi, 'd');
                //Xóa các ký tự đặt biệt
                slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
                //Đổi khoảng trắng thành ký tự gạch ngang
                slug = slug.replace(/ /gi, "-");
                //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
                //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
                slug = slug.replace(/\-\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-/gi, '-');
                slug = slug.replace(/\-\-/gi, '-');
                //Xóa các ký tự gạch ngang ở đầu và cuối
                slug = '@' + slug + '@';
                slug = slug.replace(/\@\-|\-\@|\@/gi, '');

                return slug;
            }

            function trimText(str, wordCount) {
                var strArray = str.split(' ');
                var subArray = strArray.slice(0, wordCount);
                var result = subArray.join(" ");
                return result + '...';
            }

        </script>

    </body>
</html>