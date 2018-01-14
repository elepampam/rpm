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

    #formkhusus-wrapper .panel-heading {
      position: relative;
    }
    .toggle-wrapper{
      position: absolute;
      right: 0;
      top: 0;
    }
    button.btn.btn-primary.content-toggler:focus,
    button.btn.btn-primary.content-delete:focus{
      outline: transparent;
    }
    .content-toggler .glyphicon-chevron-down,
    .content-toggler.doToggle .glyphicon-chevron-up{
      display: inline-block;
    }
    .content-toggler.doToggle .glyphicon-chevron-down,
    .content-toggler .glyphicon-chevron-up{
      display: none;
    }
    button.btn.btn-primary.content-toggler,
    button.btn.btn-primary.content-delete{
      right: 0;
      top: 0;
      background-color: #f5f5f5;
      color: #333;
      border-color: transparent;
      padding: 9px;
      border-radius: 0;
      border-left: 1px solid #ddd;
    }

    .btn-tambah-faktur{
      position: fixed;
      z-index: 100;
      right: 0;
      top: 50%;
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
    }
  </style>
  <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
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
          <a href="#" id="tambah-faktur" class="btn btn-primary btn-tambah-faktur">
            <i class="glyphicon glyphicon-plus"></i>
          </a>
          <!-- <a href="<?php echo site_url() ?>/admin/debitKhusus" class="btn btn-primary btn-pajak-khusus">Pajak Masukan Khusus</a> -->
          <div class="col-md-12 alert alert-info box-input">
              <p>Tambahkan form faktur melalui tombol '+' pada halaman ini, dan isikan data faktur pada form yang dibuat.</p>
              <button class="btn btn-primary" id="submit">
                submit
              </button>
          </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <form action="#" method='post' id="formkhusus-wrapper">
            <div class="panel panel-default" id="pajak-masukan-1">
              <div class="panel-heading">
                Pajak Masukkan 1
                <div class="toggle-wrapper">
                  <button type="button" class="btn btn-primary content-delete" data-target="pajak-masukan-1">
                    <i class="glyphicon glyphicon-trash" alt="delete-faktur"></i>
                  </button>
                  <button type="button" class="btn btn-primary content-toggler" data-target="content-1">
                    <i class="glyphicon glyphicon-chevron-up"></i>
                    <i class="glyphicon glyphicon-chevron-down"></i>
                  </button>
                </div>
              </div>
              <div class="panel-body content-body" id="content-1">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group">
                     <label for="no-faktur-1">No Faktur: </label>
                     <input type="text" class="form-control" id="no-faktur-1" name="no-faktur" placeholder="No Faktur...">
                   </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group">
                     <label for="nama-1">Nama: </label>
                     <input type="text" class="form-control" id="nama-1" name="nama" placeholder="exp: Indomaret, Biznet...">
                   </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group">
                     <label for="npwp-1">NPWP: </label>
                     <input type="text" class="form-control" id="npwp-1" name="npwp" placeholder="NPWP...">
                   </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group">
                     <label for="masa-pajak-1">Masa Pajak: </label>
                     <select class="form-control" name="masa-pajak" id="masa-pajak-1">
                       <option value="1">Januari (1)</option>
                       <option value="2">Februari (2)</option>
                       <option value="3">Maret (3)</option>
                       <option value="4">April (4)</option>
                       <option value="5">Mei (5)</option>
                       <option value="6">Juni (6)</option>
                       <option value="7">Juli</option>
                       <option value="8">Agustus (8)</option>
                       <option value="9">September (9)</option>
                       <option value="10">Oktober (10)</option>
                       <option value="11">November (11)</option>
                       <option value="12">Desember (12)</option>
                     </select>
                   </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group">
                     <label for="tahun-pajak-1">Tahun Pajak: </label>
                     <input type="number" class="form-control" id="tahun-pajak-1" name="tahun-pajak" placeholder="Tahun Pajak...">
                   </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group">
                     <label for="tanggal-faktur-1">Tanggal Faktur: </label>
                     <input type="text" class="form-control date" id="tanggal-faktur-1" name="tanggal-faktur" placeholder="yyyy/mm/dd" data-provide="datepicker">
                   </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                     <label for="alamat-faktur-1">Alamat: </label>
                     <input type="text" class="form-control" id="alamat-faktur-1" name="alamat-faktur" placeholder="Alamat...">
                   </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group">
                     <label for="dpp-faktur-1">Jumlah DPP: </label>
                     <input type="number" class="form-control" id="dpp-faktur-1" name="dpp-faktur" placeholder="Jumlah DPP...">
                   </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group">
                     <label for="ppn-faktur-1">Jumlah PPN: </label>
                     <input type="number" class="form-control" id="ppn-faktur-1" name="ppn-faktur" placeholder="Jumlah PPN...">
                   </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group">
                     <label for="ppnbm-faktur-1">Jumlah PPNBM: </label>
                     <input type="number" class="form-control" id="ppnbm-faktur-1" name="ppnbm-faktur" placeholder="Jumlah PPNBM...">
                   </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <?php require('/../user-action.php') ?>
      </div>
    </div>
    <script>
      $(document).ready(function(){
        $('.date').datepicker({
          format: 'yyyy/mm/dd',
          autoclose: 'true',
          endDate: Date()
        });

        $('#formkhusus-wrapper').on('click','.content-toggler', function(e){
          e.preventDefault();
          var contentTarget = $(e.currentTarget).data('target');
          var toggleText = $(e.currentTarget).html();
          $(e.currentTarget).toggleClass('doToggle');
          $('#'+contentTarget).toggleClass('doToggle');
        });

        $('#formkhusus-wrapper').on('click','.content-delete',function(e){
          var deleteFaktur = $(e.currentTarget).data('target');
          var doDelete = confirm(`Delete Faktur ${deleteFaktur.split('-').join(' ')} ?`);
          if (doDelete) {
            $(`#${deleteFaktur}`).remove();
          }
        })
        var fakturIndex = 1;
        $('#tambah-faktur').on('click', function(e){
          e.preventDefault();
          fakturIndex++;
          var fakturComponent = `
          <div class="panel panel-default" id="pajak-masukan-${fakturIndex}">
          <input type="hidden" name="splitter">
            <div class="panel-heading">
              Pajak Masukkan ${fakturIndex}
              <div class="toggle-wrapper">
                <button type="button" class="btn btn-primary content-delete" data-target="pajak-masukan-${fakturIndex}">
                  <i class="glyphicon glyphicon-trash" alt="delete-faktur"></i>
                </button>
                <button type="button" class="btn btn-primary content-toggler" data-target="content-${fakturIndex}">
                  <i class="glyphicon glyphicon-chevron-up"></i>
                  <i class="glyphicon glyphicon-chevron-down"></i>
                </button>
              </div>
            </div>
            <div class="panel-body content-body" id="content-${fakturIndex}">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                   <label for="no-faktur-${fakturIndex}">No Faktur: </label>
                   <input type="text" class="form-control" id="no-faktur-${fakturIndex}" name="no-faktur" placeholder="No Faktur...">
                 </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                   <label for="nama-${fakturIndex}">Nama: </label>
                   <input type="text" class="form-control" id="nama-${fakturIndex}" name="nama" placeholder="exp: Indomaret, Biznet...">
                 </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                   <label for="npwp-${fakturIndex}">NPWP: </label>
                   <input type="text" class="form-control" id="npwp-${fakturIndex}" name="npwp" placeholder="NPWP...">
                 </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                   <label for="masa-pajak-${fakturIndex}">Masa Pajak: </label>
                   <select class="form-control" name="masa-pajak" id="masa-pajak-${fakturIndex}">
                     <option value="1">Januari (1)</option>
                     <option value="2">Februari (2)</option>
                     <option value="3">Maret (3)</option>
                     <option value="4">April (4)</option>
                     <option value="5">Mei (5)</option>
                     <option value="6">Juni (6)</option>
                     <option value="7">Juli</option>
                     <option value="8">Agustus (8)</option>
                     <option value="9">September (9)</option>
                     <option value="10">Oktober (10)</option>
                     <option value="11">November (11)</option>
                     <option value="12">Desember (12)</option>
                   </select>
                 </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                   <label for="tahun-pajak-${fakturIndex}">Tahun Pajak: </label>
                   <input type="number" class="form-control" id="tahun-pajak-${fakturIndex}" name="tahun-pajak" placeholder="Tahun Pajak...">
                 </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                   <label for="tanggal-faktur-${fakturIndex}">Tanggal Faktur: </label>
                   <input type="text" class="form-control date" id="tanggal-faktur-${fakturIndex}" name="tanggal-faktur" placeholder="yyyy/mm/dd" data-provide="datepicker">
                 </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                   <label for="alamat-faktur-${fakturIndex}">Alamat: </label>
                   <input type="text" class="form-control" id="alamat-faktur-${fakturIndex}" name="alamat-faktur" placeholder="Alamat...">
                 </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                   <label for="dpp-faktur-${fakturIndex}">Jumlah DPP: </label>
                   <input type="number" class="form-control" id="dpp-faktur-${fakturIndex}" name="dpp-faktur" placeholder="Jumlah DPP...">
                 </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                   <label for="ppn-faktur-${fakturIndex}">Jumlah PPN: </label>
                   <input type="number" class="form-control" id="ppn-faktur-${fakturIndex}" name="ppn-faktur" placeholder="Jumlah PPN...">
                 </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                   <label for="ppnbm-faktur-${fakturIndex}">Jumlah PPNBM: </label>
                   <input type="number" class="form-control" id="ppnbm-faktur-${fakturIndex}" name="ppnbm-faktur" placeholder="Jumlah PPNBM...">
                 </div>
              </div>
            </div>
          </div>
          `;
          $('#formkhusus-wrapper').append(fakturComponent);
          $("html, body").animate({ scrollTop: $(document).height() }, 1000);
        });

        $('#submit').on('click', function(e){
          var fakturs = $('#formkhusus-wrapper').serialize().split('&splitter=&');
          var fakturList = [];
          fakturs.map(function(faktur,index){
            var fakturComponent = faktur.split('&');
          	fakturList[index] = {};
          	fakturComponent.map(function(value){
            		fakturKeyNVal = value.split('=');
            		fakturList[index][fakturKeyNVal[0]] = fakturKeyNVal[1].replace(/%2F/g,'-');
              })
          })
          // fakturList.map(function(value){
          //   console.log(value);
          // })
          submitFaktur(fakturList);
        })

        function submitFaktur(fakturList){
          var index = 0;
          const testPromise = function () {
            return new Promise(function (resolve, reject) {
              $.ajax({
                url: "http://localhost/banditrpm/index.php/Faktur/debitKhusus",
                type: 'POST',
                dataType: 'json',
                data: {
                  faktur: fakturList[index]
                },
                success: function(response){
                  resolve(response);
                  console.log(response);
                  console.log('masuk: '+index);
                }
              });
            })
          }

          const poll = function () {
            testPromise()
            .then((res) => {
              setTimeout(() => {
                index += 1
                if (index < fakturList.length) {
                    poll()
                }
              }, 1000)
            })
            .catch(() => {

            })
          }
          poll();
        }
      });
    </script>
</body>
