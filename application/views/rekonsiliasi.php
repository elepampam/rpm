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
                    <td class="torp" id="ppnDebit"><?php echo $ppnDebit;; ?></td> 
                    <td>Jumlah Pajak Masukkan Yang Belum Dikreditkan : </td>
                    <td class="torp" id="bebanDebit"><?php echo $sumBebanDebit; ?></td>
                </tr>
                <tr>
                    <td>Pengkredittan Pajak Masukkan :</td>
                    <td class="torp" id="ppnKredit"><?php echo $ppnKredit; ?></td>
                    <td>Jumlah Faktur Pajak Yang Belum Dikreditkan : </td>
                    <td id="totalBebanDebit"><?php echo $totalBebanDebit; ?> Faktur</td>
                </tr>
                <tr>
                    <td>Selisih Akibat Rekonsiliasi : </td>
                    <td class="torp" id="selisihPpn"><?php echo $selisihPpn; ?></td>
                    <td>Jumlah Kredit Pajak Masukkan Yang Belum Diakui Sebagai Pajak Masukkan : </td>
                    <td class="torp" id="bebanKredit"><?php echo $sumBebanKredit; ?></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>Jumlah Pajak Masukkan Yang Belum Dikreditkan : </td>
                    <td id="totalBebanKredit"><?php echo $totalBebanKredit; ?> Faktur</td>
                </tr>
            </table>
            <button id="rekon" class="btn btn-primary" <?php if(!$notRekon) echo "disabled='true'";?>>Rekon</button>            
            <!-- <button id="rekon" class="btn btn-primary">Rekon</button>    -->
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Cetak<span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="<?php echo site_url();?>/faktur/printpdf?tabel=faktur_debit" target="blank">Hasil Rekon Debit</a></li>
                <li><a href="<?php echo site_url();?>/faktur/printpdf?tabel=faktur_kredit" target="blank">Hasil Rekon Kredit</a></li>
              </ul>
            </div>
            <p style="margin:40px 10px 10px 10px;"><strong>Penyebab Selisih Akibat Rekonsiliasi Pajak Masukkan</strong></p>
            <div class="col-md-12" style="text-align:center;margin-bottom:15px">                
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab" id="debittab">Data Debit</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" id="kredittab">Data Kredit</a></li>
                </ul>                
            </div>
        </div>
        <div id="tempTableHead"></div>
        <div class="table-responsive" style="position: relative">
        </div>
        <div id="tempTableFoot"></div>

        <table class="table-info" style="width:50%;position:absolute;margin:50px 0;right:0;">
            <tr>
                <td>Kontrol Penyebab Selisih Rekonsiliasi : </td>
                <td class="torp" id="kontrolRekon"><?php echo $kontrolRekon; ?></td>
            </tr>
            <tr>
                <td>(Jumlah beban debit dikurangi dengan jumlah beban kredit)</td>
            </tr>
        </table>
    </div>
    <?php require('user-action.php') ?>
    <div>   
    <!-- modal konfirmasi rekon -->
    <div id="modalConfirm" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Konfirmasi Rekon</h4>
                </div>
                <div class="modal-body">
                    Anda akan melakukan proses rekon. Setelah selesai, proses rekon tidak dapat <strong>dikembalikan</strong> seperti semula
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="doRekon">Rekon</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>   

    <!-- modal konfirmasi rekon -->
    <div id="modalWaitingRekon" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Proses Rekonsiliasi</h4>
                </div>
                <div class="modal-body">
                    <p id="messageRekon"></p>
                    <div class="loader"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>
            </div>
            </div>
        </div>
    </div>   

    <!-- modal ambil beban -->
    <div id="modalBeban" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Mengambil Data</h4>
                </div>
                <div class="modal-body">
                    <p id="message"></p>
                    <div class="loader"></div>
                </div>                
            </div>
        </div>
    </div>  

    <!-- modal update informasi rekon -->
    <div id="modalUpdate" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Memperbaharui Informasi</h4>
                </div>
                <div class="modal-body">
                    <p>Memperbaharui informasi pada halaman rekon</p>
                    <div class="loader"></div>
                </div>                
            </div>
        </div>
    </div> 
