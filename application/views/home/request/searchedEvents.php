<?php
function highlight($string,$item){
	$str="";
	if (stripos($item, $string) !== false){
	$pos1=stripos($item,$string);
	$pos2=$pos1+strlen($string)-1;
	$str = $str." ".substr($item,0,$pos1);
	$str = $str.'<b style="background:lightgreen">'.substr($item,$pos1,strlen($string)).'</b>';
	$str = $str.''.substr($item,$pos2+1);
	return $str;
	}
	else
	return $item;
}


foreach ($results as $r)
{
?>
	<div class="row searched-items">
	
		<div class="col-md-2">
			<a href="<?php echo base_url(); ?>site/events/<?php echo $r->event_id ?>">
			<img class=" events-icon" src="<?php echo base_url(); ?>images/eventlogos/<?php echo $r->event_logo;?>">
			</a>
		</div>
	
		<div class="col-md-9" style="font-size:10px;">
			<br>
			<span style="font-size:14px;" class="col-md-3">
				<a href="<?php echo base_url(); ?>site/events/<?php echo $r->event_id ?>">
					<?php echo highlight($str,$r->title); ?>			
				</a>					
			</span>
			<span style="color:#666;font-size:12px;" class="col-md-5">
								&nbsp;&nbsp;&nbsp; <?php echo highlight($str,$r->location); ?>
			</span>		
		</div>
	</div>
<?php 
}
?>