<style type="text/css">
    #autoSuggestionsList > li {
         background: none repeat scroll 0 0 #F3F3F3;
         border-bottom: 1px solid #E3E3E3;
         list-style: none outside none;
         padding: 3px 15px 3px 15px;
         text-align: left;
    }
    #autoSuggestionsList > li a { color: #800000; }
    .auto_list {
         z-index: 10000;
         border: 1px solid #E3E3E3;
         border-radius: 5px 5px 5px 5px;
         position: absolute;
    }
</style>
<body>
<!-- the navbar -->
<?php $this->load->view('navbar'); ?>

<div class="container">
	<h4 class="header">Masukkan data faktur</h4>
	<div class="divider"></div>
	<?php echo form_open('faktur/insert'); ?>

  <div class="row">
    <div class="col s12 m6 l6">
      <p  class="col s12">
        <span>Jenis kedatangan faktur</span>
      </p>
      <p class="col s3"> 
        <input class="with-gap" name="jeniskedatangan" type="radio" id="kedatangan1" value="1" onclick="radiofunc(this.value)" checked/>
        <label for="kedatangan1">Normal</label>
      </p>
      <p  class="col s3">
        <input class="with-gap" name="jeniskedatangan" type="radio" id="kedatangan2" value="2" onclick="radiofunc(this.value)"/>
        <label for="kedatangan2">Menyusul</label>
      </p>
      <p  class="col s3">
        <input class="with-gap" name="jeniskedatangan" type="radio" id="kedatangan3" value="3" onclick="radiofunc(this.value)"/>
        <label for="kedatangan3">Salah</label>
      </p>    
      <p  class="col s12">
        <span>kode transaksi</span>
      </p>
      <p class="col s3"> 
        <input class="with-gap" name="kodetransaksi" type="radio" id="kode1" value="1" onclick="radiofunc2(this.value)" checked/>
        <label for="kode1">Normal</label>
      </p>
      <p  class="col s3">
        <input class="with-gap" name="kodetransaksi" type="radio" id="kode2" value="2" onclick="radiofunc2(this.value)"  />
        <label for="kode2">Wapu</label>
      </p>
      <p  class="col s3">
        <input class="with-gap" name="kodetransaksi" type="radio" id="kode3" value="3" onclick="radiofunc2(this.value)"  />
        <label for="kode3">Fasilitas</label>
      </p>    
    </div>
    <div class="col s12 m6 l6">
        <div class="input-field col s12">
          <input placeholder="00X.XXX.XX.XXXXXXXX" name="nofaktur" id="nofaktur" type="text" class="validate <?php if (form_error('nofaktur')) {
            echo "invalid";
          } ?>" onkeyup="format()" length="19" maxlength="19" value="<?php echo set_value('nofaktur'); ?>" data-error="wrong">
          <label for="nofaktur">No faktur </label>
        </div>
        <div class="input-field col s6">
          <input placeholder="00.XXX.XXX.XX-XXX.XXX" name="nonpwp" id="nonpwp" type="text" class="validate" onkeyup="formatNPWP()" length="20" maxlength="20">
          <label for="nonpwp">NPWP lawan</label>
        </div>
        <div class="input-field col s6">
          <input placeholder="PT.ABCEFGHIJK" name="namapt" id="namapt" type="text" class="validate">
          <label for="namapt">Lawan transaksi</label>
        </div>
        <div class="input-field col s12">
          <label for="tanggal">Tanggal faktur</label>
          <input name="date" placeholder="day/month/year" type="text" class="datepicker">
        </div>
        <div class="input-field col s4">
          <input placeholder="" name="dpp" id="dpp" type="number" class="validate" onfocusout="hitungppn(10)" size="number" onkeydown="cekangka()">
          <label for="dpp">DPP</label>
        </div>
        <div class="input-field col s4">
          <input placeholder="" name="ppn" id="ppn" type="number" class="validate" size="number">
          <label for="ppn">PPN</label>
        </div>
        <div class="input-field col s4">
          <input placeholder=""name="ppnbm" id="ppnbm" type="number" class="validate" size="number">
          <label for="ppnbm">PPNBM</label>
        </div>
    </div>
  </div>
      <div class="row">
        <div class="input-field col s12">
          <textarea name="uraian"id="textarea1" class="materialize-textarea"></textarea>
          <label for="textarea1">Uraian</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field">
           <button class="btn waves-effect waves-light" type="submit" name="action">Submit
		    	<i class="material-icons right">send</i>
			</button>
        </div>
      </div>
</div>
</body>

<?php $this->load->view('foot'); ?>
<script type="text/javascript">
        function ajaxSearch() {
            var input_data = $('#nonpwp').val();
            console.log(input_data);
            if (input_data.length === 0) {
                $('#suggestions').hide();
            } else {

                var post_data = {
                    'search_data': input_data
                };

                $.ajax({
                    type: "POST"
 ,                   url: "<?php echo site_url(); ?>/faktur/autocomplete/",
                    data: post_data,
                    success: function(data) {
                        // return success
                        console.log('succes');
                        if (data.length > 0) {
                            $('#suggestions').show();
                            $('#autoSuggestionsList').addClass('auto_list');
                            $('#autoSuggestionsList').html(data);
                        }
                    }
                });

            }
        }
</script>