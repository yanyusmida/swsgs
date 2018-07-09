<?php $this->load->view('common/header.php'); ?>
<?php	if(isset($refresh) && $refresh){	?>
<script type="text/javascript">
	top.location.href = "<?= base_url() ?>lists/<?=$type;?>";	
</script>
<?php	}	?>
<script type="text/javascript">
	$(function(){	
		$("#create_form").validationEngine({promptPosition:"bottomLeft"});	
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
					<form action="<?= base_url() ?>create/<?=$type;?>" enctype="multipart/form-data" method="post" id="create_form" role="form" class="form-horizontal">
						<div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Banner Image:</label>
								<div class="col-sm-5">
									<input type="file" class="form-control validate[required]" name="banner_img" id="banner_img" value="">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Title:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="title" value="" maxlength="500">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Description:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="description" value="" maxlength="500">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Workshop Image:</label>
								<div class="col-sm-5">
									<input type="file" class="form-control validate[required]" name="workshop_img" id="workshop_img" value="">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Information:</label>
								<div class="col-sm-5">
									<textarea name="information" class="html_tinymce form-control validate[required]"></textarea>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Price Title:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="price_title" value="" maxlength="500">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Price Description:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="price_desc" value="" maxlength="500">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Price Number:</label>
								<div class="col-sm-5">
									<input type="tel" class="form-control validate[required,custom[number]]" name="price" value="">
								</div>
							</div>	
							<div class="form-group">	
								<label class="col-sm-3 control-label">Hour:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="show_hour" value="" maxlength="500">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Location:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="location" value="" maxlength="500">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Slots Number:</label>
								<div class="col-sm-5">
									<input type="tel" class="form-control validate[required,custom[number]]" name="slots" value="">
								</div>
							</div>	
							<div class="form-group">	
								<label class="col-sm-3 control-label">Terms & Conditions:</label>
								<div class="col-sm-5">
									<textarea name="tnc_text" class="html_tinymce form-control validate[required]"></textarea>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Thank Title:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="thank_title" value="" maxlength="255">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Thank Description:</label>
								<div class="col-sm-5">
									<textarea name="thank_desc" rows="7" class="form-control validate[required]"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Email Subject:</label>			
								<div class="col-sm-5">	
									<input type="text" class="form-control validate[required]" name="mail_title" value="" maxlength="255"><br>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Email Text<br>(First Name [::user_first_name::],	Family Name [::user_family_name::], NRIC [::user_nric::], Contact [::user_contact_number::], Workshop Day [::user_workshop_day::], Workshop Time [::user_workshop_time::]):</label>
								<div class="col-sm-5">
									<textarea name="mail_str" class="html_tinymce form-control validate[required]"></textarea>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Start Date:</label>
								<div class="col-sm-5">
									<input type="text" name="start_date" id="start_date" class="form-control validate[required]" placeholder="YYYY-MM-DD HH:MM:SS" value="" readonly>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">End Date:</label>
								<div class="col-sm-5">
									<input type="text" name="end_date" id="end_date" class="form-control validate[required]" placeholder="YYYY-MM-DD HH:MM:SS" value="" readonly>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">End Message:</label>
								<div class="col-sm-5">
									<input type="text" class="form-control validate[required]" name="end_msg" value="" maxlength="255">
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-3 control-label">Status:</label>
								<div class="col-sm-5">
									<select name="status" class="form-control validate[required]">
										<option value="active" selected>active</option>
										<option value="disable">disable</option>
									</select>
								</div>
							</div>
						</div>
						<p class="text-center clear mtl">
							<a href="#" class="btn btn-primary btn-lg mrm" onclick="$('#create_form').submit();">Save</a>
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