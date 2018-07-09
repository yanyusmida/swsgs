<?php $this->load->view('common/header.php'); ?>
<?php	if(isset($refresh) && $refresh){	?>
<script type="text/javascript">
	top.location.href = "<?= base_url() ?>report";	
</script>
<?php	}	?>
<script type="text/javascript">
	$(function(){	
		$('#start_time, #end_time').datetimepicker({ dateFormat: "yy-mm-dd", timeFormat: 'HH:mm:ss'});
	});
</script>
<div id="wrapper">   
	<?php $this->load->view('common/sidebar.php'); ?>
	<div id="page-wrapper">
  	<div class="row">
			<div class="col-lg-12">
				<div class="clear clearfix">
					<form action="<?= base_url() ?>report" role="form" method="post" id="down_form">
						<div class="pbl clearfix dr_tab">
							<div class="form-group col-lg-12 clearfix mbl">
								<label class="pull-left">Report Date Range:</label>
								<div class="col-sm-3">
									<input name="start_time" id="start_time" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS" value="2017-01-01 00:00:00">
								</div>
								<label class="pull-left">to</label>
								<div class="col-sm-3">
									<input name="end_time" id="end_time" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS" value="<?php echo date("Y-m-d H:i:s"); ?>">
								</div>
							</div>
							<div class="form-group col-lg-9 clearfix">
								<label class="col-sm-2 control-label">Select Report:</label>
								<div class="col-sm-3">
									<select class="form-control" name="rpt">
										<option value="summary">Summary Report</option>
										<option value="registered_users">Workshop Registered Users Report</option>
										<option value="payed_users">Workshop Payed Users Report</option>
										<option value="sample_users">Sampling Registered Users Report</option>
									</select>
								</div>
							</div>
						</div>
						<p class="text-left clear mtl">
							<button type="button" class="btn btn-primary btn-lg button_dr_download" onclick="$('#down_form').submit();">
								<span class="fa fa-download mrm"></span>Download</button>
						</p>
					</form>
				</div>
			</div>
		</div>
		<!-- /.row -->
	</div>
	<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
</body>
</html>