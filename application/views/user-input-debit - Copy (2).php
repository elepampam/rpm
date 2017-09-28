<?php require('header.php') ?>
<style type="text/css"></style>
<body>
    <div class="loadingscreen">    
        <div class="modalloading">
            <p id="loadingstatus"></p>
            <div class="loader"></div>
            <p id="loadingmessage"></p>
            <button class="btn btn-primary" id="closeloading">tutup</button>
        </div>
    </div>
	<div class="container">
        <a href="<?php echo site_url(); ?>/home/dashboard">
            <img src="<?php echo base_url(); ?>/assets/images/logo-itdc.png" class="logo-itdc">
        </a>
        <!-- call the debit/kredit view here -->
        <?php 
        if (isset($action) && $action == 'debit') {
            require('action-debit.php');
        }
        elseif(isset($action) && $action == 'kredit'){
            require('action-kredit.php');
        }        
      
        ?>
    </div>
    <?php require('user-action.php') ?>
</body>
<?php require('footer.php') ?>
<script type="text/javascript">
$(document).ready(function(){
    var ppnCount = 0;
    var ppnBmCount = 0;
    var arrayFaktur = [];

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

    $(document).on('change','.checkbox',function(e){
        var index = $(this).data('index');
        if ($(this).is(':checked')) {
            arrayFaktur[index].isChecked = true;            
        }
        else{
            arrayFaktur[index].isChecked = false;
        }
        console.log(JSON.stringify(arrayFaktur));
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
                var table = "<thead><tr><th><div class='dropdown'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Check<span class='caret'></span></button><ul class='dropdown-menu'>  <li><a href='#'>Check all</a></li>  <li><a href='#'>Uncheck all</a></li> </ul></div></th><th>FM</th><th>KD_JENIS_TRANSAKSI</th><th>FG_PENGGANTI</th><th>NOMOR_FAKTUR</th><th>MASA_PAJAK</th><th>TAHUN_PAJAK</th><th>TANGGAL_FAKTUR</th><th>NPWP</th><th>NAMA</th><th>ALAMAT_LENGKAP</th><th>JUMLAH_DPP</th><th>JUMLAH_PPN</th><th>JUMLAH_PPNBM</th><th>IS_CREDITABLE</th></tr></thead><tbody>";
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
                console.log(arrayFaktur);
                table = table + "</tbody>";
                $("#faktur-masuk").text(csvval.length - 1);
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
            // $(".loadingscreen").css('visibility','visible');
            // $(".loadingscreen").css('opacity',1);
            // $("#loadingstatus").text("Menunggu...");
            // $("#closeloading").attr('disabled',true);
            // $("#loadingmessage").html("Faktur yang terproses: <span id='prosesfaktur'></span>");
            // $("#prosesfaktur").text(0);
            var token = "234kfq1n1i401v0tjgm";                
            if (ajaxFaktur(token)){
                     $(".loadingscreen").css('opacity',0);
                     $(".loadingscreen").css('visibility','hidden');    
                }
            $(".loadingscreen").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
                
            });
            
        }
        else{
            alert("input faktur csv pls");
        }
    });
    function ajaxFaktur(token){
        // var jumlahTerproses = 0; 
        // var jumlahGagal = 0;
        // var jumlahSukses = 0;
        // $("#suksesDebit").text(jumlahSukses);
        // $("#gagalDebit").text(jumlahGagal);
        arrayFaktur.map(function(faktur){                
            if (faktur.isChecked == true) {
                var dataFaktur = JSON.stringify({'faktur': faktur.isi,'user': '1'});
                var idFaktur = faktur.isi[1]+faktur.isi[2]+faktur.isi[3];
                $.ajax({
                    type: 'POST',
                    data: dataFaktur,
                    ContentType: 'application/json',
                    dataType: 'json',                     
                    url: "<?php echo site_url(); ?>/tescont/tesajax?token="+token,                        
                    success: function(result, status){                            
                        // $("#prosesfaktur").text(++jumlahTerproses);
                        // console.log('faktur:'+idFaktur);
                        if (result.code == 200) {                                
                            // $("#suksesDebit").text(++jumlahSukses);
                            // $("#"+idFaktur).addClass('success');
                        }
                        else if (result.code == 422) {
                            // $("#gagalDebit").text(++jumlahGagal);
                            // $("#"+idFaktur).addClass('failed');
                        }
                    },
                    error: function(status, textStatus){
                        // console.log(textStatus);
                        // $("#prosesfaktur").text(++jumlahTerproses);
                        // $("#gagalDebit").text(++jumlahGagal);
                        // $("#"+idFaktur).addClass('failed');
                    }
                });   
            }                
        })  
        return true;
    }
    $("#closeloading").click(function(){
        $(".loadingscreen").css('opacity',0);
        $(".loadingscreen").css('visibility','hidden');        
    });
})
</script>