<?php $this->load->view('common/header.php'); ?>
<?php	if(isset($refresh) && $refresh){	?>
<script type="text/javascript">
	top.location.href = "<?= base_url() ?>slist/<?=$type;?>/<?=$parent_id;?>";	
</script>
<?php	}	?>
<script type="text/javascript">
	$(function(){			
		$("#screate_form").validationEngine({promptPosition:"bottomLeft"});
		var total_time = 1;
		$('#workshop_day').datepicker({ dateFormat: 'yy-mm-dd' });	
		$('#workshop_time_1').timepicker({
			timeFormat: 'hh:mmp',
			minTime: '9',
    	maxTime: '21'
		});
		$('#workshop_time_add').click(function(){
			total_time++;
			$("#total_time").val(total_time);
			$("#workshop_time_area").append("<br><input class='form-control' name='workshop_time_"+total_time+"' id='workshop_time_"+total_time+"' value='' readonly>");
			$('#workshop_time_'+total_time).timepicker({timeFormat: 'hh:mmp'});
		});
	});
</script>
<script src="<?= base_url() ?>js/jquery-ui.js"></script>
<script src="<?= base_url() ?>js/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/jquery.timepicker.css" />
<div id="wrapper">
	<?php $this->load->view('common/sidebar.php'); ?>	
	<div id="page-wrapper">
  	<div class="row">
			<div class="col-lg-12">
				<div class="clear clearfix">
					<form action="<?= base_url() ?>screate/<?=$type;?>/<?=$parent_id;?>" enctype="multipart/form-data" method="post" id="screate_form" role="form" class="form-horizontal">
						<input type="hidden" name="workshop_id" id="workshop_id" value="<?=$parent_id;?>" />	
						<input type="hidden" name="total_time" id="total_time" value="1" />	
						<div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Workshop Day:</label>
								<div class="col-sm-5">
									<input class="form-control validate[required]" id="workshop_day" name="workshop_day" placeholder="YYYY-MM-DD" value="" readonly>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Workshop Time: <br><a href="#" id="workshop_time_add" class="btn btn-primary">Add</a></label>
								<div class="col-sm-5" id="workshop_time_area">
									<input class="form-control validate[required]" name="workshop_time_1" id="workshop_time_1" value="" readonly>
								</div>
							</div>				
						</div> 
					</div>
					<p class="text-center clear mtl">
						<a href="#" class="btn btn-primary btn-lg mrm" onclick="$('#screate_form').submit();">Save</a>
					</p>
				</form>
			</div>
		</div>
		<!-- /.row -->
	</div>
	<!-- /#page-wrapper -->
</div>
</body>
</html>