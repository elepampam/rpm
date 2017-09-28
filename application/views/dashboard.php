<?php require('header.php') ?>
<style type="text/css">
    .efaktur-ico img{
        width: 70px;
        height: 70px;
    }
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 relative-box-left">
                <div class="dashboard-left">
                    <a href="<?php echo site_url(); ?>/home/dashboard">
                        <img src="<?php echo base_url(); ?>/assets/images/logo-itdc.png" class="logo-itdc">
                    </a>
                    <p class="dashboard-desc">
                        Selamat Datang di Aplikasi RPM V 2.1. <br>
                        Gunakan Aplikasi ini untuk mencatat Pajak Masukan, Mengkreditkan Pajak Masukan, dan melakukan Rekonsiliasi Pajak Masukan.
                    </p>
                    <p>integrated with : 
                        <a href="https://efaktur.pajak.go.id" class="efaktur-ico" target="blank"><img src="<?php echo base_url();?>/assets/images/efaktur.png"></a>
                        <a href="https://scan.barcodefaktur.com" class="efaktur-ico" target="blank"><img src="<?php echo base_url();?>/assets/images/efaktur-scann.png"></a>
                    </p>
                </div>
            </div>
            <?php
            if ($user['level'] == 1) {
                require('dashboard-action-admin.php');
            }
            elseif ($user['level'] == 2) {
                require('dashboard-action-debit.php');
            }
            else
                require('dashboard-action-kredit.php');
            
            ?>
        </div>
    </div>
    <?php require('user-action.php') ?>
</body>

<?php require('footer.php') ?>