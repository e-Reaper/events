<?php 
$i=0;
$str="";
foreach($few as $f){
if($i>0)
$str=$str.",";
$str=$str."<a href='".base_url()."users/accounts/".$f->id."'>".$f->name."</a>";
$i++;
}
foreach($num as $n)
{
	if($n->num-3>0){
		$str=$str." and ".($n->num-3)."others ";
	}
	if($n->num==1)
	$str=$str." is going";
	else
	$str=$str." are going";
	if($n->num==0)
	$str="";
}
?>
<?php echo $str; ?>
<?php 
/*SELECT COUNT( Guest_Id ) 
FROM event_guests
WHERE Event_Id =2
*/
?>