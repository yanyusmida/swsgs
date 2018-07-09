<?php $this->load->view('common/header.php'); ?>
<?php	if(isset($refresh) && $refresh){	?>
<script type="text/javascript">
	top.location.href = "<?= base_url() ?>lists/<?=$type;?>";	
</script>
<?php	}	?>

<div id="wrapper">
	<?php $this->load->view('common/sidebar.php'); ?>
	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h2>Sampling List</h2>
				<div class="clearfix mtl">
					<form action="<?= base_url() ?>lists/<?=$type;?>" method="post" role="form" class="form-horizontal" id="filter_search">
						<input type="hidden" name="page" id="page" value="<?=$page;?>" />	
						<div class="form-group col-lg-9">
							<label class="col-sm-2 control-label">Status By:</label>
							<div class="col-sm-3">
								<select class="form-control" name="status">
									<option value="all" <?php if($status == "all"){ echo "selected"; } ?>>All</option>
									<option value="active" <?php if($status == "active"){ echo "selected"; } ?>>Active</option>
									<option value="disable" <?php if($status == "disable"){ echo "selected"; } ?>>Disable</option>
								</select>
							</div>
							<a href="#" class="btn btn-primary pull-left mll" onclick="$('#filter_search').submit();">Search</a>
						</div>
					</form>
					<a href="<?= base_url() ?>create/<?=$type;?>" class="btn btn-primary pull-right mll">Add</a>					
				</div>
				<div class="table-responsive clear">
					<table class="table table-hover table-striped tablesorter">
						<thead>
							<tr>
								<th class="header">Sampling Image</th>
								<th class="header">End Date</th>
								<th class="header">Total</th>
								<th class="header">Status</th>
								<th class="header">Action</th>
							</tr>
						</thead>
						<tbody>							
						<?php if(count($lists)){ ?>
							<?php foreach ($lists as $li) { ?>
							<tr>

								<td>
									<img src="<?=config_item('app_base_url');?>uploads/<?=$li['sampling_img'];?>" width="50" class="etr_thum">

								</td>
								<td><?=$li['end_date'];?></td>
								<td><?=$li['total'];?></td>
								<td><?=$li['status'];?></td>
								<td>
                	<a href="<?= base_url() ?>edit/<?=$type;?>/<?=$li['id'];?>" class="btn btn-primary pull-left" style="margin-right: 15px;">Edit</a>
                	<a href="<?= base_url() ?>resend/<?=$type;?>/<?=$li['id'];?>" class="btn btn-primary pull-left" style="margin-right: 15px;">Resend</a>
									<a href="<?= base_url() ?>report?rpt=sampling&id=<?=$li['id'];?>" class="btn btn-primary pull-left" style="margin-right:10px;">Report</a>
									<?php	if($li['status'] == "active"){	?>
									<a href="#" onclick="status_change('disable', <?=$li['id'];?>);" class="btn btn-primary pull-left">Disable</a>
									<?php	}else{	?>
									<a href="#" onclick="status_change('active', <?=$li['id'];?>);" class="btn btn-primary pull-left">Active</a>
									<?php	}	?>
								</td>
							</tr>
							<?php } ?>
						<?php } ?>
						</tbody>
					</table>
				</div>
				<?php if(count($lists)){ ?>
				<div class="text-center">
					<ul class="pagination">
					<?php
						$res = "";
						$pagenum = $page; 
										
						$unit = 10; //unit
						$pagesu = ceil($total/$unit); 
						$start = ($unit*$pagenum);
										
						$pageviewsu=10;  
						$pagegroup=ceil(($pagenum+1)/$pageviewsu);  
						$pagestart=($pageviewsu*($pagegroup-1))+1;  
						$pageend=$pagestart+$pageviewsu-1;
					 
						if($pagegroup>1){ 
							$prev=$pagestart-$pageviewsu-1; 
							echo "<li><a href='#' onclick='goLists(".$prev.");'><<</a></li>"; 
						} 
						if($pagenum){ 
							$prevpage=$pagenum-1; 			
							echo "<li><a href='#' onclick='goLists(".$prevpage.");'><</a></li>"; 
						} 
										
						for($i=$pagestart;$i<=$pageend;$i++) 
						{ 
							if($pagesu < $i)
							{
								break;
							} 
							$j=$i-1; 
							if($j==$pagenum)
							{
								echo "<li class='active'><a href='#'>".$i."<span class='sr-only'>(current)</span></a></li>";
							} 
							else
							{
								echo "<li><a href='#' onclick='goLists(".$j.");'>".$i."</a></li>";
							} 
						} 
										
						if(($pagenum+1)!=$pagesu){ 
							$nextpage=$pagenum+1; 				
							echo "<li><a href='#' onclick='goLists(".$nextpage.");'>></a></li>"; 
						} 
						if($pageend < $pagesu){
							echo "<li><a href='#' onclick='goLists(".$pageend.");'>>></a></li>";
						} 
											
						echo $res;
					?>  
					</ul>
				</div>
				<?php } ?>
			</div>
		</div>
		<!-- /.row -->
	</div>
	<!-- /#page-wrapper -->
</div>
<script type="text/javascript">
	function goLists(p){
		$('#page').val(p);
		$('#filter_search').submit();
	}
	function status_change(new_status, workshop_id){
		var _url = '<?= base_url() ?>ajax/status';
		var _args = {
			do_type: 'preorder',
			new_status: new_status,
			type_id: workshop_id
		};
		$.post(_url,_args,function(d) {
			alert(d.msg);
			$('#filter_search').submit();
		}, "json");
	}
</script>