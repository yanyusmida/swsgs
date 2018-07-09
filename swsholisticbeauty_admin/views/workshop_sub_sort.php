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
				<h2><?=$parent_info['title'];?> Sort</h2>
				<div class="clearfix mtl">
					<form action="<?= base_url() ?>ssort/<?=$type;?>/<?=$parent_id;?>" method="post" role="form" class="form-horizontal" id="sort_form">
						<input type="hidden" name="ids" id="ids" value="" />	
					</form>			
				</div>
				<div class="table-responsive clear">
					<?php if(count($lists)){ ?>
						<ul id="sort_ul">
						<?php foreach ($lists as $li) { ?>
							<li id="<?=$li['id'];?>"><i class="fa fa-arrows-v"></i><?=$li['workshop_day'];?> - <?=$li['workshop_time'];?> </li>
						<?php } ?>
						</ul>
					<?php } ?>
				</div>
				<p class="text-center clear mtl">
					<a href="#" class="btn btn-primary btn-lg mrm" onclick="goSave();">Save</a>
				</p>
			</div>
		</div>
		<!-- /.row -->
	</div>
	<!-- /#page-wrapper -->
</div>
<style>
#sort_ul{ list-style-type: none; }
#sort_ul li{ margin: 0 3px 3px 3px; padding-left: 1.5em; font-size: 17px; background: #DDDDDD; cursor: pointer;}
</style>
<script type="text/javascript">
$(function() {
	$('#sort_ul').sortable();
});
function goSave(){
	var productOrder = $('#sort_ul').sortable('toArray').toString();
	$("#ids").val(productOrder);
	$('#sort_form').submit();
}
</script>