<?php 
	$workshop_json = array();
	if(!empty($view_data['workshops'])){ 
?>
	<?php foreach ($view_data['workshops'] as $workshop) {	 ?>  
    <div class="modal fade bookform" id="workshop-pop-<?=$workshop['id'];?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <div class="modal-body">
                    <div class="popcol">
                        <div class="bookform-info">
                            <h3 class="workshop-title"><?=$workshop['title'];?></h3>
                            <dl class="workshop-dis fontNoto">
                                <dt class="visible-xs"><img src="<?= $this->config->item('base_url') ?>uploads/<?=$workshop['workshop_img'];?>" alt=""></dt>
                                <dd><?=$workshop['information'];?></dd>
                            </dl>
                            <ul class="whitem-note">
                                <li class="item-ws-tag">
                                    <h5><?=$workshop['price_title'];?></h5> <small><?=$workshop['price_desc'];?></small></li>
                                <li class="item-ws-time">
                                    <h5><?=$workshop['show_hour'];?></h5></li>
                                <li class="item-ws-map">
                                    <h5><?=$workshop['location'];?></h5></li>
                            </ul>
                            <div class="text-center hidden-xs bfi-photo"><img src="<?= $this->config->item('base_url') ?>uploads/<?=$workshop['workshop_img'];?>" alt=""></div>
                        </div>
                        <div class="book-form-con">
                            <div class="tc-con hide">
                                <h4><b>Terms and Conditions</b></h4>
                                <div class="dec-list">
                                		<?=str_replace("\r\n", "<br>", $workshop['tnc_text']);?>
                                </div>
                                <div class="text-center">
                                    <a href="#" class="button btn-hollow btn-tcback">Back</a>
                                </div>
                            </div>
                            <?php if(date('Y-m-d H:i:s') > $workshop['end_date']){ ?>
                            <div class="form-horizontal">
                            	<?=$workshop['end_msg'];?>
                            </div>
                            <?php }else{	?>
                            <input type="hidden" class="title" name="title" value="<?=str_replace('"', "'", $workshop['title']);?>">
                            <input type="hidden" class="price" name="price" value="<?=$workshop['price'];?>">
                            <form id="reg_form_<?=$workshop['id'];?>" method="post" class="signup_form form-horizontal" role="form" novalidate="novalidate">
                                <input type="hidden" class="workshop_id" name="workshop_id" value="<?=$workshop['id'];?>">
                                <div class="form-group">
                                    <label for="first_name" class="col-sm-4 control-label">First Name</label>
                                    <div class="col-sm-8">
                                    		<input type="text" class="form-control validate[required] first_name" name="first_name" maxlength="255">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="family_name" class="col-sm-4 control-label">Family Name</label>
                                    <div class="col-sm-8">
                                    		<input type="text" class="form-control validate[required] family_name" name="family_name" maxlength="255">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="birthday" class="col-sm-4 control-label">Year of Birth</label>
                                    <div class="col-sm-8">
                                        <select name="dob" class="form-control validate[required] dob">
				                                    <option value="">Please select</option>
				                                    <?php for ($i = 2017; $i > 1900; $i--) {	?>
				                                    <option value="<?=$i;?>"><?=$i;?></option> 	  
				                                    <?php }	?>
				                                </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nric" class="col-sm-4 control-label">NRIC (4 digits)</label>
                                    <div class="col-sm-8">
                                        <input type="tel" class="form-control validate[required,funcCall[checkNRIC]] nric" name="nric" maxlength="4">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-4 control-label">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control validate[required,custom[email]] email" name="email" maxlength="255">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contact_number" class="col-sm-4 control-label">Mobile</label>
                                    <div class="col-sm-8">
                                        <input type="tel" class="form-control validate[required,funcCall[checkCON]] contact_number" name="contact_number" maxlength="8">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="date" class="col-sm-4 control-label">Workshop Date</label>
                                    <div class="col-sm-8">
                                        <select name="workshop_day" class="form-control validate[required] workshop_day" data-cur_id="<?=$workshop['id'];?>">
                                            <option value="">Please select</option>
                                            <?php
                                            	if(!empty($workshop['classes'])){
                                            		$workshop_day = array();
                                            		$now = date("Y-m-d H:i:s");                                            		
                                            		$workshop_json[$workshop['id']] = array();
                                            		foreach ($workshop['classes'] as $class) {
                                            			$payed_count = $this->workshops->get_payed_count($workshop['id'], $class['id']);
                                            			if($payed_count < $workshop['slots']){
	                                            			$workshop_hour = substr($class['workshop_time'], 0, 2);
	                                            			$workshop_pm_am = substr($class['workshop_time'], -2);
	                                            			if($workshop_pm_am == 'AM' && $workshop_hour == "12"){
	                                            				$workshop_hour = "00";
	                                            			}else if($workshop_pm_am == 'PM' && $workshop_hour != "12"){
	                                            				$int_workshop_hour = intval($workshop_hour) + 12;
	                                            				$workshop_hour = str_pad($int_workshop_hour, 2, "0", STR_PAD_LEFT);
	                                            			}
	                                            			$workshop_min = substr($class['workshop_time'], 3, 2);
	                                            			$workshop_date = $class['workshop_day']." ".$workshop_hour.":".$workshop_min.":00";
	                                            			if ($now < $workshop_date){
	                                            				if(!isset($workshop_json[$workshop['id']][$class['workshop_day']])){
	                                            					$workshop_json[$workshop['id']][$class['workshop_day']] = array();
	                                            				}
	                                            				array_push($workshop_json[$workshop['id']][$class['workshop_day']], $class['workshop_time']);
	                                            				array_push($workshop_day, $class['workshop_day']);
	                                            		 	}
	                                            		}
                                            		} 
                                            		$workshop_day = array_unique($workshop_day);
                                            		
                                            		foreach ($workshop_day as $d) {
                                            			echo "<option value='".$d."'>".$d."</option>";
                                            		} 
                                            	}
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="time" class="col-sm-4 control-label">Workshop Time</label>
                                    <div class="col-sm-8">
                                        <select name="workshop_time" id="workshop_<?=$workshop['id'];?>_time" class="form-control validate[required] workshop_time">
                                            <option value="">Please select</option>                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="check-tc" value="yes" class="validate[required] check-tc"> I certify that I have read, understood and agree to the <span class="tc-link">Terms and Conditions</span>.
                                    </label>
                                </div>
                                <div class="text-right booksubmit">
                                    <a href="#" class="button btn-hollow">Checkout</a>
                                </div>
                            </form>                            
                          	<?php }	?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
      
    <div class="modal fade thankyou" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <div class="modal-body">
                    <div class="thankyou-con text-center">
                        <h2>Thank You</h2>
                        <p>Receive your complimentary trial kit</p>
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
      
    <div class="modal fade thankyou" id="thank-pop-<?=$workshop['id'];?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <div class="modal-body">
                    <div class="thankyou-con text-center">
                        <h2><?=$workshop['thank_title'];?></h2>
                        <p><?=$workshop['thank_desc'];?></p>
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
	<?php	}	?>  
<?php	}	?>  
<form action="https://<?=PP_HOST;?>/cgi-bin/webscr" method="post" id="go_pp">
  <input type="hidden" name="cmd" value="_xclick">
  <input type="hidden" name="business" value="<?=PP_BUS;?>">
  <input type="hidden" name="quantity" value="1">
  <input type="hidden" name="currency_code" value="SGD">
  <!-- Set variables that override the address stored with PayPal. -->
  <input type="hidden" name="amount" class="amount" value="">
  <input type="hidden" name="item_name" class="item_name" value="">
  <input type="hidden" name="item_number" class="item_number" value="">
  <input type="hidden" name="first_name" class="first_name" value="">
  <input type="hidden" name="last_name" class="last_name" value="">
  <input type="hidden" name="custom" class="custom" value="">
  <input type="hidden" name="return" class="return" value="">
