<?php $this->load->view('common/header.php'); ?>
<?php	if(isset($refresh) && $refresh){	?>
<script type="text/javascript">
	top.location.href = "<?= base_url() ?><?=$view_type;?>";
</script>
<?php	}	?>
<script type="text/javascript">
	$(function(){	
		$("#theme_form").validationEngine({promptPosition:"bottomLeft"});		
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
	});
</script>
<div id="wrapper">
	<?php $this->load->view('common/sidebar.php'); ?>	
	<div id="page-wrapper">
  	<div class="row">
			<div class="col-lg-12">
				<div class="clear clearfix">
					<form action="<?= base_url() ?><?=$view_type;?>" enctype="multipart/form-data" method="post" id="theme_form" role="form" class="form-horizontal">
						<input type="hidden" name="theme" value="yes">
						<div>
							<?php 
								foreach ($theme_info as $key => $li) {	
									$show_val = $li['value'];
									if($li['value_type'] == "admin_script"){
										echo $show_val;
									}else{
							?>							 	
							<div class="form-group" id="<?=$key;?>_area">								
								<label class="col-sm-3 control-label"><?=$li['menu_name'];?>:</label>
								<div class="col-sm-5">
									<?php if ($li['value_type'] == "input") {	?>
									<input class="form-control validate[required]" name="<?=$key;?>" id="<?=$key;?>" value="<?=htmlspecialchars($show_val);?>">
									<?php }else if($li['value_type'] == "textarea"){	?>
									<textarea name="<?=$key;?>" id="<?=$key;?>" rows="5" class="form-control validate[required]"><?=$show_val;?></textarea>
									<?php }else if($li['value_type'] == "html"){	?>
									<textarea name="<?=$key;?>" id="<?=$key;?>" class="html_tinymce form-control validate[required]"><?=$show_val;?></textarea>
									<?php }else if($li['value_type'] == "file"){	?>
									<input type="file" class="form-control" name="<?=$key;?>" id="<?=$key;?>" value="">
									<img onerror="$(this).hide(); $('#<?=$key;?>').addClass('validate[required]');" src="<?=config_item('app_base_url');?>uploads/<?=$show_val;?>" />
									<?php }else if($li['value_type'] == "select"){	?>
									<select name="<?=$key;?>" id="<?=$key;?>">
										<?php
											$answer_arr = explode(",", $li['value_type_list']);
											foreach ($answer_arr as &$value) {
										?>
										<option value="<?=$value;?>" <?=($value == $show_val)? "selected":"";?>><?=$value;?></option>
										<?php
											} 
										?>
									</select>									
									<?php }  ?>
								</div>
							</div>
							<?php }  ?>							
							<?php }  ?>
						</div> 
					</div>
					<p class="text-center clear mtl">
						<a href="#" class="btn btn-primary btn-lg mrm" onclick="$('#theme_form').submit();">Save</a>
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