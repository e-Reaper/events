<?php
	if($type==3)
	{
		echo '<input type="checkbox" name="poll_'.$parent_id.'" value="'.$content.'">'.$content.'<br>';
	}
	else if($type==4)
	{
		echo '<input type="radio" name="poll_'.$parent_id.'" value="'.$content.'">'.$content.'<br>';		
	}
?>