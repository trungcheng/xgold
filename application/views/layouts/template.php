<!DOCTYPE html>
<html lang="en" data-ng-app="Xgold">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?= $pageName; ?> | Xgold</title>

        <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">
	    <!-- Google Fonts -->
	    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
		<!-- Bootstrap Core Css -->
    	<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
		<!-- Waves Effect Css -->
    	<link href="<?php echo base_url(); ?>assets/plugins/node-waves/waves.css" rel="stylesheet" />
		<!-- Animation Css -->
    	<link href="<?php echo base_url(); ?>assets/plugins/animate-css/animate.css" rel="stylesheet" />
	    <!-- Morris Chart Css-->
    	<link href="<?php echo base_url(); ?>assets/plugins/morrisjs/morris.css" rel="stylesheet" />
	    <!-- Custom Css -->
	    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
	    <!-- Materialize Css -->
	    <link href="<?php echo base_url(); ?>assets/css/materialize.css" rel="stylesheet">
	    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
	    <link href="<?php echo base_url(); ?>assets/css/themes/all-themes.css" rel="stylesheet" />
	    <!-- Jquery Core Js -->
    	<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    </head>

    <body class="theme-red">

    	<!-- <?= $contents; ?> -->

        <!-- Jquery CountTo Plugin Js -->
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-countto/jquery.countTo.js"></script>
        <!-- Morris Plugin Js -->
        <script src="<?php echo base_url(); ?>assets/plugins/raphael/raphael.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/morrisjs/morris.js"></script>
        <!-- ChartJs -->
        <script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.bundle.js"></script>
        <!-- Flot Charts Plugin Js -->
        <script src="<?php echo base_url(); ?>assets/plugins/flot-charts/jquery.flot.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/flot-charts/jquery.flot.resize.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/flot-charts/jquery.flot.pie.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/flot-charts/jquery.flot.categories.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/flot-charts/jquery.flot.time.js"></script>
        <!-- Sparkline Chart Plugin Js -->
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-sparkline/jquery.sparkline.js"></script>
        <!-- Custom Js -->
        <script src="<?php echo base_url(); ?>assets/js/pages/index.js"></script>
        <!-- end-->     

        <!-- Bootstrap Core Js -->
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.js"></script>
        <!-- Select Plugin Js -->
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
        <!-- Slimscroll Plugin Js -->
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
        <!-- Waves Effect Plugin Js -->
        <script src="<?php echo base_url(); ?>assets/plugins/node-waves/waves.js"></script>
        <!-- Custom Js -->
        <script src="<?php echo base_url(); ?>assets/js/admin.js"></script>
        <!-- Demo Js -->
        <script src="<?php echo base_url(); ?>assets/js/demo.js"></script>
        
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