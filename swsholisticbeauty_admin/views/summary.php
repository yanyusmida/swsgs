<?php $this->load->view('common/header.php'); ?>
<?php	if(isset($refresh) && $refresh){	?>
<script type="text/javascript">
	top.location.href = "<?= base_url() ?>summary";	
</script>
<?php	}	?>
<div id="wrapper">   
	<?php $this->load->view('common/sidebar.php'); ?>
	<div id="page-wrapper">
  	<div class="row">
			<div class="col-lg-12">
				<div class="clear clearfix">
					<div>
						<div id="as_stats_ummary" class="tab-pane active">
							<div class="ptl">
								<table class="table table-striped table-hover admin_mainform">
									<tbody>
										<tr>
											<td width="35%">Total No. of Workshop Registered Users:</td>
											<td><?=$summary['workshop_users'];?></td>
										</tr>
										<tr>
											<td width="35%">Total No. of Workshop Payed Users:</td>
											<td><?=$summary['workshop_payed_users'];?></td>
										</tr>
										<tr>
											<td colspan="2">
												<table>
													<tbody>
														<?php foreach ($summary['workshops'] as $workshop) {	?>
														<tr>
															<td width="35%"><?=$workshop['title'];?>:</td>
															<td class="pagination-right"><?=$workshop['total'];?></td>
														</tr>
														<?php }	?>
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td width="35%">Total No. of Sampling Registered Users:</td>
											<td><?=$summary['sample_users'];?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
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