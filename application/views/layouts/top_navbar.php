<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <a href="/" class="logo">
            <span>
                <img src="<?php echo base_url(); ?>assets/v2/images/logo.png" alt="" height="25">
            </span>
            <i>
                <img src="<?php echo base_url(); ?>assets/v2/images/logo_sm.png" alt="" height="28">
            </i>
        </a>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Navbar-left -->
            <ul class="nav navbar-nav navbar-left nav-menu-left">
                <li>
                    <button type="button" class="button-menu-mobile open-left waves-effect">
                        <i class="dripicons-menu"></i>
                    </button>
                </li>
                <li class="dropdown hidden-xs mega-menu icon-nav-left">
                    <a href="tel:+84938690253" class="waves-effect waves-light"><i class="mdi mdi-phone-settings"></i> (+84) 938 690 253</a>
                </li>

                <li class="dropdown hidden-xs icon-nav-left">
                    <a href="/cdn-cgi/l/email-protection#56353938223735221622333d2f353924267835393b" class="waves-effect waves-light"><i class="mdi mdi-email-outline"></i> <span class="__cf_email__" data-cfemail="bfdcd0d1cbdedccbffcbdad4c6dcd0cdcf91dcd0d2">admin@xgold.vn</span></a>                                
                </li>
            </ul>
            <!-- Right(Notification) -->
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if (!empty($messages)) {
                        ?>
                        <li class="dropdown user-box" style="width:600px;height:40px;margin-top:15px;line-height:40px;color:#fff;">
                            <marquee direction="left"><?= implode(' ************** ', $messages) ?></marquee>
                        </li>
                        <?php
                    }
                ?>
                <li class="dropdown user-box">
                    <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                        <span class="color-white m-r-10"></span> <img src="<?php echo base_url(); ?>assets/v2/images/users/no-avatar.jpg" alt="user-img" class="img-circle user-img">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                        <li><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                        <li><a href="<?= base_url('referral') ?>">Referral</a></li>
                        <li><a href="<?= base_url('profile') ?>">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?= base_url('auth/logout') ?>">Logout</a></li>
                    </ul>
                </li>
            </ul> <!-- end navbar-right -->
        </div><!-- end container -->
    </div><!-- end navbar -->
</div>
<!-- Top Bar End -->