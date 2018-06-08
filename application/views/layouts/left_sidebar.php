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
                    <a  href="/buy/index">
                        <i class="fi-air-play"></i> 
                        <span> Buy TKC </span>
                    </a>
                </li>
                <li>
                    <a href="/referral/index"><i class="fi-target"></i> <span> Referral Bonus </span></a>
                </li>
                <li>
                    <a href="/profile/index"><i class="mdi mdi-account-settings"></i> <span> My Profile </span></a>
                </li>
                <li>
                    <a href="/site/logout"><i class="mdi mdi-logout"></i> <span> Logout </span></a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->  