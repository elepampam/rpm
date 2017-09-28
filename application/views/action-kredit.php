<div class="row" style="text-align:center">
    <h3 style="margin-top:10px;">KREDIT PAJAK MASUKKAN</h3>
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
        <span>Masa Pengkredittan : </span>
        <div class="form-group">
            <span>Bulan : </span>
            <select class="form-control" name="masa-bulan" style="width:auto;display:inline-block" id="masa-bulan">
            </select>
            <span>Tahun : </span>
            <select class="form-control" name="masa-tahun" style="width:auto;display:inline-block" id="masa-tahun">                           
            </select>
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
        <small>Sukses Kredit</small>
        <span class="gagal-faktur">&nbsp;&nbsp;&nbsp;</span>
        <small>Gagal Kredit</small>
    </div>
    
</div>
<div class="table-responsive">
    <table class="table table-bordered" id="tableFaktur" style="margin-bottom:0;">
    </table>
</div>

<script type="text/javascript">
$( document ).ready(function() {
    var d = new Date();
    for (var i = d.getMonth(); i > 0; i--) {
        $('#masa-bulan').append('<option value="'+(i+1)+'">'+(i+1)+'</option>')
    }
    for (var i = d.getFullYear(); i > (d.getFullYear()-15); i--) {
        $('#masa-tahun').append('<option value="'+i+'">'+i+'</option>')        
    }
});
</script>