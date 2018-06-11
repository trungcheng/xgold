<?php 
    $user_info = $this->session->userdata('ci_seesion_key');
?>
 
<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metisMenu nav" id="side-menu">
                <li class="menu-title">Navigation</li>
                <li>
                    <a  href="<?= base_url('dashboard') ?>">
                        <i class="fi-air-play"></i> 
                        <span> Dashboard </span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('referral') ?>"><i class="fi-target"></i> <span> Referral </span></a>
                </li>
                <li>
                    <a href="<?= base_url('user/profile') ?>"><i class="mdi mdi-account-settings"></i> <span> My Profile </span></a>
                </li>
                <li>
                    <a href="<?= base_url('auth/logout') ?>"><i class="mdi mdi-logout"></i> <span> Logout </span></a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->  