</body>

<?php require('footer.php') ?>

<!-- <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/vendor/DataTables/media/css/jquery.dataTables.css"> -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/vendor/DataTables/media/css/dataTables.bootstrap.css">
<script type="text/javascript" src="<?php echo base_url()?>assets/vendor/DataTables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript">
	function toRp(angka) {
        // console.log(angka);
        if (isNaN(parseInt(angka)) === true) {
            return angka
        }
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

    function fixdate(date){
        date = date.split("-");
        if (date.length == 1) {
            return date.join("");
        }
        var temp = date[0];
        date[0] = date[2];
        date[2] = temp;
        return date.join("/")
    }

	$(document ).ready(function() {
        var temp = document.getElementsByClassName('torp');
        for (var i = 0; i < temp.length; i++) {
            temp[i].innerHTML = toRp(temp[i].innerHTML);
        }
        
        var tabelfaktur;         
        createTabelDebit();

        function showModalBeban(pesan){
            $('#message').html(pesan);
            $("#modalBeban").modal({backdrop: 'static'});
        }

        function closeModalBeban(pesan){
            $('#message').html(pesan);
            setTimeout(function(){$("#modalBeban").modal('hide')}, 1500);
        }        

        $("#rekon").on('click', function(e){
            $("#modalConfirm").modal({backdrop: 'static'});                                
        });

        $('#doRekon').on('click', function(e){
            $('#modalConfirm').modal('hide');
            $('#messageRekon').html('menunggu proses rekonsiliasi...');
            $('#modalWaitingRekon').modal();
            rekon();
        });

        function rekon(){
            $.ajax({
                type: "GET",
                url: "<?php echo site_url(); ?>/faktur/rekon",
                ContentType: 'application/json',
                dataType: 'json',                     
                success: function(result, status){
                    if (result.code == 201) {
                        $('#messageRekon').html(result.response);
                    }
                    else if (result.code == 202) {
                        $('#messageRekon').html(result.response);
                    }
                    setTimeout(function(){
                        $('#modalWaitingRekon').modal('hide');    
                    }, 1500)
                }
            });
        }

        $('#modalWaitingRekon').on('hidden.bs.modal', function(){
            $('#modalUpdate').modal();
            $.ajax({
                type: "GET",
                url: "<?php echo site_url();?>/faktur/updateRekon",
                ContentType: 'application/json',
                dataType: 'json',                     
                success: function(result, status){
                    $('#ppnDebit').html(result.ppnDebit);
                    $('#ppnKredit').html(result.ppnKredit);
                    $('#bebanDebit').html(result.bebanDebit);
                    $('#bebanKredit').html(result.bebanKredit);
                    $('#totalBebanKredit').html(result.totalBebanKredit);
                    $('#totalBebanDebit').html(result.totalBebanDebit);
                    $('#selisihPpn').html(result.selisihPpn);
                    $('#kontrolRekon').html(result.kontrolRekon);
                    if (!result.notRekon) {
                        $('#rekon').attr('disabled',true);
                    }
                    else
                        $('#rekon').attr('disabled',false);   
                    setTimeout(function(){
                        $('#modalUpdate').modal('hide');
                        $('#debittab').click();
                    },1500)
                }
            });
        });

        // serverSide
        function createTabelDebit(){
            showModalBeban("Mengambil data beban dari faktur debit");
            $('.table-responsive').append('<table class="table table-striped table-bordered" id="table"><thead></thead><tbody></tbody></table>');
            tabelfaktur = $('#table').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    emptyTable: "tidak ada beban faktur"
                },
                ajax:{
                    url: "<?php echo site_url();?>/faktur/getFakturBeban?tabel=faktur_debit",
                    dataType: "json",
                    type: "POST",

                },
                columns: [
                { data: "NO_FAKTUR",
                  title: "NO_FAKTUR"
                },
                { data: "FM",
                  title: "FM"
                },
                { data: "KD_JENIS",
                  title: "KD_JENIS"
                },
                { data: "FG_PENGGANTI",
                  title: "FG_PENGGANTI"
                },
                { data: "NOMOR_FAKTUR",
                  title: "NOMOR_FAKTUR"
                },
                { data: "MASA_PAJAK",
                  title: "MASA_PAJAK"
                },
                { data: "TAHUN_PAJAK",
                  title: "TAHUN_PAJAK"
                },
                { data: "TANGGAL_FAKTUR",
                  title: "TANGGAL_FAKTUR"
                },
                { data: "NPWP",
                  title: "NPWP"
                },
                { data: "NAMA",
                  title: "NAMA"
                },
                { data: "ALAMAT_LENGKAP",
                  title: "ALAMAT_LENGKAP"
                },
                { data: "JUMLAH_DPP",
                  title: "JUMLAH_DPP"
                },
                { data: "JUMLAH_PPN",
                  title: "JUMLAH_PPN"
                },
                { data: "JUMLAH_PPNBM",
                  title: "JUMLAH_PPNBM"
                },
                { data: "USER_INPUT",
                  title: "USER_INPUT"
                },
                { data: "DATE_INPUT",
                  title: "DATE_INPUT"
                }
            ],
            initComplete: function(setting, json){
                closeModalBeban('Beban dari faktur debit berhasil diambil');
                $('#table_length').appendTo('#tempTableHead');
                $('#table_filter').appendTo('#tempTableHead');
                $('#table_info').appendTo('#tempTableFoot');
                $('#table_paginate').appendTo('#tempTableFoot');                
            }  
            });            
        }
           
        $('#debittab').on('click', function(e){
            tabelfaktur.destroy(true);
            $('#table_length').remove();
            $('#table_filter').remove();
            $('#table_info').remove();
            $('#table_paginate').remove();                 
            createTabelDebit();
        });

        function createTabelKredit(){
            showModalBeban("Mengambil data beban dari faktur kredit");
            $('.table-responsive').append('<table class="table table-striped table-bordered" id="table"><thead></thead><tbody></tbody></table>');
            tabelfaktur = $('#table').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    emptyTable: "tidak ada beban faktur"
                },
                ajax:{
                    url: "<?php echo site_url();?>/faktur/getFakturBeban?tabel=faktur_kredit",
                    dataType: "json",
                    type: "POST",
                },
                columns: [
                { data: "NO_FAKTUR",
                  title: "NO_FAKTUR"
                },
                { data: "FM",
                  title: "FM"
                },
                { data: "KD_JENIS",
                  title: "KD_JENIS"
                },
                { data: "FG_PENGGANTI",
                  title: "FG_PENGGANTI"
                },
                { data: "NOMOR_FAKTUR",
                  title: "NOMOR_FAKTUR"
                },
                { data: "MASA_PAJAK",
                  title: "MASA_PAJAK"
                },
                { data: "TAHUN_PAJAK",
                  title: "TAHUN_PAJAK"
                },
                { data: "TANGGAL_FAKTUR",
                  title: "TANGGAL_FAKTUR"
                },
                { data: "NPWP",
                  title: "NPWP"
                },
                { data: "NAMA",
                  title: "NAMA"
                },
                { data: "ALAMAT_LENGKAP",
                  title: "ALAMAT_LENGKAP"
                },
                { data: "JUMLAH_DPP",
                  title: "JUMLAH_DPP"
                },
                { data: "JUMLAH_PPN",
                  title: "JUMLAH_PPN"
                },
                { data: "JUMLAH_PPNBM",
                  title: "JUMLAH_PPNBM"
                },
                { data: "USER_INPUT",
                  title: "USER_INPUT"
                },
                { data: "DATE_INPUT",
                  title: "DATE_INPUT"
                }
            ],
            initComplete: function(setting, json){
                closeModalBeban('Beban dari faktur kredit berhasil diambil');
                $('#table_length').appendTo('#tempTableHead');
                $('#table_filter').appendTo('#tempTableHead');
                $('#table_info').appendTo('#tempTableFoot');
                $('#table_paginate').appendTo('#tempTableFoot'); 
            }  
            });            
        }

        $("#kredittab").on('click', function(e){
            tabelfaktur.destroy(true);
            $('#table_length').remove();
            $('#table_filter').remove();
            $('#table_info').remove();
            $('#table_paginate').remove();                 
            createTabelKredit();
        });
	});
</script>