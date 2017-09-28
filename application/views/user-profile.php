<?php require('header.php') ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/profil.css">
<body>
    <div class="container">
        <a href="<?php echo site_url(); ?>/home/dashboard">
            <img src="<?php echo base_url(); ?>/assets/images/logo-itdc.png" class="logo-itdc">
        </a>
        <hr>
        <div class="row" style="position:relative">
        <?php foreach ($userdata as $userd) { 
            if ($userd->level != 1) { ?>
                <a href="<?php echo site_url(); ?>/user/edit?username=<?php echo $userd->username; ?>" class="btn btn-primary edit">EDIT</a>
            <?php
            }
            ?>            
            <h3 style="margin-top:10px;text-align:center">PROFIL</h3>
            <div class="col-md-3">            
                <div class="img-box">
                <?php 
                if (file_exists($_SERVER['DOCUMENT_ROOT']."/banditrpm/assets/user_images/".$userd->avatar.".jpg")) {
                    ?>
                    <img src="<?php echo base_url(); ?>assets/user_images/<?php echo $userd->avatar; ?>.jpg" id="user-avatar">
                    <?php
                } else {
                 ?>
                 <img src="<?php echo base_url(); ?>assets/images/default-pp.jpg" id="user-avatar">
                 <?php 
                 }?>      
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-2" style="text-align:left">USERNAME:</label>
                        <div class="col-sm-10">
                            <input readonly="true" name="username" type="text" class="form-control" placeholder="Enter Username..." value="<?php echo $userd->username;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" style="text-align:left">NAME:</label>
                        <div class="col-sm-10">
                            <input readonly="true" name="nama" type="text" class="form-control" placeholder="Enter Name..." value="<?php echo $userd->nama_user;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" style="text-align:left">PASSWORD:</label>
                        <div class="col-sm-10">
                            <input readonly="true" name="password" type="text" class="form-control" placeholder="Enter Password..." value="<?php echo $userd->password;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" style="text-align:left">AUTHORISASI:</label>
                        <div class="col-sm-10">
                        <input readonly="true" name="password" type="text" class="form-control" placeholder="Enter Password..." value="<?php 
                        if ($userd->level == 1) {
                            echo 'Admin';
                        }
                        elseif($userd->level == 2){
                            echo "User Debit";
                        }
                        else
                            echo "User Kredit";
                        ?>">                        
                        </div>
                    </div>
                    <?php
                } ?>
                </div>
            </div>
        </div>    
    </div>
    <?php require('user-action.php') ?>
</body>
<?php require('footer.php') ?>
</html>
