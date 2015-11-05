
<div class="guest-list">
<?php
	foreach($result as $r)
	{
	if($r->id==$this->session->userdata('user_id')) continue;
	?>
		<div class="row" id="invitee<?php echo $r->id ?>">
			<div class="guest col-md-8" >
				<img src="<?php echo base_url()?>images/users/<?php echo $r->image; ?>" class="user-small-pic" ><a href="<?php echo base_url();?>users/accounts/<?php echo $r->id ;?>"><span><b><?php echo $r->name; ?></b></span></a>&nbsp;
			</div>
			<input type="button" class="col-md-3 invite-checkbox" onclick="invite(<?php echo $r->id ;?>,<?php echo $event ;?>,<?php echo $this->session->userdata('user_id') ?>,'<?php echo base_url()?>')" value="Invite">
		</div>
	<?php
	}
?>
</div>
<hr>