<?php require( '/../header.php') ?>
<?php
if (isset($action) && $action == 'debit-khusus') {
    // require('admin-input-debit-khusus.php');
}
elseif(isset($action) && $action == 'kredit-khusus'){
    // require('admin-input-kredit.php');
}
?>
<body>
  <style>
    .content-body.doToggle {
      height: unset;
      padding: 10px 10px;
      transition: all 0.5s ease;
    }

    .content-body {
      height: 0;
      padding: 0 10px;
      overflow: hidden;
      transition: all 0.5s ease;
    }
  </style>
  <div class="container">
        <a href="<?php echo site_url(); ?>/home/dashboard">
            <img src="<?php echo base_url(); ?>/assets/images/logo-itdc.png" class="logo-itdc">
        </a>
        <!-- call the debit/kredit view here -->
        <ul class="nav nav-tabs">
            <li <?php if(isset($action) && $action == 'debit-khusus') echo 'class="active"'; ?>><a href="<?php echo site_url()?>/admin/debit">DEBIT</a></li>
            <li <?php if(isset($action) && $action == 'kredit-khusus') echo 'class="active"'; ?>><a href="<?php echo site_url()?>/admin/kredit">KREDIT</a></li>
        </ul>
      <div class="row" style="text-align:center;position: relative;">
          <h3 style="margin-top:10px;">
            <?php
            if (isset($action) && $action == 'debit-khusus') {
                // require('admin-input-debit-khusus.php');
                ?>
                INPUT PAJAK MASUKAN KHUSUS
                <?php
            }
            elseif(isset($action) && $action == 'kredit-khusus'){
                // require('admin-input-kredit.php');
                ?>
                KREDIT PAJAK MASUKAN KHUSUS
                <?php
            }
            ?>
          </h3>
          <a href="<?php echo site_url() ?>/admin/debitKhusus" class="btn btn-primary btn-pajak-khusus">Pajak Masukan Khusus</a>
          <div class="col-md-12 alert alert-info box-input">
              <p>Tambahkan form faktur melalui tombol '+' pada halaman ini, dan isikan data faktur pada form yang dibuat.</p>
              <input type="submit" class="btn btn-primary" value="posting" id="submit">
          </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <form action="#" method='post' id="formkhusus-wrapper">
            <div class="panel panel-default">
              <div class="panel-heading">
                Pajak Masukkan 1
                <button type="button" class="btn btn-primary content-toggler" data-target="content-1">expand</button>
              </div>
              <div class="panel-body content-body" id="content-1">
                <div class="form-group">
                   <label for="email">Email address:</label>
                   <input type="email" class="form-control" id="email">
                 </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function(){
        $('.content-toggler').on('click', function(e){
          e.preventDefault();
          var contentTarget = $(e.currentTarget).data('target');
          $('#'+contentTarget).toggleClass('doToggle');
        })
      });
    </script>
</body>
