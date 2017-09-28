<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-dashboard.css'); ?>">
<script type="text/javascript">
function dialog(pesan){
	alert(pesan);
}
</script>
<body <?php if (isset($pesan)) {
	?>
	onload="alert('Faktur tersimpan')"
	<?php 
} ?>>
<!-- the navbar -->
<?php include 'navbar.php'; ?>

	<div class="container isi">
		<!-- <nav>
	    <div class="nav-wrapper">
	      <div class="col s12">
	        <a href="#!" class="breadcrumb">Dashboard</a>
	      </div>
	    </div>
	  </nav> -->
		<div class="row">
	      <div class="grid-example col l4 m12 s12">
	      	<a href="<?php echo site_url('faktur/create'); ?>">
	      	  <div class="card small hoverable">
	            <div class="card-image">
	              <img src="<?php echo base_url('assets/images/sample.jpg') ?>">
	              <span class="card-title indigo-text darken-4">Rekam</span>
	            </div>
	            <div class="card-content">
	              <p>
	              	Gunakan fungsi ini untuk mencatat seluruh faktur pajak yang sudah diakui sebagai pajak masukan dalam sistem erp.
	              </p>
	            </div>
	          </div>
	        </a>
	      </div>
	      <div class="grid-example col l4 m12 s12">
	      	<a href="<?php echo site_url('faktur/cek') ?>">
	      	  <div class="card small hoverable">
	            <div class="card-image">
	              <img src="<?php echo base_url('assets/images/sample-2.jpg') ?>">
	              <span class="card-title indigo-text darken-4">Cek faktur</span>
	            </div>
	            <div class="card-content">
	              <p>
	              	Masuk kedalam fungsi ini untuk melihat semua faktur yang ada dan melakukan kredit terhadap suatu faktur.
	              </p>
	            </div>
	          </div>
	        </a>
	      </div>
	      <div class="col l4 m12 s12">
	      	<a class="modal-trigger" href="#modal-rekon">
	      	  <div class="card small hoverable">
	            <div class="card-image">
	              <img src="<?php echo base_url('assets/images/sample-3.jpg') ?>">
	              <span class="card-title indigo-text darken-4">Rekonsiliasli !</span>
	            </div>
	            <div class="card-content">
	              <p>
	              	Gunakan fungsi ini untuk merekonsiliasi pajak masukan dan menghasilkan laporan rekonsiliasi sesuai kebutuhan anda.
	              </p>
	            </div>
	          </div>
	        </a>
	      </div>
	    </div>
	</div>

	 <!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h4>Kredit faktur</h4>
      <p>Masukkan no faktur yang hendak di kreditkan : </p>
      <?php echo form_open('faktur/cari'); ?>
      	<input placeholder="00X.XXX.XX.XXXXXXXX" name="faktur" id="nofaktur" type="text" class="validate" onkeyup="format()" length="20" maxlength="20">      
    </div>
    <div class="modal-footer">
      <button type="submit" href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Submit</button>
      </form>
    </div>
  </div>

  <!-- modal rekon -->
  <div id="modal-rekon" class="modal">
    <div class="modal-content">
      <h4>Rekonsliasi </h4>
      <p>Lakukan rekonsliasi berdasarkan kondisi yang diinginkan : </p>
      <?php echo form_open('faktur/rpm'); ?>
      	<div class="row">
      		<div class="col s5">
		      <p  class="col s12">
		        <span>Status faktur</span>
		      </p>
		      <p class="col s12"> 
		        <input class="with-gap" name="jenisstatus" type="radio" id="status1" value="SK" onclick="cekrekon(this.value)" checked/>
		        <label for="status1">Sudah kredit</label>
		      </p>
		      <p  class="col s12">
		        <input class="with-gap" name="jenisstatus" type="radio" id="status2" value="BK" onclick="cekrekon(this.value)"/>
		        <label for="status2">Belum kredit</label>
		      </p>
		      <p  class="col s12">
		        <input class="with-gap" name="jenisstatus" type="radio" id="status3" value="SS" onclick="cekrekon(this.value)"/>
		        <label for="status3">Menyusul</label>
		      </p>
		      <p  class="col s12">
		        <input class="with-gap" name="jenisstatus" type="radio" id="status4" value="S" onclick="cekrekon(this.value)"/>
		        <label for="status4">Salah</label>
		      </p>  
		    </div>
		    <div class="col s7">
		    	<div class="input-field col s12">
		          <input value="<?php echo $user['nama']; ?>"name="user" id="user" type="text" class="validate">
		          <label for="user">User kredit</label>
		        </div>
		          <p  class="col s12">
			        <span>Periode</span>
			      </p>
		        <div class="input-field col s12 m6 l6">
		          <label for="tanggal1">dari</label>
		          <input id="tanggal1" name="date1" placeholder="day/month/year" type="text" class="datepicker">
		        </div>
		        <div class="input-field col s12 m6 l6">
		          <label for="tanggal2">hingga</label>
		          <input id="tanggal2" name="date2" placeholder="day/month/year" type="text" class="datepicker">
		        </div>
		    </div> 
      	</div>  
    </div>
    <div class="modal-footer">
      <button type="submit" href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Submit</button>
      </form>
    </div>
  </div>
	<?php $this->load->view('foot'); ?>
</body>
