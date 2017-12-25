<?php require('header.php') ?>
<body>
	<div class="container">
        <a href="<?php echo site_url(); ?>/home/dashboard">
            <img src="<?php echo base_url(); ?>/assets/images/logo-itdc.png" class="logo-itdc">
        </a>
        <!-- call the debit/kredit view here -->
        <ul class="nav nav-tabs">
            <li <?php if(isset($action) && $action == 'debit') echo 'class="active"'; ?>><a href="<?php echo site_url()?>/admin/debit">DEBIT</a></li>
            <li <?php if(isset($action) && $action == 'kredit') echo 'class="active"'; ?>><a href="<?php echo site_url()?>/admin/kredit">KREDIT</a></li>
        </ul>
        <?php
        if (isset($action) && $action == 'debit') {
            require('admin-input-debit.php');
        }
        elseif(isset($action) && $action == 'kredit'){
            require('admin-input-kredit.php');
        }        

        ?>
    </div>
    <?php require('user-action.php') ?>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-body">
                <p id="loadingstatus"></p>
                <div class="loader"></div>
                <p id="loadingmessage"></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="closeloading">Close</button>
              </div>
            </div>
        </div>
    </div>
</body>
<?php require('footer.php') ?>
<script type="text/javascript">
$(document).ready(function(){
    var action = "<?php echo $action; ?>";
    var url = '';
    var ppnCount = 0;
    var ppnBmCount = 0;
    var arrayFaktur = [];
    // var jumlahTerproses = 0;
    var jumlahGagal = 0;
    var jumlahSukses = 0;
    if (action == 'debit') {
        url = "<?php echo site_url(); ?>/faktur/debitfaktur?token=";
    }
    else{
        url = "<?php echo site_url(); ?>/faktur/kreditfaktur?token=";
    }

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

    $(document).on('click','#checkall',function(event){
        event.preventDefault();
        arrayFaktur.map(function(faktur, index){
            if (faktur.isChecked == false) {
                faktur.isChecked = true;
                $("#"+faktur.isi[1]+faktur.isi[2]+faktur.isi[3]).find("input").prop('checked',true);
            }
        });
    });

    $(document).on('click','#uncheckall',function(event){
        event.preventDefault();
        arrayFaktur.map(function(faktur, index){
            if (faktur.isChecked == true) {
                faktur.isChecked = false;
                $("#"+faktur.isi[1]+faktur.isi[2]+faktur.isi[3]).find("input").prop('checked',false);
            }
        });
    });

    $(document).on('change','.checkbox',function(e){
        var index = $(this).data('index');
        if ($(this).is(':checked')) {
            arrayFaktur[index].isChecked = true;
        }
        else{
            arrayFaktur[index].isChecked = false;
        }
    })

    $('#input-csv').change(function(e) {
        var ext = $('#input-csv').val().split(".").pop().toLowerCase();
        if ($.inArray(ext, ["csv"]) == -1) {
            alert('Upload CSV');
            return false;
        } else {
            $('#form-file-csv').val($('#input-csv').val().split("\\").pop());
        }

        if (e.target.files != undefined) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var table = "<thead><tr><th><div class='dropdown'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Check<span class='caret'></span></button><ul class='dropdown-menu'><li><a href='#' id='checkall'>Check all</a></li><li><a href='#' id='uncheckall'>Uncheck all</a></li> </ul></div></th><th>FM</th><th>KD_JENIS_TRANSAKSI</th><th>FG_PENGGANTI</th><th>NOMOR_FAKTUR</th><th>MASA_PAJAK</th><th>TAHUN_PAJAK</th><th>TANGGAL_FAKTUR</th><th>NPWP</th><th>NAMA</th><th>ALAMAT_LENGKAP</th><th>JUMLAH_DPP</th><th>JUMLAH_PPN</th><th>JUMLAH_PPNBM</th><th>IS_CREDITABLE</th></tr></thead><tbody>";
                var csvval = e.target.result.split("\n");
                for (var i = 1; i < csvval.length; i++) {
                    if (csvval[i] == "") {
                        continue;
                    }
                    arrayFaktur.push({"isChecked":true,"isi":[]});
                    var fakturValue = csvval[i].split('","');
                    var row = "<tr id='"+fakturValue[1]+fakturValue[2]+fakturValue[3]+"'>";
                    row = row + "<td>" + "<input type='checkbox' class='checkbox' checked='true' data-index='"+(i-1)+"'/>" + "</td>";
                    for (var j = 0; j < fakturValue.length; j++) {
                        row = row + "<td>" + fakturValue[j].replace('"', '') + "</td>";
                        arrayFaktur[i-1].isi.push(fakturValue[j].replace('"', ''));
                        if (j == 11) {
                            hitungPpn(parseInt(fakturValue[j].replace('"', '')));
                        } else if (j == 12) {
                            hitungPpnBm(parseInt(fakturValue[j].replace('"', '')));
                        }
                    }
                    table = table + row + "</tr>";
                }
                // console.log(arrayFaktur);
                table = table + "</tbody>";
                $("#faktur-masuk").text(csvval.length - 2);
                $("#jumlah-ppn").text(toRp(ppnCount));
                $("#jumlah-ppnbm").text(toRp(ppnBmCount));
                $('#tableFaktur').append(table);
                $('.message').remove();
                $('#failed').remove();
            };
            reader.readAsText(e.target.files.item(0));
        }

        return false;
    });

    $('#form-file-csv').click(function(e) {
        e.preventDefault();
        $('#input-csv').click();
        return false;
    })

    $("#submit").on('click', function(e){
        if (arrayFaktur.length > 0) {
            $("#loadingstatus").text("Menunggu...");
            $("#closeloading").attr('disabled',true);
            $("#loadingmessage").html("Faktur yang terproses: <span id='prosesfaktur'></span>");
            $("#myModal").modal({'backdrop': 'static'});
        }
        else{
            alert("input faktur csv pls");
        }
    });
    $("#myModal").on('shown.bs.modal', function(){
        var token = "234kfq1n1i401v0tjgm";
        if (action == 'debit') {
            debitFaktur(token, url)();
        }
        else{
            kreditFaktur(token, url)();
        }
    })

    // for debit
    function debitFaktur(token, url){
        var tidakDiproses = 0;
        // var jumlahTerproses = 0;
        jumlahGagal = 0;
        jumlahSukses = 0;
        var current = 0;
        var chunkSize = 1;
        $("#prosesfaktur").text(current);
        return function(){
            for (var i = 0; i < chunkSize; i++) {
                // console.log(arrayFaktur[current+i]);
                // console.log("sebelum"+current);
                if (arrayFaktur[current+i].isChecked) {
                    var dataFaktur = JSON.stringify({'faktur': arrayFaktur[current+i].isi, 'user': '1'});
                    var idFaktur = arrayFaktur[current+i].isi[1]+arrayFaktur[current+i].isi[2]+arrayFaktur[current+i].isi[3];
                    $.ajax({
                        type: 'POST',
                        data: dataFaktur,
                        ContentType: 'application/json',
                        dataType: 'json',
                        url: url+token,
                        success: function(result, status){
                            $("#prosesfaktur").text((current - tidakDiproses));
                            // console.log('faktur:'+idFaktur);
                            if (result.code == 200) {
                               ++jumlahSukses;
                                $("#"+idFaktur).addClass('success');
                            }
                            else if (result.code == 422) {
                                ++jumlahGagal;
                                $("#"+idFaktur).addClass('failed');
                            }
                        },
                        error: function(status, textStatus){
                            // console.log(textStatus);
                            $("#prosesfaktur").text((current - tidakDiproses));
                            ++jumlahGagal;
                            $("#"+idFaktur).addClass('failed');
                        }
                    });
                }
                else{
                    tidakDiproses++;
                }
            }

            current  = current + chunkSize;
            if (current < arrayFaktur.length) {
                setTimeout(arguments.callee, 10);
            }
            if (current == arrayFaktur.length){
                setTimeout(function(){
                    $("#loadingstatus").text("Selesai!");
                    $("#closeloading").attr('disabled',false);
                }, 3000);
            }
        }
    }

    // for kredit
    function kreditFaktur(token, url){
        var tidakDiproses = 0;
        // var jumlahTerproses = 0;
        jumlahGagal = 0;
        jumlahSukses = 0;
        var current = 0;
        var chunkSize = 1;
        $("#prosesfaktur").text(current);
        return function(){
            for (var i = 0; i < chunkSize; i++) {
                // console.log(arrayFaktur[current+i]);
                // console.log("sebelum"+current);
                if (arrayFaktur[current+i].isChecked) {
                    var dataFaktur = JSON.stringify({
                        'faktur': arrayFaktur[current+i].isi,
                        'user': '1',
                        'masa_kredit': $('#masa-bulan').val(),
                        'tahun_kredit': $('#masa-tahun').val()
                    });
                    // console.log(dataFaktur);
                    var idFaktur = arrayFaktur[current+i].isi[1]+arrayFaktur[current+i].isi[2]+arrayFaktur[current+i].isi[3];
                    $.ajax({
                        type: 'POST',
                        data: dataFaktur,
                        ContentType: 'application/json',
                        dataType: 'json',
                        url: url+token,
                        success: function(result, status){
                            $("#prosesfaktur").text((current - tidakDiproses));
                            // console.log('faktur:'+idFaktur);
                            if (result.code == 200) {
                               ++jumlahSukses;
                                $("#"+idFaktur).addClass('success');
                            }
                            else if (result.code == 422) {
                                ++jumlahGagal;
                                $("#"+idFaktur).addClass('failed');
                            }
                        },
                        error: function(status, textStatus){
                            // console.log(textStatus);
                            $("#prosesfaktur").text((current - tidakDiproses));
                            ++jumlahGagal;
                            $("#"+idFaktur).addClass('failed');
                        }
                    });
                }
                else{
                    tidakDiproses++;
                }
            }

            current  = current + chunkSize;
            // console.log("sesudah"+current);
            if (current < arrayFaktur.length) {
                setTimeout(arguments.callee, 10);
            }
            if (current == arrayFaktur.length){
                setTimeout(function(){
                    $("#loadingstatus").text("Selesai!");
                    $("#closeloading").attr('disabled',false);
                }, 2000);
            }
        }
    }
    $("#closeloading").click(function(){
        $("#gagalDebit").text(jumlahGagal);
        $("#suksesDebit").text(jumlahSukses);
        $(".loadingscreen").css('opacity',0);
        $(".loadingscreen").css('visibility','hidden');
        $("body").css('overflow-y','visible');
    });
})
</script>
