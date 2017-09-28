<?php include('header.php') ?>
<style type="text/css">
    .table-bordered thead tr th{
        text-align: center;
        padding: 10px;
        font-size: 12px;
    }
    .table-bordered tbody tr td{
        padding: 10px;
        text-align: center;
    }
    body{
        background:white;
    }
    .morewidth{
        width:150px;
    }
    .table-info tr td{
        padding: 5px;
    }
    .table-info tr td.info{
        max-width: 250px;
    }
    .table-info tr td.angka {
        max-width: 200px;
        vertical-align: top;
        text-align: left;   
    }
    .debit td{
        background-color:#4abaf3;
    }
    .kredit td{
        background-color: #9fce58;
    }
</style>
<body>
    <div class="container" style="position:relative">
        <div class="row" style="text-align:center">
            <img src="<?php echo base_url(); ?>/assets/images/logo-itdc.png" class="logo-itdc">
        </div>
        <hr>
        <div class="row">
            <h3 style="margin-top:10px;text-align:center">REKONSILIASI PAJAK MASUKKAN</h3>
            <table class="table-info">
                <tr>
                    <td class="info">Saldo Pajak Masukkan : </td>
                    <td class="angka"><?php echo $ppnDebit;; ?></td>
                    <td class="info">Jumlah Pajak Masukkan Yang Belum Dikreditkan : </td>
                    <td class="angka"><?php echo $sumBebanDebit; ?></td>
                </tr>
                <tr>
                    <td class="info">Pengkredittan Pajak Masukkan :</td>
                    <td class="angka"><?php echo $ppnKredit; ?></td>
                    <td class="info">Jumlah Faktur Pajak Yang Belum Dikreditkan : </td>
                    <td class="angka"><?php echo $totalBebanDebit; ?> Faktur</td>
                </tr>
                <tr>
                    <td class="info">Selisih Akibat Rekonsiliasi : </td>
                    <td class="angka"><?php echo $selisihPpn; ?></td>
                    <td class="info">Jumlah Kredit Pajak Masukkan Yang Belum Diakui Sebagai Pajak Masukkan : </td>
                    <td class="angka"><?php echo $sumBebanKredit; ?></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>Jumlah Pajak Masukkan Yang Belum Dikreditkan : </td>
                    <td class="angka"><?php echo $totalBebanKredit; ?> Faktur</td>
                </tr>
            </table>
            <p style="margin:40px 10px 10px 10px;"><strong>Penyebab Selisih Akibat Rekonsiliasi Pajak Masukkan</strong></p>
            <div style="text-align:center">
                Beban Faktur Debit
            </div>
            <!-- <div class="col-md-12" style="text-align:center;margin-bottom:15px">
                <span id="box-debit">&nbsp;&nbsp;&nbsp;</span>
                <small>Pajak Masukkan Yang Belum Dikreditkan</small>
                <span id="box-kredit">&nbsp;&nbsp;&nbsp;</span>
                <small>Pajak Masukkan Yang Belum Diakui</small>
            </div> -->
        </div>
        <div class="table-responsive">        
            <table class="table table-bordered" id="table">
                <thead>
                    <tr>                        
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
                    <?php if (!is_null($fakturs)) {
                        foreach ($fakturs as $faktur) {
                            ?>
                            <tr>
                                <td style="vertical-align:middle"><?php echo $faktur->NO_FAKTUR ?></td>
                                <td style="vertical-align:middle"><?php echo $faktur->TANGGAL_FAKTUR ?></td>
                                <td style="vertical-align:middle"><?php echo $faktur->NPWP ?></td>
                                <td style="vertical-align:middle"><?php echo $faktur->NAMA ?></td>
                                <td style="vertical-align:middle"><?php echo $faktur->ALAMAT_LENGKAP ?></td>
                                <td style="vertical-align:middle"><?php echo $faktur->JUMLAH_DPP ?></td>
                                <td style="vertical-align:middle"><?php echo $faktur->JUMLAH_PPN ?></td>
                                <td style="vertical-align:middle"><?php echo $faktur->JUMLAH_PPNBM ?></td>
                            </tr>
                            <?php
                        }
                    } 
                    else{
                        ?>
                        <tr>
                            <td colspan="8">Tidak ada faktur beban</td>
                        </tr>
                        <?php
                    }?>                
                </tbody>
            </table>
        </div>
        <table class="table-info" style="width:50%;position:absolute;margin:50px 0;right:0;">
            <tr>
                <td>Kontrol Penyebab Selisih Rekonsiliasi : </td>
                <td><?php echo $kontrolRekon; ?></td>
            </tr>
            <tr>
                <td>(Jumlah beban debit dikurangi dengan jumlah beban kredit)</td>
            </tr>
        </table>
    </div>
</body>

<?php require('footer.php') ?>