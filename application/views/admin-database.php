<?php require('header.php') ?>
<style type="text/css">
    .text-warning{
        color: #f00;
        font-weight: bold;
    }
</style>
<body>
    <div class="container" style="position:relative">
        <a href="<?php echo site_url(); ?>/home/dashboard">
            <img src="<?php echo base_url(); ?>/assets/images/logo-itdc.png" class="logo-itdc">
        </a>
        <hr>
        <div class="row">
            <h3 style="margin-top:10px;text-align:center">DATABASE</h3>
            <table class="table-info">
                <tr>
                    <td>Saldo Pajak Masukkan : </td>
                    <td id="ppnDebit"><?php echo $ppnDebit;; ?></td> 
                    <td>Jumlah Faktur Pajak (Debet) : </td>
                    <td id="totalFakturDebit"><?php echo $totalDebit; ?> Faktur</td>
                </tr>
                <tr>
                    <td>Pengkredittan Pajak Masukkan :</td>
                    <td id="ppnKredit"><?php echo $ppnKredit; ?></td>
                    <td>Jumlah Pajak Masukkan (Kredit) : </td>
                    <td id="totalFakturKredit"><?php echo $totalKredit; ?> Faktur</td>
                </tr>                
            </table>
            <button id="delete-all" class="btn btn-danger">Delete All</button>
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
    </div>
    <?php require('user-action.php') ?>
    <div>   
    <!-- modal konfirmasi Delete -->
    <div id="modalConfirm" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Konfirmasi Delete</h4>
                </div>
                <div class="modal-body">
                    <p id="deleteMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="delete">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>   

    <!-- modal notifikasi delete -->
    <div id="notifDelete" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Status</h4>
                </div>
                <div class="modal-body">
                    <p id="messageNotif"></p>                    
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
</body>

<?php require('footer.php') ?>

<!-- <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/vendor/DataTables/media/css/jquery.dataTables.css"> -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/vendor/DataTables/media/css/dataTables.bootstrap.css">
<script type="text/javascript" src="<?php echo base_url()?>assets/vendor/DataTables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript">

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
        var tabel = "debit"
        var deleteAction =""
        createTabelDebit();

        function showModalBeban(pesan){
            $('#message').html(pesan);
            $("#modalBeban").modal({backdrop: 'static'});
        }

        function closeModalBeban(pesan){
            $('#message').html(pesan);
            setTimeout(function(){$("#modalBeban").modal('hide')}, 1500);
        }        

        // serverSide
        function createTabelDebit(){
            tabel = "debit"
            showModalBeban("Mengambil data beban dari faktur debit");
            $('.table-responsive').append('<table class="table table-striped table-bordered" id="table"><thead></thead><tbody></tbody></table>');
            tabelfaktur = $('#table').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    emptyTable: "tidak ada beban faktur"
                },
                ajax:{
                    url: "<?php echo site_url();?>/faktur/getFakturDatabase?tabel=faktur_debit",
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
                },
                { data: "ACTION",
                  title: "ACTION"
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
            cleanupTabel();
            createTabelDebit();
        });

        function createTabelKredit(){
            tabel = "kredit"
            showModalBeban("Mengambil data beban dari faktur kredit");
            $('.table-responsive').append('<table class="table table-striped table-bordered" id="table"><thead></thead><tbody></tbody></table>');
            tabelfaktur = $('#table').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    emptyTable: "tidak ada beban faktur"
                },
                ajax:{
                    url: "<?php echo site_url();?>/faktur/getFakturDatabase?tabel=faktur_kredit",
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
                },
                { data: "ACTION",
                  title: "ACTION"
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
            cleanupTabel()
            createTabelKredit();
        });

        // delete faktur 
        $(document).on('click','.delete-faktur', function() {
            deleteAction = "individu"
            let noFaktur = $(this).data('id')
            let tabel = $(this).data('tabel')
            let message = 'Anda yakin akan menghapus faktur dengan no faktur <span id="no-faktur" class="text-warning"></span> pada database <span id="tabel-database" class="text-warning"></span>? Setelah terhapus, faktur tidak dapat dikembalikan lagi'            
            $("#deleteMessage").html(message)
            $("#no-faktur").html(noFaktur)
            $("#tabel-database").html(tabel)
            $("#modalConfirm").modal({backdrop: 'static'});            
        });

        $("#delete-all").on('click', () => {
            deleteAction = "all"
            let message = `Anda yakin akan menghapus seluruh faktur pada database <span id="tabel-database" class="text-warning">faktur_${tabel}</span>? Setelah terhapus, faktur tidak dapat dikembalikan lagi`            
            $("#deleteMessage").html(message)
            $("#modalConfirm").modal({backdrop: 'static'})
        })

        $("#delete").on('click', () => {
            let tabel = $("#tabel-database").html()
            let dataFaktur = {}
            if (deleteAction == "individu") {
                let noFaktur = $("#no-faktur").html()
                dataFaktur = JSON.stringify({
                    "NO_FAKTUR": noFaktur,
                    "TABEL": tabel
                })
            }
            else if (deleteAction == "all") {
                dataFaktur = JSON.stringify({
                    "TABEL": tabel
                })
            }
            // console.log(dataFaktur)
            $.ajax({
                url: "<?php echo site_url();?>/faktur/delete",
                type: "POST",
                data: dataFaktur,
                ContentType: 'application/json',
                dataType: 'json', 
                success: function(result, status){
                    $("#messageNotif").html(result.message)
                    $("#notifDelete").modal({backdrop: 'static'})
                    setTimeout(() => {$("#notifDelete").modal('hide')}, 2000)
                    if (result.code == 202) {
                        cleanupTabel()
                        if (tabel == "faktur_debit") {
                            setTimeout(() => {
                                createTabelDebit()
                            }, 1500)
                        }
                        else{
                            setTimeout(() => {
                                createTabelKredit()
                            }, 1500)
                        }
                        informationDatabaseupdate()
                    }                    
                }
            });
        });    

        let cleanupTabel = () => {
            tabelfaktur.destroy(true);
            $('#table_length').remove();
            $('#table_filter').remove();
            $('#table_info').remove();
            $('#table_paginate').remove();                 
        }

        let informationDatabaseupdate = () => {
            $.ajax({
                url: "<?php echo site_url();?>/admin/informationDatabaseupdate",
                type: "GET",
                ContentType: "application/json",
                dataType: "json",
                success: (result, status) => {
                    $("#ppnDebit").html(result.ppnDebit)
                    $("#ppnKredit").html(result.ppnKredit)
                    $("#totalFakturKredit").html(result.totalKredit+" Faktur")
                    $("#totalFakturDebit").html(result.totalDebit+" Faktur")
                }
            })
        }
	});
</script>