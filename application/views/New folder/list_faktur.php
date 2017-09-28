<body>
<!-- the navbar -->
<?php include 'navbar.php'; ?>
<div class="container">
	<div class="row">
		<div class="col s12">
			<h4 class="center">List faktur</h4>
		</div>
		<div class="divider"></div>
		<div class="col s12">
			<div class="row">
				<?php echo form_open('faktur/search'); ?>
				<div class="input-field col">
		          <i class="material-icons prefix">search</i>
		          <input name="input_search" id="icon_prefix" type="text" class="validate">
		          <label for="icon_prefix">Search</label>
		        </div>
			</div>
		</div>
		<div class="col s12">
			<table class="responsive-table">
			    <thead>
			        <tr>
			            <th data-field="no">No</th>
			            <th data-field="no_faktur">No faktur</th>
			            <th data-field="kode_transaksi">Kode transaksi</th>
			            <th data-field="lawan_transaksi">Lawan transaksi</th>
			            <th data-field="tanggal_masuk">Tanggal masuk</th>
			            <th data-field="status">Status</th>
			            <th data-field="action">Aksi</th>
			        </tr>
			    </thead>

			     <tbody>
			     	<?php
			     	$no = 1; 
			     	foreach ($faktur as $key) {
			     		?>
			     		<tr>
			     			<td><?php echo $no; ?></td>
			     			<td><?php echo $key -> no_faktur; ?></td>
			     			<td><?php echo $key -> kode_transaksi; ?></td>
			     			<td><?php echo $key -> nama_perusahaan; ?></td>
			     			<td><?php echo $key -> tanggal_masuk; ?></td>
			     			<td><?php echo $key -> status; ?></td>
			     			<td><a class="waves-effect waves-light btn">
			     					<i class="material-icons">search</i>
			     				</a>
			     				<a class="waves-effect waves-light btn">
			     					<i class="material-icons">delete</i>
			     				</a>
			     			</td>			            
			        	</tr>
			     		<?php $no++;
			     	} ?>
			    </tbody>
			</table>
		</div>
	</div>
</div>
<!-- the footer -->
<?php $this->load->view('foot'); ?>
</body>