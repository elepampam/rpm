<div class="user-action">
    <a class="circle-icon action" id="logout" href="<?php echo site_url();?>/home/logout" data-toggle="tooltip" title="Log Out">
        <i class="fa fa-sign-out" aria-hidden="true"></i>
    </a>
    <a href="<?php echo site_url(); ?>/user/profile?username=<?php echo $user['username'] ?>" class="circle-icon action" id="user-profile" data-toggle="tooltip" title="Profile">
        <i class="fa fa-user" aria-hidden="true"></i>
    </a>
    <a class="circle-icon action" id="help">
        <i class="fa fa-question" aria-hidden="true" data-toggle="tooltip" title="Help"></i>
    </a>
    <div class="circle-icon" id="user">
    <?php
    if (file_exists($_SERVER['DOCUMENT_ROOT']."/banditrpm/assets/user_images/".$user['avatar'].".jpg")) {
        ?>
        <img src="<?php echo base_url(); ?>assets/user_images/<?php echo $user['avatar']; ?>.jpg" id="user-img">
        <?php
    } else {
     ?>
     <img src="<?php echo base_url(); ?>assets/images/default-pp.jpg" id="user-img">
     <?php
     }?>
        <div class="overlay"></div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#user').click(function() {
	    $('.user-action').toggleClass('toggle-action');
	});
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
