<?php $this->load->view('common/header.php'); ?>
<?	if(isset($refresh) && $refresh){	?>
<script type="text/javascript">
	top.location.href = "<?= base_url() ?>";	
</script>
<?	}	?>