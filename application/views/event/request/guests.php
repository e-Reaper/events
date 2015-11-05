<div class="guest-list">
<?php
	foreach($result as $r)
	{
	?>
		<div class="guest col-md-12">
			<img src="<?php echo base_url()?>images/users/<?php echo $r->image; ?>" class="user-small-pic" ><a href="<?php echo base_url();?>users/accounts/<?php echo $r->id ;?>"><span><b><?php echo $r->name; ?></b></span></a>
		</div>
	<?php
	}
?>
</div>
<hr>