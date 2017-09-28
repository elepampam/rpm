<?php require('header.php') ?>
<body>
	<div class="container">
        <a href="<?php echo site_url(); ?>/home/dashboard">
            <img src="<?php echo base_url(); ?>/assets/images/logo-itdc.png" class="logo-itdc">
        </a>        
        <hr>
        <div class="row" style="text-align:center;margin-bottom:10px;">
            <h3 style="margin-top:10px;">PENCARIAN</h3>

        </div> 
        <div class="row">
        	<div class="col-md-12" style="text-align:center;margin-bottom:15px">
		        <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab" id="debittab">Data Debit</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" id="kredittab">Data Kredit</a></li>
                </ul>                
		    </div>
        </div>
        <div id="tempTableHead"></div>
        <div class="table-responsive" style="position: relative">
        </div>
        <div id="tempTableFoot" style="margin-bottom: 25px"></div>
    </div>    
    <!-- modal ambil faktur -->
    <div id="modalFaktur" class="modal fade" role="dialog">
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
	<?php require('user-action.php') ?>
</body>


<?php require('footer.php') ?>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/vendor/DataTables/media/css/dataTables.bootstrap.css">
<script type="text/javascript" src="<?php echo base_url()?>assets/vendor/DataTables/media/js/jquery.dataTables.js"></script>
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
		let columnDebit = [
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
            { data: "STATUS",
              title: "STATUS"
            }
        ];

        let columKredit = [
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
                { data: "MASA_KREDIT",
                  title: "MASA_KREDIT"
                },
                { data: "TAHUN_KREDIT",
            	  title: "TAHUN_KREDIT"
            	},
                { data: "USER_INPUT",
                  title: "USER_INPUT"
                },
                { data: "DATE_INPUT",
                  title: "DATE_INPUT"
                },
                { data: "STATUS",
                  title: "STATUS"
                }
            ]
	    var temp = document.getElementsByClassName('torp');
	    for (var i = 0; i < temp.length; i++) {
	    	temp[i].innerHTML = toRp(temp[i].innerHTML);
	    }

	    var tabelFaktur;
	    createTabel('faktur_debit', 'Mengambil data dari tabel debet');

	    function showModalFaktur(message){
	    	$('#message').html(message);
	    	$('#modalFaktur').modal();
	    }

	    function closeModalFaktur(message){
	    	$('#message').html(message);
	    	setTimeout(function(){$("#modalFaktur").modal('hide')}, 1500);	    	
	    }

	    $('#debittab').on('click',function(e){
	    	tabelfaktur.destroy(true);
            $('#table_length').remove();
            $('#table_filter').remove();
            $('#table_info').remove();
            $('#table_paginate').remove();                             
	    	createTabel('faktur_debit', 'Mengambil data dari tabel debet');
	    });

	    $('#kredittab').on('click', function(e){
	    	tabelfaktur.destroy(true);
            $('#table_length').remove();
            $('#table_filter').remove();
            $('#table_info').remove();
            $('#table_paginate').remove();                             
	    	createTabel('faktur_kredit', 'Mengambil data dari tabel kredit');
	    });

	    function createTabel(tabel, message){
	    	if (tabel == 'faktur_debit') {
	    		column = columnDebit;
	    	}
	    	else if (tabel == 'faktur_kredit') {
	    		column = columKredit;
	    	}
	    	showModalFaktur(message);
	    	$('.table-responsive').append('<table class="table table-striped table-bordered" id="table"><thead></thead><tbody></tbody></table>');
	    	tabelfaktur = $('#table').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    emptyTable: "tidak ada beban faktur"
                },
                ajax:{
                    url: "<?php echo site_url();?>/faktur/search?tabel="+tabel,
                    dataType: "json",
                    type: "POST",

                },
                columns: column,
            initComplete: function(setting, json){
                closeModalFaktur('Data faktur telah berhasil diambil');
                $('#table_length').appendTo('#tempTableHead');
		        $('#table_filter').appendTo('#tempTableHead');
		        $('#table_info').appendTo('#tempTableFoot');
		        $('#table_paginate').appendTo('#tempTableFoot');                
            }  
            });
	    }
	});
</script>