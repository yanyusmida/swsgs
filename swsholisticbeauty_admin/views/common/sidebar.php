<!-- Sidebar -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?= base_url() ?>">Admin</a>
	</div>
	
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav side-nav">
			<li <?=($show_page == "summary")? "class='active'":"";?>>
				<a href="<?= base_url() ?>summary"><i class="fa fa-table"></i>Summary</a>
			</li>
			<?php if($this->session->userdata('user_type') == "admin"){	?>
			<li <?=($show_page == "report")? "class='active'":"";?>>
				<a href="<?= base_url() ?>report"><i class="fa fa-download"></i>Report</a>
			</li>			
			<li <?=($show_page == "theme")? "class='active'":"";?>>
				<a href="<?= base_url() ?>setting"><i class="fa fa-gear"></i>Settings</a>
			</li>	
			<?php	}	?>
			<li <?=($show_page == "workshop")? "class='active'":"";?>>
				<a href="<?= base_url() ?>lists/workshop"><i class="fa fa-comments-o"></i>Workshop</a>
			</li>
			<?php if($this->session->userdata('user_type') == "admin"){	?>
			<li <?=($show_page == "sampling")? "class='active'":"";?>>
				<a href="<?= base_url() ?>lists/sampling"><i class="fa fa-comments-o"></i>Sampling</a>
			</li>
			<?php	}	?>

			<?php if($this->session->userdata('user_type') == "admin"){	?>
			<li <?=($show_page == "preorder")? "class='active'":"";?>>
				<a href="<?= base_url() ?>lists/preorder"><i class="fa fa-comments-o"></i>Pre-Order</a>
			</li>
			<?php	}	?>

		</ul>
		<ul class="nav navbar-nav navbar-right navbar-user">
			<li>
				<a href="<?= base_url() ?>logout"><i class="fa fa-power-off"></i>Log Out</a>
			</li>
		</ul>
	</div>	
	<!-- /.navbar-collapse -->
</nav>