</form>
<script type="text/javascript">	
	var cur_workshop = 0;
	var workshop_date = <?php echo json_encode($workshop_json); ?>;
	$(function () {	
		$('.booksubmit a').click(function () {
			$("#reg_form_"+cur_workshop).submit();
		});
		$('.tc-link').click(function () {
			$('#workshop-pop-'+cur_workshop+' .tc-con').removeClass('hide');
			$('#workshop-pop-'+cur_workshop+' .form-horizontal').addClass('hide');
		});
		$('.btn-tcback').click(function () {
			$('#workshop-pop-'+cur_workshop+' .tc-con').addClass('hide');
			$('#workshop-pop-'+cur_workshop+' .form-horizontal').removeClass('hide');
		});
		$('.btn-workshop-pop').click(function () {
			var workshop_id = $(this).data('workshop_id');
			cur_workshop = workshop_id;
			$("#workshop-pop-"+cur_workshop).modal();
			fbq('track', 'ViewContent');
			return false;
		});
		$(".workshop_day").change(function() {
			var workshop_day = $(this).val(); 	   
			var cur_id = $(this).data('cur_id');
			var array_list = workshop_date[cur_id][workshop_day];                                 
			$("#workshop_"+cur_id+"_time").html("<option value=''>Please select</option>"); 
	    $(array_list).each(function (i) { 
	        $("#workshop_"+cur_id+"_time").append("<option value='"+array_list[i]+"'>"+array_list[i]+"</option>");
	    });    
		});
		
  	$(".signup_form").validationEngine({
			promptPosition : "bottomLeft",
			scroll: false,
			ajaxFormValidation: true,
			ajaxFormValidationMethod: 'post', 
			ajaxFormValidationURL: "<?= $this->config->item('base_url') ?>ajax/registration",
			onBeforeAjaxFormValidation: function() {
				$('#loading_mask').show();
			}, onAjaxFormComplete: function(status, form, json, options) {
				if(json.error == 0 && json.reg_id > 0 && json.workshop_id){
  				$("#go_pp .amount").val($("#workshop-pop-"+json.workshop_id+" .price").val());
					$("#go_pp .item_name").val($("#workshop-pop-"+json.workshop_id+" .title").val());
					$("#go_pp .item_number").val(json.reg_id);
					$("#go_pp .custom").val(json.reg_id);
					$("#go_pp .return").val('<?=$this->config->item('base_url')."thanks/?reg_id=";?>'+String(json.reg_id));
  				$("#go_pp .first_name").val($("#workshop-pop-"+json.workshop_id+" .first_name").val());
  				$("#go_pp .family_name").val($("#workshop-pop-"+json.workshop_id+" .family_name").val());
  				$('#go_pp').submit();
				}else{					
					$('#alert-text').text('');
					$('#alert-text').text(json.msg);
					$('#alert-pop').modal();
				}
			}
		});
		<?php if($view_data['thanks'] == 'yes'){	?>
		$('#thank-pop-<?=$view_data['thanks_id'];?>').modal();	
		<?php	}	?>
	});
	
  function checkCON(field, rules, i, options){	
		var re1 = /^\d+$/;
		if (!re1.test( $('#reg_form_'+cur_workshop+' .contact_number').val() ) || $('#reg_form_'+cur_workshop+' .contact_number').val().length != 8) {
			return options.allrules.validate3fields.alertText;
		}
  }
  
  function checkNRIC(field, rules, i, options){	
		var re1 = /^\d+$/;
		if (!re1.test( $('#reg_form_'+cur_workshop+' .nric').val() ) || $('#reg_form_'+cur_workshop+' .nric').val().length != 4) {
			return options.allrules.validate4fields.alertText;
		}
  }
</script>