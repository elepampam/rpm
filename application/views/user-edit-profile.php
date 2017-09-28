<?php require('header.php') ?>
<style type="text/css">
    .error-message p{
        margin: 5px;
        color: red;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/profil.css">
<body>
	<div class="container">
	   	   <a href="<?php echo site_url(); ?>/home/dashboard">
            <img src="<?php echo base_url(); ?>/assets/images/logo-itdc.png" class="logo-itdc">
        </a>
        <hr>
        <div class="row" style="position:relative">
            <h3 style="margin-top:10px;text-align:center">EDIT USER</h3>
            <!-- open foreach -->
            <?php foreach ($userdata as $userd) { ?>
            <div class="col-md-3">
                <div class="img-box">
                    <?php 
                    if (isset($error['value']['avatar'])) {
                        $userd->avatar = $error['value']['avatar'];
                    }
                    if (file_exists($_SERVER['DOCUMENT_ROOT']."/banditrpm/assets/user_images/".$userd->avatar.".jpg")) {
                        ?>
                        <img src="<?php echo base_url(); ?>assets/user_images/<?php echo $userd->avatar; ?>.jpg" id="user-avatar">
                        <?php
                    } else {
                     ?>
                     <img src="<?php echo base_url(); ?>assets/images/default-pp.jpg" id="user-avatar">
                     <?php 
                     }?>
                     <div class="dropdown dropdown-btn">
                          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fa fa-camera-retro" aria-hidden="true"></i>
                                <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li><span class="avatar" data-avatar="avatar1">Male 1</span></li>
                            <li><span class="avatar" data-avatar="avatar4">Male 2</span></li>
                            <li><span class="avatar" data-avatar="avatar6">Male 3</span></li>
                            <li><span class="avatar" data-avatar="avatar8">Male 4</span></li>
                            <li><span class="avatar" data-avatar="avatar10">Male 5</span></li>
                            <li><span class="avatar" data-avatar="avatar12">Male 6</span></li>
                            <li><span class="avatar" data-avatar="avatar2">Female 1</span></li>
                            <li><span class="avatar" data-avatar="avatar3">Female 2</span></li>                            
                            <li><span class="avatar" data-avatar="avatar5">Female 3</span></li>                            
                            <li><span class="avatar" data-avatar="avatar7">Female 4</span></li>                            
                            <li><span class="avatar" data-avatar="avatar9">Female 5</span></li>                            
                            <li><span class="avatar" data-avatar="avatar11">Female 6</span></li>
                          </ul>
                    </div>   
                </div>
            </div>
            <div class="col-md-8">
                <?php echo form_open('user/editprofile?username='.$userd->username,['class' => 'form-horizontal']); ?>
                        <input type="hidden" name="avatar" id="avatar" value="<?php echo $userd->avatar;?>";">
                        <div class="form-group">
                            <label class="control-label col-sm-2" style="text-align:left">USERNAME:</label>
                            <div class="col-sm-10">
                                <input name="username" type="text" class="form-control" placeholder="Enter Username..." value="<?php 
                                if (isset($error['value']['username'])) {
                                    echo $error['value']['username'];
                                }
                                else
                                    echo $userd->username;?>">
                                <?php if (isset($error['message']['username'])) { ?>
                                    <span class="error-message"><?php echo $error['message']['username'];?></span>
                                <?php }?>                                
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" style="text-align:left">NAME:</label>
                            <div class="col-sm-10">
                                <input name="nama" type="text" class="form-control" placeholder="Enter Name..." value="<?php 
                                if (isset($error['value']['nama'])) {
                                    echo $error['value']['nama'];
                                }
                                else
                                    echo $userd->nama_user;?>">
                                <?php if (isset($error['message']['nama'])) { ?>
                                    <span class="error-message"><?php echo $error['message']['nama'];?></span>
                                <?php }?>                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" style="text-align:left">PASSWORD:</label>
                            <div class="col-sm-10">
                                <input name="password" type="text" class="form-control" placeholder="Enter Password..." value="<?php 
                                if (isset($error['value']['password'])) {
                                    echo $error['value']['password'];
                                }
                                else
                                    echo $userd->password;?>">
                                <?php if (isset($error['message']['password'])) { ?>
                                    <span class="error-message"><?php echo $error['message']['password'];?></span>
                                <?php }?>                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" style="text-align:left">AUTHORISASI:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="level" <?php if($userd->level != 1) echo "disabled"; ?>>
                                <?php if (isset($error['value']['level'])) {
                                    $userd->level = $error['value']['level'];
                                }?>
                                    <option value="1" <?php if($userd->level == 1) echo "selected";?> >Admin</option>
                                    <option value="2" <?php if($userd->level == 2) echo "selected";?> >User Debit</option>
                                    <option value="3" <?php if($userd->level == 3) echo "selected";?> >User Kredit</option>
                                </select>
                            </div>
                        </div>
                        <?php
                    } ?>
                    <!-- end foreach -->                    
                    <input type="submit" class="btn btn-primary" value="SUBMIT">
                    <a href="<?php echo site_url(); ?>/admin/user" class="btn btn-warning">BATAL</a>
                </form>
            </div>
        </div>
	</div>
	<?php require('user-action.php') ?>
</body>
<?php require('footer.php') ?>
<script type="text/javascript">
$('.avatar').click(function(e){
    var avatar = $(this).data('avatar');
    var src = $('#user-avatar').attr('src');    
    src = src.split('/');
    src.pop();
    src.push(avatar+'.jpg');
    src = src.join('/');
    $('#user-avatar').attr('src',src);  
    $('#avatar').val(avatar);
});
</script>

</html>
