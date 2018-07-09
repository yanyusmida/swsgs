<?php $this->load->view('common/header.php'); ?>
<?php	if(isset($refresh) && $refresh){	?>
<script type="text/javascript">
	top.location.href = "<?= base_url() ?>lists/<?=$type;?>";	
</script>
<?php	}	?>
<script type="text/javascript">
	$(function(){	
		$("#edit_form").validationEngine({promptPosition:"bottomLeft"});
		tinymce.init({
	    selector: "textarea.html_tinymce",  
	    plugins: [
	    "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
	    "searchreplace visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
	    "table contextmenu directionality emoticons template textcolor paste textcolor"
	    ],
	
	    toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
	    toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | inserttime preview | forecolor backcolor",
	    toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft"
		});  
		$('#end_date, #start_date').datetimepicker({ dateFormat: "yy-mm-dd", timeFormat: 'HH:mm:ss'});		
	});		
</script>
<div id="wrapper">
	<?php $this->load->view('common/sidebar.php'); ?>	
	<div id="page-wrapper">
  	<div class="row">
			<div class="col-lg-12">
				<div class="clear clearfix">
					<form action="<?= base_url() ?>edit/<?=$type;?>/<?=$show_info['id'];?>" enctype="multipart/form-data" method="post" id="edit_form" role="form" class="form-horizontal">
						<div>			
							<div class="form-group">	
								<label class="col-sm-3 control-label">Banner Image:</label>
								<div class="col-sm-5">
									<input type="file" class="form-control" name="banner_img" id="banner_img" value="">
									<img onerror="$(this).hide(); $('#banner_img').addClass('validate[required]');" src="<?=config_item('app_base_url');?>uploads/<?=$show_info['banner_img'];?>" />
								</div>
							</div>	
							<div class="form-group">	
								<label class="col-sm-3 control-label">Title:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="title" value="<?=htmlspecialchars($show_info['title']);?>">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Description:</label>
								<div class="col-sm-5">
									<input type="text"class="form-control validate[required]" name="description" value="<?=htmlspecialchars($show_info['description']);?>">
								</div>
							</div>	
							<div class="form-group">	
								<label class="col-sm-3 control-label">Workshop Image:</label>
								<div class="col-sm-5">
									<input type="file" class="form-control" name="workshop_img" id="workshop_img" value="">
									<img onerror="$(this).hide(); $('#workshop_img').addClass('validate[required]');" src="<?=config_item('app_base_url');?>uploads/<?=$show_info['workshop_img'];?>" />
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Information:</label>
								<div class="col-sm-5">
									<textarea name="information" class="html_tinymce form-control validate[required]"><?=$show_info['information'];?></textarea>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Price Title:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="price_title" value="<?=htmlspecialchars($show_info['price_title']);?>" maxlength="500">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Price Description:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="price_desc" value="<?=htmlspecialchars($show_info['price_desc']);?>" maxlength="500">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Price Number:</label>
								<div class="col-sm-5">
									<input type="tel" class="form-control validate[required,custom[number]]" name="price" value="<?=htmlspecialchars($show_info['price']);?>">
								</div>
							</div>	
							<div class="form-group">	
								<label class="col-sm-3 control-label">Hour:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="show_hour" value="<?=htmlspecialchars($show_info['show_hour']);?>" maxlength="500">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Location:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="location" value="<?=htmlspecialchars($show_info['location']);?>" maxlength="500">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Slots Number:</label>
								<div class="col-sm-5">
									<input type="tel" class="form-control validate[required,custom[number]]" name="slots" value="<?=htmlspecialchars($show_info['slots']);?>">
								</div>
							</div>	
							<div class="form-group">	
								<label class="col-sm-3 control-label">Terms & Conditions:</label>
								<div class="col-sm-5">
									<textarea name="tnc_text" class="html_tinymce form-control validate[required]"><?=$show_info['tnc_text'];?></textarea>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Thank Title:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="thank_title" value="<?=htmlspecialchars($show_info['thank_title']);?>" maxlength="255">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Thank Description:</label>
								<div class="col-sm-5">
									<textarea name="thank_desc" rows="7" class="form-control validate[required]"><?=$show_info['thank_desc'];?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Email Subject:</label>			
								<div class="col-sm-5">	
									<input type="text" class="form-control validate[required]" name="mail_title" value="<?=htmlspecialchars($show_info['mail_title']);?>" maxlength="255"><br>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Email Text<br>(First Name [::user_first_name::],	Family Name [::user_family_name::], NRIC [::user_nric::], Contact [::user_contact_number::], Workshop Day [::user_workshop_day::], Workshop Time [::user_workshop_time::]):</label>
								<div class="col-sm-5">
									<textarea name="mail_str" class="html_tinymce form-control validate[required]"><?=$show_info['mail_str'];?></textarea>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Start Date:</label>
								<div class="col-sm-5">
									<input type="text" name="start_date" id="start_date" class="form-control validate[required]" placeholder="YYYY-MM-DD HH:MM:SS" value="<?=$show_info['start_date'];?>" readonly>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">End Date:</label>
								<div class="col-sm-5">
									<input type="text" name="end_date" id="end_date" class="form-control validate[required]" placeholder="YYYY-MM-DD HH:MM:SS" value="<?=$show_info['end_date'];?>" readonly>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">End Message:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="end_msg" value="<?=htmlspecialchars($show_info['end_msg']);?>" maxlength="255">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Status:</label>
								<div class="col-sm-5">
									<select name="status" class="form-control validate[required]">
										<option value="active" <?=($show_info['status'] == "active")? "selected":"";?>>active</option>
										<option value="disable" <?=($show_info['status'] == "disable")? "selected":"";?>>disable</option>
									</select>
								</div>
							</div>
						</div> 				
						<p class="text-center clear mtl">
							<a href="#" class="btn btn-primary btn-lg mrm" onclick="$('#edit_form').submit();">Save</a>
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