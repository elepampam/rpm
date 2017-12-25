<div class="row" style="text-align:center;position: relative;">
    <h3 style="margin-top:10px;">INPUT PAJAK MASUKAN</h3>
    <a href="<?php echo site_url() ?>/admin/debitKhusus" class="btn btn-primary btn-pajak-khusus">Pajak Masukan Khusus</a>
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
