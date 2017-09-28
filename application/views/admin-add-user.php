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
            <h3 style="margin-top:10px;text-align:center">TAMBAH USER</h3>
            <div class="col-md-3">
                <div class="img-box">
                <?php if(isset($error['value']['avatar'])){?>
                    <img src="<?php echo base_url().'assets/user_images/'.$error['value']['avatar'].'.jpg'; ?>" id="user-avatar">
                    <?php } 
                    else { ?>
                        <img src="<?php echo base_url().'assets/user_images/default-pp.jpg'; ?>" id="user-avatar">
                        <?php } ?>
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
                <?php echo form_open('admin/adduser',['class' => 'form-horizontal']); ?>
                    <input type="hidden" name="avatar" id="avatar"  value="<?php 
                        if (isset($error['value']['avatar'])) {
                            echo $error['value']['avatar'];
                        }
                        else
                            echo 'default-pp';?>">                    
	                    <div class="form-group">
	                        <label class="control-label col-sm-2" style="text-align:left">USERNAME:</label>
	                        <div class="col-sm-10" id="username-section">
	                            <input name="username" type="text" class="form-control" placeholder="Enter Username..." id="username" value="<?php 
                                if (isset($error['value']['username'])) {
                                    echo $error['value']['username'];
                                }?>">
                                <?php if (isset($error['message']['username'])) { ?>
                                    <span class="error-message"><?php echo $error['message']['username'];?></span>
                                <?php }?>                                
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="control-label col-sm-2" style="text-align:left">NAME:</label>
	                        <div class="col-sm-10" id="nama-section">
	                            <input name="nama" type="text" class="form-control" id="nama" placeholder="Enter Name..." value="<?php 
                                if (isset($error['value']['nama'])) {
                                    echo $error['value']['nama'];
                                }?>">
                                <?php if (isset($error['message']['nama'])) { ?>
                                    <span class="error-message"><?php echo $error['message']['nama'];?></span>
                                <?php }?>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="control-label col-sm-2" style="text-align:left">PASSWORD:</label>
	                        <div class="col-sm-10" id="password-section">
	                            <input name="password" type="password" class="form-control" id="password" placeholder="Enter Password..." value="<?php 
                                if (isset($error['value']['password'])) {
                                    echo $error['value']['password'];
                                }?>">
                                <?php if (isset($error['message']['password'])) { ?>
                                    <span class="error-message"><?php echo $error['message']['password'];?></span>
                                <?php }?>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="control-label col-sm-2" style="text-align:left">AUTHORISASI:</label>
	                        <div class="col-sm-10">
	                            <select class="form-control" name="level">
	                                <?php if (isset($error['value']['level'])) {
                                        $level = $error['value']['level'];
                                    }?>
                                    <option value="2" <?php if(isset($level) && $level == 2) echo "selected";?> >User Debit</option>
                                    <option value="3" <?php if(isset($level) && $level == 3) echo "selected";?> >User Kredit</option>
	                            </select>
	                        </div>
	                    </div>                    	
                    <input type="submit" class="btn btn-primary" value="SUBMIT">
                    <a href="<?php echo site_url(); ?>/admin/user" class="btn btn-warning">BATAL</a>
                </form>
            </div>
        </div>
        <!-- Modal cropping-->
        <div class="modal fade" id="modalCropper" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalLabel">CROP IMAGE</h4>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <img class="mbdc__modal-imgCropper" id="imagePreview" src="" alt="Picture">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default mbdc__modal-cta-btn-submit" data-dismiss="modal" id="crop-btn">CROP</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal cropping end -->
	</div>
	<?php require('user-action.php') ?>
</body>
<?php require('footer.php') ?>
<script src="<?php echo base_url(); ?>assets/vendor/cropperjs-master/cropper.min.js"></script>
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

$(document).ready(function(){
    let validationUsername = false;
    let validationPassword = false;
    let validationName = false;
    function available(message, id){
        $(`#${id}`).html(message)
        $(`#${id}`).removeClass('alert-danger')
        $(`#${id}`).addClass('alert-info')
    }

    function unavailable(message, id){
        $(`#${id}`).html(message)
        $(`#${id}`).removeClass('alert-info')
        $(`#${id}`).addClass('alert-danger')
    }    

    $('#username').on('focusout', function(e){
        if ($('#alert-username').length == 0) {
            $('#username-section').append('<div class="alert" role="alert" id="alert-username" style="margin-top: 15px; margin-bottom: 0"></div>')
        }
        let username = $('#username').val()
        let id = 'alert-username'
        // simple validation username        
        if (username == username.toLowerCase()) {
            if (username.length >= 3) {
                if (username.length <= 10) {
                    $.ajax({
                        type: "GET",
                        url: `<?php echo site_url();?>/admin/checkusername?username=${username}`,
                        ContentType: 'application/json',
                        dataType: 'json',
                        success: function(result, status){                
                            console.log(status);
                            if (result.code == 204) {
                                available(result.message, id)
                                validationUsername = true
                            }
                            else if (result.code == 205) {
                                unavailable(result.message, id)
                                validationUsername = false
                            }
                        }
                    });
                }
                else{
                    unavailable('username tidak boleh lebih dari 10 karakter', id)
                    validationUsername = false
                }
            }
            else{
                unavailable('username terdri dari 3 karakter atau lebih', id)
                validationUsername = false
            }
        }
        else{
            unavailable('username harus terbuat dari huruf kecil', id)
            validationUsername = false
        }        
    });

    $('#nama').on('focusout', () => {
        let nama = $('#nama').val()
        let id = 'alert-nama'
        if ($('#alert-nama').length == 0) {
            $('#nama-section').append('<div class="alert" role="alert" id="alert-nama" style="margin-top: 15px; margin-bottom: 0"></div>')
        }
        if (nama.length < 3) {
            unavailable('nama terdiri dari 3 karakter atau lebih', id)
            validationName = false
        }
        else if (nama.length > 350) {
            unavailable('nama tidak boleh lebih dari 350 karakter', id)
            validationName = false
        }
        else{
            $(`#${id}`).remove()
            validationName = true
        }
    })

    $('#password').on('focusout', () => {
        let password = $('#password').val()
        let id = 'alert-password'
        if ($('#alert-password').length == 0) {
            $('#password-section').append('<div class="alert" role="alert" id="alert-password" style="margin-top: 15px; margin-bottom: 0"></div>')
        }
        if (password.length < 5) {
            unavailable('password terdiri dari 5 karakter atau lebih', id)   
            validationPassword = false
        }
        else if (password.length > 10) {
            unavailable('password tidak boleh lebih dari 10 karakter', id)   
            validationPassword = false
        }
        else{
            $(`#${id}`).remove()
            validationPassword = true
        }
    })

    $(document).on('submit', 'form', function() {            
        if (validationPassword && validationUsername && validationName) {
            return true
        }
        else{
            alert('complete the form first')
            return false
        }        
    });
});

</script>
</html>
