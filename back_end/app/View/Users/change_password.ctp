
<body>

	<div class="form_wraper hiden_text" style="">
		<div class="col-md-6 padding_zero">
			<div id="myCarousel" class="carousel slide" data-ride="carousel" style="background:#4670ee">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<li data-target="#myCarousel" data-slide-to="1"></li>
					<li data-target="#myCarousel" data-slide-to="2"></li>
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner">
					<div class="item active">
					  <img src="<?php echo $this->webroot ?>/webhtml/images/slide1.png" alt="Los Angeles">
					</div>

					<div class="item">
					  <img src="<?php echo $this->webroot ?>/webhtml/images/slide1.png" alt="Chicago">
					</div>

					<div class="item">
					  <img src="<?php echo $this->webroot ?>/webhtml/images/slide1.png" alt="New York">
					</div>
				  </div>

				  <!-- Left and right controls -->
				  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#myCarousel" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
					<span class="sr-only">Next</span>
				  </a>
				</div>

			</div>
		<div class="col-md-6 " style="text-align:center">
				<div class="logo_div">
					<img src="<?php echo $this->webroot ?>/webhtml/images/logo.png">
				</div>

				<div class="how_r register_choice">
						<div class="small_btns">
							<h3> Creat a new password </h3>
						
							 <form id="update_password" class="form_login">

									<div class="form-group">
									<label class="lbls"> Password</label>

									<input class="form-control" name="password" id="pwd" placeholder="Enter code from sms" type="password">
									</div>
									<div class="form-group">
									<label class="lbls"> Confirm</label>
									<input class="form-control" name="cp" placeholder="Confirm password" type="password">
									</div>
									<input type="submit" class="btn_blue" value="CONFIRM" />

							</form>
						</div>
					</div>
		</div>
	</div>

</body>
