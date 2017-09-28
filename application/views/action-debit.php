<div class="row" style="text-align:center">
    <h3 style="margin-top:10px;">INPUT PAJAK MASUKKAN</h3>
    <div class="col-md-12 alert alert-info box-input">
        <p>Masukkan <strong>file .csv</strong> dari pajak</p>                            
            <div class="input-section">
                <div class="form-control">
                    <input type="text" name="form-file-csv" class="" id="form-file-csv" readonly="true" placeholder="filename....">
                    <span id="file-name"></span>
                    <label class="btn btn-default upload-file-btn">
                        <i class="fa fa-file-o" aria-hidden="true"></i>
                        <input type="file" name="file-csv" hidden="true" id="input-csv">
                    </label>
                </div>
            </div>
        <input type="submit" class="btn btn-primary" value="posting" id="submit">                
    </div>
</div>
<div class="row faktur-information">
    <div class="col-md-6 col-sm-6 isi-faktur">
        <p>Jumlah faktur masuk : <strong id="faktur-masuk"></strong></p>
        <p>Jumlah PPN : <strong id="jumlah-ppn"></strong></p>
        <p>Jumlah PPnBM : <strong id="jumlah-ppnbm"></strong></p>
    </div>
    <div class="col-md-6 col-sm-6 action-faktur">
        <p>Sukses Debit : <strong id="suksesDebit"></strong></p>
        <p>Gagal Debit : <strong id="gagalDebit"></strong></p>
        <span class="sukses-faktur">&nbsp;&nbsp;&nbsp;</span>
        <small>Sukses Debit</small>
        <span class="gagal-faktur">&nbsp;&nbsp;&nbsp;</span>
        <small>Gagal Debit</small>
    </div>
    
</div>
<div class="table-responsive">
    <table class="table table-bordered" id="tableFaktur" style="margin-bottom:0;">
    </table>
</div>
<script type="text/javascript">
// $("#myModal").on('shown.bs.modal', function(){
//     var token = "234kfq1n1i401v0tjgm";
//     debitFaktur(token)();
// })

// function debitFaktur(token){
//     var jumlahTerproses = 0; 
//     jumlahGagal = 0;
//     jumlahSukses = 0;
//     var current = 0;
//     var chunkSize = 1;  
//     $("#prosesfaktur").text(jumlahTerproses);     
//     return function(){                       
//         for (var i = 0; i < chunkSize; i++) {
//             // console.log(arrayFaktur[current+i]);
//             // console.log("sebelum"+current);
//             if (arrayFaktur[current+i].isChecked) {
//                 var dataFaktur = JSON.stringify({'faktur': arrayFaktur[current+i].isi, 'user': '1'});
//                 var idFaktur = arrayFaktur[current+i].isi[1]+arrayFaktur[current+i].isi[2]+arrayFaktur[current+i].isi[3];                    
//                 $.ajax({
//                     type: 'POST',
//                     data: dataFaktur,
//                     ContentType: 'application/json',
//                     dataType: 'json',                     
//                     url: "<?php echo site_url(); ?>/tescont/tesajax?token="+token,                        
//                     success: function(result, status){                            
//                         $("#prosesfaktur").text(++jumlahTerproses);
//                         // console.log('faktur:'+idFaktur);
//                         if (result.code == 200) {                                
//                            ++jumlahSukses;
//                             $("#"+idFaktur).addClass('success');
//                         }
//                         else if (result.code == 422) {
//                             ++jumlahGagal;
//                             $("#"+idFaktur).addClass('failed');
//                         }
//                     },
//                     error: function(status, textStatus){
//                         // console.log(textStatus);
//                         $("#prosesfaktur").text(++jumlahTerproses);
//                         ++jumlahGagal;
//                         $("#"+idFaktur).addClass('failed');
//                     }
//                 });   
//             }
//         }
        
//         current  = current + chunkSize;
//         // console.log("sesudah"+current);
//         if (current < arrayFaktur.length) {
//             setTimeout(arguments.callee, 10);
//         }
//         if (current == arrayFaktur.length){
//             $("#loadingstatus").text("Selesai!");
//             $("#closeloading").attr('disabled',false);
//         }
//     }
// }
</script>