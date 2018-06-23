<?php 
    $user_info = $this->session->userdata('ci_seesion_key');
?>
 
<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu nav" id="side-menu">
                <li class="menu-title">Navigation</li>
                <li>
                    <a  href="<?= base_url('dashboard') ?>">
                        <i class="fi-air-play"></i> 
                        <span> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('ico') ?>"><i class="mdi mdi-cash-usd"></i> <span> ICO </span></a>
                </li>

                <li>
                    <a href="javascript: void(0);"><i class="mdi mdi-cash-usd"></i> <span> Finance </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level collapse" aria-expanded="false">
                        <li><a href="<?= base_url('finance/wallet/bitcoin') ?>">Bitcoin Wallet</a></li>
                        <li><a href="<?= base_url('finance/wallet/ethereum') ?>">Ethereum Wallet</a></li>
                        <li><a href="<?= base_url('finance/wallet/litecoin') ?>">Litecoin Wallet</a></li>
                        <li><a href="<?= base_url('finance/wallet/bitcoin-cash') ?>">Bitcoin Cash Wallet</a></li>
                    </ul>
                </li>

                <li>
                    <a href="<?= base_url('referral') ?>"><i class="fi-target"></i> <span> Referrals </span></a>
                </li>
                <?php
                if ($user_info['is_admin']) {
                ?>
                <li>
                    <a href="<?= base_url('event') ?>"><i class="mdi mdi-calendar"></i> <span> Events </span></a>
                </li>
                <li>
                    <a href="<?= base_url('user') ?>"><i class="mdi mdi-account-multiple"></i> <span> Users </span></a>
                </li>
                <li>
                    <a href="<?= base_url('setting') ?>"><i class="mdi mdi-settings"></i> <span> Setting </span></a>
                </li>
                <li>
                    <a href="<?= base_url('statistical') ?>"><i class="mdi mdi-chart-bar"></i> <span> Statistical </span></a>
                </li>
                <?php
                }
                ?>
                <li>
                    <a href="<?= base_url('profile') ?>"><i class="mdi mdi-account-settings"></i> <span> Profile </span></a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->  