<?php $this->load->view('common/header.php'); ?>
<div class="wrapper">
	<div id="login_container">
		<form id="login_form" action="<?= base_url() ?>" method="POST">
			<div class="admin_login">
				<h3 class="mbl text-center">
					<img src="images/ihubmedia_logo_wtagline.png" alt="ihub media" title="ihub media">
				</h3>
				<div class="well">
					<p class="text-danger error_message"></p>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="fa fa-user"></span></span>
							<input type="text" class="form-control" placeholder="Username" id="username" name="username">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="fa fa-lock"></span></span>
							<input type="password" class="form-control" placeholder="Password" class="form-control" id="password" name="password">
						</div>
					</div>
					<p class="submit text-right">
						<a href="#" class="btn btn-primary btn_middle login_button">Login</a>
					</p>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	$(function(){
		$('.login_button').click(function(){
			var input01vl=$('#username').val();
			var input02vl=$('#password').val();
			if(input01vl=="" || input02vl==""){
				$('.error_message').html('The password field is empty.')
				$('.form-group').addClass('has-error');
				return false;
			}else{
				$('#login_form').submit();
			}
		});
	});
	$(document).keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13') {
			var input01vl=$('#username').val();
			var input02vl=$('#password').val();
			if(input01vl=="" || input02vl==""){
				$('.error_message').html('The password field is empty.')
				$('.form-group').addClass('has-error');
				return false;
			}else{
				$('#login_form').submit();
			}
    }
	});
</script>
</body>
</html>


