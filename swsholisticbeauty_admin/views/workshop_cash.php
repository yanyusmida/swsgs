<?php
	$workshop_day = array();
	$workshop_json = array();
	foreach ($classes as $class) {
		if(!isset($workshop_json[$class['workshop_day']])){
			$workshop_json[$class['workshop_day']] = array();
		}
		array_push($workshop_json[$class['workshop_day']], $class['workshop_time']);
		array_push($workshop_day, $class['workshop_day']);
	}
	$workshop_day = array_unique($workshop_day);
?>
<?php $this->load->view('common/header.php'); ?>
<?php	if(isset($refresh) && $refresh){	?>
<script type="text/javascript">
	top.location.href = "<?= base_url() ?>lists/<?=$type;?>";	
</script>
<?php	}	?>
<script type="text/javascript">
	var workshop_date = <?php echo json_encode($workshop_json); ?>;
	$(function(){	
		$("#cash_form").validationEngine({promptPosition:"bottomLeft"});
		$("#workshop_day").change(function() {
			var workshop_day = $(this).val(); 	   
			var array_list = workshop_date[workshop_day];              
			$("#workshop_time").html("<option value=''></option>"); 
	    $(array_list).each(function (i) {                      
	        $("#workshop_time").append("<option value='"+array_list[i]+"'>"+array_list[i]+"</option>");
	    });    
		});
	});
</script>
<div id="wrapper">
	<?php $this->load->view('common/sidebar.php'); ?>
	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h2><?=$parent_info['title'];?> Cash Register</h2>
				<div class="clearfix mtl">
					<form action="<?= base_url() ?>cash/<?=$type;?>/<?=$parent_id;?>" method="post" role="form" class="form-horizontal" id="cash_form">
						<input type="hidden" name="workshop_id" value="<?=$parent_id;?>">
						<input type="hidden" name="payed" value="cash">
						<div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">First Name:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="first_name" value="" maxlength="200">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Family Name:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="family_name" value="" maxlength="200">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Year of Birth:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="dob" value="" maxlength="200">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">NRIC:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="nric" value="" maxlength="4">
								</div>
							</div> 
							<div class="form-group">	
								<label class="col-sm-3 control-label">Email:</label>
								<div class="col-sm-5">
									<input type="email" class="form-control validate[required]" name="email" value="" maxlength="200">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Contact Number:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="contact_number" value="" maxlength="8">
								</div>
							</div> 
							<div class="form-group">	
								<label class="col-sm-3 control-label">Workshop Day:</label>
								<div class="col-sm-5">
									<select name="workshop_day" id="workshop_day" class="form-control validate[required]">
										<option value=""></option>                   
										<?php
										foreach ($workshop_day as $d) {
											echo "<option value='".$d."'>".$d."</option>";
										} 
										?>
									</select>
								</div>
							</div>	
							<div class="form-group">	
								<label class="col-sm-3 control-label">Workshop Time:</label>
								<div class="col-sm-5">
									<select name="workshop_time" id="workshop_time" class="form-control validate[required]">
										<option value=""></option>                   
									</select>
								</div>
							</div>						
						</div>						
						<p class="text-center clear mtl">
							<a href="#" class="btn btn-primary btn-lg mrm" onclick="$('#cash_form').submit();">Send</a>
						</p>
					</form>
				</div>
			</div>
			<!-- /.row -->
		</div>
		<!-- /#page-wrapper -->
	</div>
</div>
</body>
</html>