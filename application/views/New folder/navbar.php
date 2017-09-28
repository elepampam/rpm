	<div>
		<ul id="dropdown1" class="dropdown-content">
		  <li><a href="<?php echo site_url('home/logout'); ?>">Log out</a></li>
		  <li class="divider"></li>
		  <li><a href="">Help </a></li>
		</ul>
		<nav class="indigo">
		    <div class="nav-wrapper container ">
		      <a href="<?php echo site_url('home/dashboard'); ?>" class="brand-logo"><img src="<?php echo base_url()?>/assets/images/brand-logo.png"></a>
		      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		      <ul class="right hide-on-med-and-down">
		      <!-- Dropdown Trigger -->
		      <li><a class="dropdown-button" href="#!" data-activates="dropdown1"> <i class="material-icons left">perm_identity</i>
		      	<?php echo $user['nama']; ?>
		      </a></li>		      
			  </ul>
			    <ul class="side-nav" id="mobile-demo">
			        <li><a> <i class="material-icons right">perm_identity</i><?php echo $user['nama']; ?></a></li>
			        <li class="divider"></li>
			        <li><a href="">Help <i class="material-icons right">live_help</i></a></li>li>
			        <li><a href="">Log out <i class="material-icons right">lock_outline</i></a></li>li>
			    </ul>
		    </div>
		 </nav>
	</div>
