<?php
$parent=0;

foreach($options as $opt)
{	
	$parent=$opt->parent_id;
	if($type==1 || $type==4)
	{?>
		<input type="radio" name="poll_<?php echo $opt->parent_id?>" value="<?php echo $opt->id?>">
		<?php echo $opt->content?> <span class="pull-right">+<?php echo $opt->count;?></span><br>
	<?php 
	}
	if($type==2 || $type==3)
	{ ?>
		<input type="checkbox" name="poll_<?php echo $opt->parent_id?>" value="<?php echo $opt->id?>"> <?php echo $opt->content?>
		<span class="pull-right">+<?php echo $opt->count;?></span><br>
	<?php 
	}	
}
?>
