<body>
<!-- the navbar -->
<?php include 'navbar.php'; ?>

<div class="container">
	<div class="header">
		<h4><i class="material-icons">description</i> Detail faktur</h4>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col s12">
			<?php foreach ($hasilfaktur as $key) {
			# code...?>
		 
		<p>No faktur : <?php echo $key -> no_faktur; ?><span class="right">tanggal faktur : <?php echo $tanggal_faktur; ?></span></p>
		<div class="divider"></div>		
		<div id="lawantransaksi">
			<p>Lawan transaksi : <?php echo $key -> nama_perusahaan; ?></p>
			<p>NPWP : <?php echo $key -> npwp; ?></p>
		</div>
		<div class="divider"></div>	
		<div id"userinput">
			<p>User input : <?php echo $key -> nama_user; ?></p>
			<p>tanggal input : <?php echo $tanggal_masuk;?></p>
		</div>
		<div class="divider"></div>
		</div>
	</div>
	<div class="row">
		<div class="col s6">
			<!-- <span class="center">Pajak penjualan atas barang mewah</span>
			<div class="divider"></div> -->
			 <table class="responsive-table">
		        <thead>
		          <tr>
		              <th data-field="id">PPN</th>
		              <th data-field="name">DPP</th>
		              <th data-field="price">PPNBM</th>
		          </tr>
		        </thead>

		        <tbody>
		          <tr>
		            <td><?php echo $key -> ppn; ?></td>
		            <td><?php echo $key -> dpp; ?></td>
		            <td><?php echo $key -> ppnbm; ?></td>
		          </tr>
		        </tbody>
		    </table>
		</div>		
	</div>
	<div class="right-align">
		<div class="row">
			<form method="post" action="<?php echo site_url('faktur/kredit').'?nofaktur='.$key->no_faktur; ?>">
				<div class="input-field col s6">
				    <select name="masa">			      
				      <option value="1" <?php if ($masa == '01') {
				      	echo "selected";
				      } ?>>Januari</option>
				      <option value="2" <?php if ($masa == '02') {
				      	echo "selected";
				      } ?>>Februari</option>
				      <option value="3" <?php if ($masa == '03') {
				      	echo "selected";
				      } ?>>Maret</option>
				      <option value="4" <?php if ($masa == '04') {
				      	echo "selected";
				      } ?>>April</option>
				      <option value="5" <?php if ($masa == '05') {
				      	echo "selected";
				      } ?>>Mei</option>
				      <option value="6" <?php if ($masa == '06') {
				      	echo "selected";
				      } ?>>Juni</option>
				      <option value="7" <?php if ($masa == '07') {
				      	echo "selected";
				      } ?>>Juli</option>
				      <option value="8" <?php if ($masa == '08') {
				      	echo "selected";
				      } ?>>Agustus</option>
				      <option value="9" <?php if ($masa == '09') {
				      	echo "selected";
				      } ?>>September</option>
				      <option value="10" <?php if ($masa == '10') {
				      	echo "selected";
				      } ?>>Oktober</option>
				      <option value="11" <?php if ($masa == '11') {
				      	echo "selected";
				      } ?>>November</option>
				      <option value="12" <?php if ($masa == '12') {
				      	echo "selected";
				      } ?>>Desember</option>

				    </select>
				    <label>Masa</label>
				    <button class="waves-effect waves-light btn right-align" type="submit" name="action">Kredit
				</div>
			</form>
			
			<!-- <a href="<?php echo site_url('faktur/kredit').'?nofaktur='.$key->no_faktur; ?>" class="waves-effect waves-light btn right-align">kredit</a> -->
		</div>
	</div>
	
		<?php } ?>
</div>

<!-- the footer -->
<?php $this->load->view('foot'); ?>
</body>