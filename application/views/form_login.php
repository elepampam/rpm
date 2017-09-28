<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>RPM | login</title>
<!-- bootstrap -->
<link href="<?=base_url();?>assets/vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?=base_url();?>assets/css/login.css" rel="stylesheet" type="text/css">

<body>
<div id="particle-js"></div>
<div class="form">
  <h3 class="text-center">Login RPM</h3>
  <?php 
          if (isset($pesan)) {
              if ($pesan == "gagal") 
          {
             echo '<div class="alert alert-danger fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Maaf!</strong> Username atau password yang anda masukkan salah.
                  </div>';
          }
          }

  ?>
    <form role="form" method="post" action="<?php echo site_url('home/login'); ?>">
      <div class="form-group">
        <input type="text" class="form-control custom-text-form" id="username" placeholder="Username" name="username">
      </div>
      <div class="form-group">
        <input type="password" class="form-control custom-text-form" id="pwd" placeholder="Password" name="pwd">
      </div>
      <button type="submit" class="btn btn-block btn-login">Login</button>
    </form>
    <p class="text-center copyrights" style="margin-top:35px;">developed by eLepampam</p>
  <div class="support">
    <img class="logo" src="<?php echo base_url()?>/assets/images/logo-itdc.png">
  </div>  
</div>

</body>
<script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?=base_url();?>assets/vendor/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/vendor/particlejs/particles.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    particlesJS.load('particle-js','<?php echo base_url(); ?>assets/vendor/particlejs/particles.json');
  });
</script>
</html>