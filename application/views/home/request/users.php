<?php
foreach($result as $r){
?>	<div class="row row-of-user-results" onclick="put_into_organiser('<?php echo $r->id ?>','<?php echo $r->name ?>')">
		<img class="img-responsive col-md-3 icon" src="<?php echo base_url(); ?>images/users/<?php echo $r->image ?>">
		<div class="col-span-8">
			<span class="user-name"><?php echo $r->name; ?></span><br>
			<span class="user-mail"><?php echo $r->email; ?></span>
		</div>
	</div>
<?php 
}
?>