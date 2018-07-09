<?php
	if(!empty($view_data['sampling'])){ 
?>
                <div class="container">
                    <div class="text-center visible-xs img-sampling-product-mobile">
                    	<img src="<?= $this->config->item('base_url') ?>uploads/<?=$view_data['sampling']['sampling_img'];?>" alt="">
                    </div>
                    <div class="page-dis sampling-head text-center">
                        <h1><?=$view_data['sampling']['title'];?></h1>
                    </div>
                    <div class="sampling-form" style="background: url(<?= $this->config->item('base_url') ?>uploads/<?=$view_data['sampling']['sampling_img'];?>) no-repeat #381711; background-size: auto 100%; -webkit-background-size: auto 100%;">
                        <div class="sampling-reg">
                            <form id="reg_form_sampling" class="form-horizontal" method="post" role="form" novalidate="novalidate">
                            		<input type="hidden" class="sampling_id" name="sampling_id" value="<?=$view_data['sampling']['id'];?>">
                                <fieldset>
                                    <legend><?=$view_data['sampling']['information'];?></legend>
                                    <div class="form-group">
                                        <label for="first_name" class="col-sm-4 control-label">First Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control validate[required]" id="first_name" name="first_name" maxlength="255">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="family_name" class="col-sm-4 control-label">Family Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control validate[required]" id="family_name" name="family_name" maxlength="255">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_number" class="col-sm-4 control-label">Contact No.</label>
                                        <div class="col-sm-8">
                                            <input type="tel" class="form-control validate[required,funcCall[checkCON]]" id="contact_number" name="contact_number" maxlength="8">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nric" class="col-sm-4 control-label">NRIC (Last 4 digits)</label>
                                        <div class="col-sm-8">
                                            <input type="tel" class="form-control validate[required,funcCall[checkNRIC]]" id="nric" name="nric" maxlength="4">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="dob" class="col-sm-4 control-label">Birth Year</label>
                                        <div class="col-sm-8">
                                            <select name="dob" class="form-control validate[required]" id="dob">
					                                    <option value="">Please select</option>
					                                    <?php for ($i = 2017; $i > 1900; $i--) {	?>
					                                    <option value="<?=$i;?>"><?=$i;?></option> 	  
					                                    <?php }	?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-4 control-label">Email</label>
                                        <div class="col-sm-8">
                                            <input type="email" class="form-control validate[required,custom[email]]" id="email" name="email" maxlength="255">
                                        </div>
                                    </div>
                                    <?php 
                                    $outlet_arr = explode("^", $view_data['sampling']['outlet_str']);
                                    if(count($outlet_arr) > 1){
                                    ?>
                                    <div class="form-group">
                                        <label for="outlet" class="col-sm-4 control-label">Preferred Outlet for Collection</label>
                                        <div class="col-sm-8">
                                            <select name="outlet" class="form-control validate[required]" id="outlet">
					                                    <option value="">Please select</option>
					                                    <?php
                                                            foreach ($outlet_arr as &$value) {
														?>
														<option><?=$value;?></option>
														<?php	}	?>
                                            </select>
                                        </div>
                                    </div>
                                  	<?php }else{	?>
                                  	<input type="hidden" class="outlet" name="outlet" value="<?=$outlet_arr[0];?>">
                                  	<?php }	?>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="check-tc" value="yes" class="validate[required]" id="check-tc"> I certify that I have read, understood and agree to the 
                                        </label>
                                        <label style="padding-left:0px;">
                                            <span class="tc-link">Terms and Conditions</span>.
                                        </label>
                                    </div>
                                    <div class="text-center">
                                        <a href="#" class="button btn-hollow btn-sampling-submit">Submit</a>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
<?php
	}
?>
