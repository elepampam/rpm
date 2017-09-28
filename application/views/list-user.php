<?php require('header.php') ?>
<body>
    <div class="container">
        <a href="<?php echo site_url(); ?>/home/dashboard">
            <img src="<?php echo base_url(); ?>/assets/images/logo-itdc.png" class="logo-itdc">
        </a>
        <hr>
        <div class="row" style="position:relative">
        <a href="<?php echo site_url(); ?>/admin/tambahuser" class="btn btn-primary edit" data-toggle="tooltip" title="Klik untuk menambahkan user">Tambah User</a>
            <h3 style="margin-top:10px;text-align:center">MANAGE USER</h3>
            <?php if (isset($usermessage)) {
	            ?>
	            <div class="alert alert-success message" role="alert">
	            	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	                <strong>Berhasil ! User <?php echo $usermessage['username'].'</strong> '.$usermessage['pesan']?>
	            </div>
	            <?php
	        } ?>
            <?php if (is_array($users)) {
            	?>
            	<div class="table-responsive">        
		            <table class="table table-bordered" id="table">
		                <thead>
		                    <tr>
		                        <th style="vertical-align:middle">No</th>
		                        <th style="vertical-align:middle">Username</th>
		                        <th style="vertical-align:middle">Nama</th>
		                        <th style="vertical-align:middle">Password</th>
		                        <th style="vertical-align:middle">Authorisasi</th>
		                        <th style="vertical-align:middle">Action</th>
		                    </tr>
		                </thead>
		                <tbody>
		                <?php
		                $count = 0;
			            	foreach ($users as $userdata) {
			            		?>
					                
					                <tr>
					                	<td><?php echo ++$count;?></td>
					                	<td><?php echo $userdata->username;?></td>
					                	<td><?php echo $userdata->nama_user;?></td>
					                	<td><?php echo $userdata->password;?></td>
					                	<td>
					                		<?php
					                			if ($userdata->level == 1) {
					                				echo "Admin";
					                			}
					                			elseif ($userdata->level == 2) {
					                				echo "User Debit";
					                			}
					                			elseif ($userdata->level == 3) {
					                				echo "User Kredit";
					                			}
					                		?>
					                	</td>
					                	<td>
					                		<?php
					                		if ($userdata->username != $user['username']) {
					                			?>
					                			<a href="<?php echo site_url().'/admin/deleteuser?username='.$userdata->username;?>" class="btn btn-danger" data-toggle="tooltip" title="Delete User" data-id="<?php echo $userdata->username;?>">
					                                <i class="fa fa-trash" aria-hidden="true"></i>
					                            </a>
					                            <a href="<?php echo site_url().'/admin/edituser?username='.$userdata->username;?>" class="btn btn-primary" data-toggle="tooltip" title="Edit User">
				                                	<i class="fa fa-cogs" aria-hidden="true"></i>
				                            	</a>
					                			<?php
					                		}					                		
					                		elseif($userdata->username == $user['username'] && $userdata->level != 1){
					                			?>
					                			<a href="<?php echo site_url().'/user/edit?username='.$userdata->username;?>" class="btn btn-primary" data-toggle="tooltip" title="Edit User">
					                                <i class="fa fa-cogs" aria-hidden="true"></i>
					                            </a>
					                			<?php
					                		}
					                		?>
				                            
					                	</td>
					                </tr>					                
			            		<?php
			            	}
			            } 
			            ?>
		                </tbody>
	            	</table>
	            </div>
        </div>
	</div>
    <?php require('user-action.php') ?>
</body>
<?php require('footer.php') ?>
<script type="text/javascript">
	$(document).ready(function(e){
		$('.btn-danger').click(function(){
			return confirm('Yakin ingin menghapus user '+$(this).attr('data-id')+' ? ');
		});
	});
</script>
</html>
