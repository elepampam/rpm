<?php require('header.php') ?>
<body>
    <div class="container" style="position:relative">
        <a href="<?php echo site_url(); ?>/home/dashboard">
            <img src="<?php echo base_url(); ?>/assets/images/logo-itdc.png" class="logo-itdc">
        </a>
        <hr>
        <div class="row">
            <h3 style="margin-top:10px;text-align:center">REKONSILIASI PAJAK MASUKKAN</h3>
            <table class="table-info">
                <tr>
                    <td>Saldo Pajak Masukkan : </td>
                    <td class="torp"><?php echo $ppnDebit;; ?></td>
                    <td>Jumlah Pajak Masukkan Yang Belum Dikreditkan : </td>
                    <!-- <td class="torp"><?php echo $ppnUnDebit; ?></td> -->
                </tr>
                <tr>
                    <td>Pengkredittan Pajak Masukkan :</td>
                    <td class="torp"><?php echo $ppnKredit; ?></td>
                    <td>Jumlah Faktur Pajak Yang Belum Dikreditkan : </td>
                    <!-- <td><?php echo $totalDebit; ?> Faktur</td> -->
                </tr>
                <tr>
                    <td>Selisih Akibat Rekonsiliasi : </td>
                    <td class="torp"><?php echo $selisihPpn; ?></td>
                    <td>Jumlah Kredit Pajak Masukkan Yang Belum Diakui Sebagai Pajak Masukkan : </td>
                    <!-- <td class="torp"><?php echo $ppnUnKredit; ?></td> -->
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>Jumlah Pajak Masukkan Yang Belum Dikreditkan : </td>
                    <!-- <td><?php echo $totalKredit; ?> Faktur</td> -->
                </tr>
            </table>
            <p style="margin:40px 10px 10px 10px;"><strong>Penyebab Selisih Akibat Rekonsiliasi Pajak Masukkan</strong></p>
            <div class="col-md-12" style="text-align:center;margin-bottom:15px">
                <span id="box-debit">&nbsp;&nbsp;&nbsp;</span>
                <small>Pajak Masukkan Yang Belum Dikreditkan</small>
                <span id="box-kredit">&nbsp;&nbsp;&nbsp;</span>
                <small>Pajak Masukkan Yang Belum Diakui</small>
                <a href="<?php echo site_url(); ?>/faktur/cetak?<?php echo 'debit='.urlencode(json_encode($fakturDebit)); ?>" class="print" target="blank"><small>CETAK</small><i class="fa fa-print" aria-hidden="true"></i> </a>
            </div>
        </div>
        <div class="table-responsive">        
            <table class="table table-bordered" id="table">
                <thead>
                    <tr>
                        <th style="vertical-align:middle">No</th>
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
                <?php $count = 0; ?>
                <?php if (isset($fakturDebit)) {
                    # code...
                ?>
                    <?php foreach ($fakturDebit as $debit) {
                        ?>
                        <tr class="debit">
                            <td><?php echo ++$count;?></td>
                            <td><?php echo $debit->NO_FAKTUR?></td>
                            <td>
                            <?php
                             $date = explode('-', $debit->TANGGAL_FAKTUR);
                             $temp = $date[0];
                             $date[0] = $date[2];
                             $date[2] = $temp;
                             $date = implode('/', $date);
                             echo $date;
                            ?>                             
                            </td>
                            <td><?php echo $debit->NPWP?></td>
                            <td><?php echo $debit->NAMA?></td>
                            <td><?php echo $debit->ALAMAT_LENGKAP?></td>
                            <td><?php echo 'Rp '.number_format($debit->JUMLAH_DPP,2,',','.')?></td>
                            <td><?php echo 'Rp '.number_format($debit->JUMLAH_PPN,2,',','.')?></td>
                            <td><?php echo 'Rp '.number_format($debit->JUMLAH_PPNBM,2,',','.')?></td>
                        </tr>
                        <?php
                    } ?>
                <?php
                } ?>    
                <?php if (isset($fakturKredit)) {
                    # code...
                ?>
                    <?php foreach ($fakturKredit as $kredit) {
                    	?>
                    	<tr class="kredit">
                            <td><?php echo ++$count;?></td>
                            <td><?php echo $kredit->NO_FAKTUR?></td>
                            <td>
                            <?php
                             $date = explode('-', $kredit->TANGGAL_FAKTUR);
                             $temp = $date[0];
                             $date[0] = $date[2];
                             $date[2] = $temp;
                             $date = implode('/', $date);
                             echo $date;
                            ?>                             
                            </td>
                            <td><?php echo $kredit->NPWP?></td>
                            <td><?php echo $kredit->NAMA?></td>
                            <td><?php echo $kredit->ALAMAT_LENGKAP?></td>
                            <td><?php echo 'Rp '.number_format($kredit->JUMLAH_DPP,2,',','.')?></td>
                            <td><?php echo 'Rp '.number_format($kredit->JUMLAH_PPN,2,',','.')?></td>
                            <td><?php echo 'Rp '.number_format($kredit->JUMLAH_PPNBM,2,',','.')?></td>
                        </tr>
                    	<?php
                    } ?>
                    <?php
                } ?> 
                </tbody>
            </table>
        </div>
        <table class="table-info" style="width:50%;position:absolute;margin:50px 0;right:0;">
            <tr>
                <td>Kontrol Penyebab Selisih Rekonsiliasi : </td>
                <td class="torp"><?php echo $kontrolRekon; ?></td>
            </tr>
            <tr>
                <td>(Jumlah baris hijau dikurangi dengan jumlah baris biru)</td>
            </tr>
        </table>
    </div>
    <?php require('user-action.php') ?>
</body>

<?php require('footer.php') ?>

<script type="text/javascript">
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
	$( document ).ready(function() {
	    var temp = document.getElementsByClassName('torp');
	    for (var i = 0; i < temp.length; i++) {
	    	temp[i].innerHTML = toRp(temp[i].innerHTML);
	    }
	    console.log(temp);
	});
</script>