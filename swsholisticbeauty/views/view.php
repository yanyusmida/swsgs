<?php $this->load->view('common/header'); ?>
<div class="wrapper">
	<div id="container">
		<?php $this->load->view('common/navbar.php'); ?>
		<div id="content">
			<?php $this->load->view($view_name); ?>
		</div>
	</div>
	<?php $this->load->view('common/bottom.php'); ?>
</div>
<?php $this->load->view('common/popup.php'); ?>
<?php 
	if($view_name == "workshop"){
		$this->load->view('workshop_popup.php'); 
	}
	if($view_name == "sampling"){
		$this->load->view('sampling_popup.php'); 
	}
	if($view_name == "preorder"){
		$this->load->view('preorder_popup.php'); 
	}
?>
<style>
	#loading_mask{
		opacity: .5;
		position: fixed;
	  top: 0;
	  right: 0;
	  bottom: 0;
	  left: 0;
	  z-index: 1051;
	  background-color: #000;
	  display:none;
	}
</style>
<div id="loading_mask"></div>
<?php	$this->load->view('common/footer');	?>
