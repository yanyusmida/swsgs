<?php $this->load->view('common/header.php'); ?>
<?php	if(isset($refresh) && $refresh){	?>
<script type="text/javascript">
	top.location.href = "<?= base_url() ?>lists/<?=$type;?>";	
</script>
<?php	}	?>
<script src="<?= base_url() ?>js/jquery-ui.js"></script>
<div id="wrapper">
	<?php $this->load->view('common/sidebar.php'); ?>
	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h2><?=$parent_info['title'];?> Re-Send Email</h2>
				<div class="clearfix mtl">
					<form action="<?= base_url() ?>resend/<?=$type;?>/<?=$parent_id;?>" method="post" role="form" class="form-horizontal" id="resend_form">
						<div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">New Email:</label>
								<div class="col-sm-5">
									<input class="form-control validate[required,custom[email]]" name="user_email" value="">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Register ID:</label>
								<div class="col-sm-5">
									<input class="form-control validate[required]" name="user_id" value="">
								</div>
							</div>
						</div>
					</div>			
				</div>
				<p class="text-center clear mtl">
					<a href="#" class="btn btn-primary btn-lg mrm" onclick="$('#resend_form').submit();">Send</a>
				</p>
				</form>
			</div>
		</div>
		<!-- /.row -->
	</div>
	<!-- /#page-wrapper -->
</div>