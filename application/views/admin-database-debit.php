<?php require('header.php') ?>
<style type="text/css">
    input {
  display: none;
}

label input[type=checkbox] ~ span {
  display: inline-block;
  vertical-align: middle;
  cursor: pointer;
  background: #fff;
  border: 1px solid #888;
  padding: 1px;
  height: 20px;
  width: 20px;
}

label input[type=checkbox]:checked ~ span {
  /* image: Picol.org, cc-by 3.0, https://commons.wikimedia.org/wiki/File:Accept_Picol_icon.svg */
  background: url('<?php echo base_url(); ?>/assets/images/check.svg');
  background-color: white;
  background-size: 100%;
}
</style>
<body>
	<div class="container">
        <a href="<?php echo site_url(); ?>/home/dashboard">
            <img src="<?php echo base_url(); ?>/assets/images/logo-itdc.png" class="logo-itdc">
        </a>
        <ul class="nav nav-tabs">
            <li class="active"><a href="<?php echo site_url(); ?>/admin/database?table=faktur_debit">DEBIT</a></li>
            <li><a href="<?php echo site_url(); ?>">KREDIT</a></li>
        </ul>
        <div class="row" style="text-align:center">
            <h3 style="margin-top:10px;">MANAGE DATABASE</h3>
        </div>
        <p>Jumlah Faktur Debit : <strong id="faktur-masuk"></strong></p>
        <p>Jumlah PPN : <strong id="jumlah-ppn"></strong></p>
        <p>Jumlah PPnBM : <strong id="jumlah-ppnbm"></strong></p>
        <?php if (isset($fakturs)) {
            ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="failed">
                    <thead>
                        <tr>
                            <th style="vertical-align:middle">SELECT</th>
                            <th style="vertical-align:middle">NO FAKTUR</th>
                            <th style="vertical-align:middle">TANGGAL FAKTUR</th>
                            <th style="vertical-align:middle">NPWP</th>
                            <th style="vertical-align:middle">NAMA</th>
                            <th style="vertical-align:middle">ALAMAT LENGKAP</th>
                            <th style="vertical-align:middle">JUMLAH DPP</th>
                            <th style="vertical-align:middle">JUMLAH PPN</th>
                            <th style="vertical-align:middle">JUMLAH PPNBM</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php echo form_open('admin/deletedatabase?table=faktur_debit'); ?> 
                    <?php 
                    foreach ($fakturs as $faktur) {
                        ?>
                        <tr class="debit" data-faktur="<?php echo $faktur->NO_FAKTUR; ?>">
                            <td>
                                <label>
                                  <input type="checkbox" value="<?php echo $faktur->NO_FAKTUR; ?>" />
                                  <span></span>
                                </label>
                            </td>
                            <td><?php echo $faktur->NO_FAKTUR?></td>
                            <td>
                            <?php
                             $date = explode('-', $faktur->TANGGAL_FAKTUR);
                             $temp = $date[0];
                             $date[0] = $date[2];
                             $date[2] = $temp;
                             $date = implode('/', $date);
                             echo $date;
                            ?>                             
                            </td>
                            <td><?php echo $faktur->NPWP?></td>
                            <td><?php echo $faktur->NAMA?></td>
                            <td><?php echo $faktur->ALAMAT_LENGKAP?></td>
                            <td><?php echo 'Rp '.number_format($faktur->JUMLAH_DPP,2,',','.')?></td>
                            <td><?php echo 'Rp '.number_format($faktur->JUMLAH_PPN,2,',','.')?></td>
                            <td><?php echo 'Rp '.number_format($faktur->JUMLAH_PPNBM,2,',','.')?></td>
                        </tr>
                        <?php
                    };?>
                    </tbody>
                    </form>
                </table>
            </div>
            <?php
        } ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="table">
            </table>
        </div>
    </div>
    <?php require('user-action.php') ?>
</body>
<?php require('footer.php') ?>
<script type="text/javascript">
var ppnCount = 0;
var ppnBmCount = 0;

function hitungPpn(nilaiPpn) {
    ppnCount += nilaiPpn;
    return false;
}

function hitungPpnBm(nilaiPpnBm) {
    ppnBmCount += nilaiPpnBm;
    return false;
}

function toRp(angka) {
    var rev = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2 = '';
    for (var i = 0; i < rev.length; i++) {
        rev2 += rev[i];
        if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
            rev2 += '.';
        }
    }
    return 'Rp. ' + rev2.split('').reverse().join('') + ',00';
}

$('.debit').click(function(){
  $(this).find('input');
  console.log($(this).data('faktur'));
})
</script>