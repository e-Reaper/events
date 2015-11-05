<body>
	<div class="navbar navbar-inverse navbar-static-top">
		<div id="container">
			<div class="col-md-2 title">
				<img src="<?php echo base_url();?>images/Almashines.png" id="banner">
			</div>
			<div class="col-md-3 title">
				<br>
			</div>
			
			<button class="navbar-toggle" data-toggle = "collapse" data-target=".navHeaderCollapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<div class="collapse navbar-collapse navHeaderCollapse col-md-3 pull-right" style="padding:20px 30px 0px 0px">
				<ul class="nav nav-pills navbar-right">
					<li><ul class="no-list">
							<li><img src="<?php echo base_url();?>images/bulb.png" id="bulb" class="control"></li>
							<li class="notify" id=""></li>
						</ul>
					</li>
					<li>
						<ul class="no-list">
							<li><img src="<?php echo base_url();?>images/message.png" id="message" class="control"></li>
							<li class="notify" id="notification-box" >
								<div class="shift-right">
									<center>Notification</center>
									<div class="data">
										No notifications for now
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li>
						<ul class="no-list">
							<li><img src="<?php echo base_url();?>images/default.jpg" id="account" class="control"></li>
							<li class="notify" id="message-box" >
								<div class="shift-right">
									<center>Messages</center>
									<div class="data">
										No messages for now
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li>
						<ul class="no-list">
							<li><img src="<?php echo base_url();?>images/none.jpg"></li>
							<li class="notify" id="account-box">
								<div class="shift-right">
									<center>Account Settings</center>
									<div class="data">
										<table>
											<tr><td>Hello ! <a href="<?php echo base_url();?>users/account/<?php echo $this->session->userdata('user_id');?>"><?php echo $this->session->userdata('user_name');?></a></td></tr>
											<tr><td>Change password</td></tr>
											<tr><td>Help</td></tr>
											<tr><td><a href="<?php echo base_url(); ?>users/logout">LogOut</a></td></tr>
										</table>
									</div>
								</div>
							</li>
						</ul>
					</li>						
				</ul>
			</div>
		</div>	
	</div>
