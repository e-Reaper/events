
<?php
/////G617K30
 echo doctype();?>
<html lang="en">
<head>
  <meta charset="utf-8">
   <title>Almashines login</title>
   <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>styles/login/login_styles.css">
   <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>styles/plugin/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>styles/plugin/base_style.css">
</head>
<body>
		<div class="navbar navbar-inverse navbar-static-top">
			<div class="col-md-2" >
				<img src="<?php  echo base_url(); ?>images/Almashines.png" id="banner">
			</div>
			<div class="login_form" style="position:relative;top:5px;color:white">				
					<?php echo form_open('users/loginProcess'); ?>
					Email: <input type="text" id="email" name="email" placeholder="Enter the Email Address">
					Password: <input type="password" id="password" name="password" placeholder="Enter the password">
					<input id="login" type="submit" class="submit" name="login" value="Login">
					<?php echo form_close(); ?>
				</div>
		</div>
		
		<?php if(isset($Success))
		{ 
		?>
					<div id="errorDiv" style="margin:10px 30%;">
						<center><h3><?php echo $Success ?></h3><?php echo validation_errors(); ?></center>
					</div>			

			
		<?php 
		} 
		?>		
		<div class="container">
		<center>
		<fieldset class="" >
		
			<legend>SignUP</legend>
			<?php echo form_open_multipart('users/register'); ?>
			<div class="formc">
				<label for="Email">Name:</label>
				<input type="text" id="name" name="name" placeholder="Enter the Name" required pattern="[a-z A-Z]+">
				<br />
				<label for="Email">Email:</label>
				<input type="text" id="email" name="email" placeholder="Enter the Email Address" required pattern="[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})">
				<br />
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" placeholder="Enter the password" required>
				<br />
				<label for="password">Confirm Password:</label>
				<input type="password" id="password" name="cpassword" placeholder="Enter the password" required>
				<br />
				<label for="password"></label>
				<input type="file" id="file" name="file" placeholder="choose file" >
				(optional for profile picture)<br/><br/>
				
				<input id="register" type="submit" class="submit" name="register" value="Register">
				<br />
			</div>
			<?php echo form_close(); ?>
		</fieldset>

		</center>
		</div>
</body>
</html>