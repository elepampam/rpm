<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-dashboard.css'); ?>">
<script type="text/javascript">
function dialog(pesan){
	alert(pesan);
}
</script>
<body>
<!-- the navbar -->
	<?php include 'navbar.php'; ?>

	<div class="container">
		<div class="row">
			<h4 class="header">Masukkan data faktur</h4>
			<div class="divider"></div>
			<button class="btn right" style="margin-top:10px;">kredit</button>
		</div>
	</div>
	<?php $this->load->view('foot'); ?>
</body>
