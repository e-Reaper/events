<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $title ?></title>
	<style type="text/css">
	</style>
</head>
<body>
	<div id="container">
	<?php
		foreach ($results as $row)
		{
			echo "<p>".$row->id." ";
			echo $row->name." ";
			echo $row->email." </p>";
		}
	?>
	</div>
	<a href="<?php echo base_url(); ?>site/home">Home</a>
	<a href="<?php echo base_url(); ?>site/about">About</a>
</body>
</html>