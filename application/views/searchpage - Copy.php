<?php require('header.php') ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<style type="text/css">
	.box-input{
		padding: 0;

	}
	.box-input .form-control,
	.box-input .btn{
		width: 100%;
		border-radius: 0;
	}
</style>
<body>
	<div class="container">
        <a href="<?php echo site_url(); ?>/home/dashboard">
            <img src="<?php echo base_url(); ?>/assets/images/logo-itdc.png" class="logo-itdc">
        </a>        
        <div class="row" style="text-align:center;margin-bottom:10px;">
            <h3 style="margin-top:10px;">PENCARIAN</h3>
            <?php echo form_open_multipart('faktur/search',array('method' => 'get'));?>
<!--             <div class="col-md-12" style="text-align:right">
            	<label>Lakukan Pencarian pada : </label>
	        	<label class="radio-inline"><input type="radio" name="table" value="debit" checked="true">Tabel Faktur Debit</label>
				<label class="radio-inline"><input type="radio" name="table" value="kredit">Tabel Faktur Kredit</label>
				<label class="radio-inline"><input type="radio" name="table" value="debitnkredit">Tabel Faktur Debit & Kredit</label>	
	        </div> -->
<!--             	<div class="col-md-2 col-md-offset-1 box-input">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Perusahaan...">                	
            	</div>
            	<div class="col-md-2 box-input">
                    <input type="text" name="nofaktur" class="form-control" placeholder="No Faktur...">                	
            	</div>
            	<div class="col-md-2 box-input date">
                    <input type="text" name="tanggal" class="form-control text" placeholder="Tanggal Faktur..." id="tanggal-faktur">
            	</div>
            	<div class="col-md-2 box-input">                    
                    <select class="form-control" name="masa">
                		<option disabled="true" selected="true">Masa...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
            	</div>
            	<div class="col-md-2 box-input">
                    <input type="submit" class="btn btn-primary" value="Cari">                	
            	</div> -->
            </form>
        </div> 
        <div class="row">
        	<div class="col-md-12" style="text-align:center;margin-bottom:15px">
		        <span id="box-debit">&nbsp;&nbsp;&nbsp;</span>
		        <small>Faktur Debit</small>
		        <span id="box-kredit">&nbsp;&nbsp;&nbsp;</span>
		        <small>Faktur Kredit</small>
		    </div>
        </div>
        <div class="table-responsive">        

        </div>       
    </div>
<?php require('user-action.php') ?>
</body>


<?php require('footer.php') ?>
<script type="text/javascript" src="<?php echo base_url()?>/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
	$('#tanggal-faktur').datepicker({
	});
</script>

<script type="text/javascript">
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
	$( document ).ready(function() {
	    var temp = document.getElementsByClassName('torp');
	    for (var i = 0; i < temp.length; i++) {
	    	temp[i].innerHTML = toRp(temp[i].innerHTML);
	    }
	    console.log(temp);
	});
</script>