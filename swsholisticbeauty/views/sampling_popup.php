<?php 
	if(!empty($view_data['sampling'])){ 
?>
    <div class="modal fade thankyou" id="sampling-thankyou" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <div class="modal-body">
                    <div class="thankyou-con text-center">
                        <h2><?=$view_data['sampling']['thank_title'];?></h2>
                        <p><?=$view_data['sampling']['thank_desc'];?></p>
                        <div class="text-center">
                            <a href="#" class="button btn-hollow" data-dismiss="modal" aria-label="Close">OK</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->     
		
		<div class="modal fade sampling-tcpop" id="tcpop" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <div class="modal-body">
                    <div class="sampling-tc-con">
                        <h4><b>Terms and Conditions</b></h4>
                        <div class="dec-list">
                        	<?=$view_data['sampling']['tnc_text'];?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<script type="text/javascript">	
	$(function () {	
		<?php	if(date('Y-m-d H:i:s') > $view_data['sampling']['end_date']){	?>
		$('#alert-text').text('');
		$('#alert-text').text("<?=str_replace('"',"'", $view_data['sampling']['end_msg']);?>");
		$('#alert-pop').modal();
		$('#alert-pop').on('hide.bs.modal', function (e) {
		  top.location.href = "<?= $this->config->item('base_url') ?>"; 
		});
		<?php	}	?>
		$('#sampling-thankyou').on('hide.bs.modal', function (e) {
		  top.location.href = "<?= $this->config->item('base_url') ?>"; 
		});

		$('.btn-sampling-submit').click(function () {
			$("#reg_form_sampling").submit();
		});
		
		$('.tc-link').click(function () {
			$('.sampling-tcpop').modal();
		});
		
  	$("#reg_form_sampling").validationEngine({
			promptPosition : "bottomLeft",
			scroll: false,
			ajaxFormValidation: true,
			ajaxFormValidationMethod: 'post', 
			ajaxFormValidationURL: "<?= $this->config->item('base_url') ?>ajax/reg_sampling",
			onBeforeAjaxFormValidation: function() {
				$('#loading_mask').show();
			}, onAjaxFormComplete: function(status, form, json, options) {
				$('#loading_mask').hide();
				if(json.error == 0){					
  				$('#sampling-thankyou').modal();
				}else{					
					$('#alert-text').text('');
					$('#alert-text').html(json.msg);
					$('#alert-pop').modal();
					// SulwhasooSG_GRSTK
				}
			}
		});
	});
	
  function checkCON(field, rules, i, options){	
		var re1 = /^\d+$/;
		if (!re1.test( $('#contact_number').val() ) || $('#contact_number').val().length != 8) {
			return options.allrules.validate3fields.alertText;
		}
  }
  
  function checkNRIC(field, rules, i, options){	
		var re1 = /^\d+$/;
		if (!re1.test( $('#nric').val() ) || $('#nric').val().length != 4) {
			return options.allrules.validate4fields.alertText;
		}
  }
</script>
<?php	}	?>  