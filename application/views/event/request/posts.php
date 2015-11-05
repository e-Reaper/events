<div style="background:#ddd;margin:10px;padding:10px">
	<?php 
	if($type==2)                        //////// if table is event_posts
	{
		foreach($posts as $p)
		{
			if($p->type==5)                   ////////////// if a post has been posted 
			{
			?>
			<div class="row" style="text-shadow:none;color:black">
				<div class="col-md-2">
					<img src="<?php echo base_url()?>images/users/<?php echo $p->image?>" style="border-radius:25px;width:50px">
				</div>
				<div class="col-md-9">
					<div>
						<span class="poster-name">
							<a href="<?php echo base_url()?>users/account/<?php echo $p->uid ?>">
								<b>
									<?php echo $p->name ?>
								</b>
							</a>
						</span>
						<hr style="padding:0px;margin:2px;border-color:white"><?php echo $p->Date ?>
						<div>
							<?php echo urldecode($p->Content); ?>
						</div>
						<hr style="padding:0px;margin:2px;border-color:white" width="150">
						<span class="btn btn-sm" onclick="like(<?php echo $p->post_id ?>,3)" id="like">
							Like
						</span>
						<span class="btn btn-sm" onclick="get_comment(<?php echo $p->post_id?>,3)">
							comment
						</span><br>
						<span id="liked_<?php echo $p->post_id ?>_3">
							<script>
								get_like(<?php echo $p->post_id?>,3);
							</script>
						</span>
					</div>
					<div id="commentFor<?php echo $p->post_id?>">
						
					</div>
					<div id="my-own-comment-for-<?php echo $p->post_id?>" class="row" style="padding:6px">
						<div class="col-md-2">
						<img src="<?php echo base_url()?>images/users/<?php echo $this->session->userdata('image'); ?>" style="border-radius:25px;width:50px">
						</div>
						<div class="col-md-9">
								<span class="poster-name">
									<a href="<?php echo base_url()?>users/account/<?php $this->session->userdata('user_id'); ?>">
										<b>
											<?php echo $this->session->userdata('user_name'); ?>
										</b>
									</a>
								</span>
								<div>
									<input type="text" style="width:90%;" id="newComment<?php echo $p->post_id; ?>" placeholder="say something ... ">
									<img class="small-icon" src="<?php echo base_url()?>images/gtick.png" onclick="comment(<?php echo $p->post_id ?>,3)">
								</div>
						</div>
					</div>

				</div>
			</div>
			<?php
			}
			else{
			?>
				<div class="row" style="text-shadow:none;color:black">
				<div class="col-md-2">
					<img src="<?php echo base_url()?>images/users/<?php echo $p->image?>" style="border-radius:25px;width:50px">
				</div>
				<div class="col-md-9">
					<div>
						<span class="poster-name">
							<a href="<?php echo base_url()?>users/account/<?php echo $p->uid ?>">
								<b>
									<?php echo $p->name ?>
								</b>
							</a>
						</span>
						<hr style="padding:0px;margin:2px;border-color:white"><?php echo $p->Date ?>
						<div>
							<?php echo $p->Content ?>
						</div>
						<hr style="padding:0px;margin:2px;border-color:white" width="150">
			
				<?php 
				if($p->type<5) //// a poll 
				{
				?>
					<div id="option_for_<?php echo $p->post_id; ?>"></div>
					<script>
						$(document).ready(function(){
							$.get(base+"help/get_poll_option/<?php echo $p->post_id;?>/<?php echo $p->type; ?>",function(data,status){
								$("#option_for_<?php echo $p->post_id; ?>").html(data);
							});
						});
					</script>
					<input type="button" class="btn btn-default btn-sm" value="Done" id="done_voting_for_<?php echo $p->post_id ?>"><br>
					<?php if($p->type==3||$p->type==4|| $p->Unique_user_id == $this->session->userdata('user_id')){?>
					<input type="text" id="new_option_for_<?php echo $p->post_id; ?>">
					<input type="button" class="btn btn-default btn-sm" value="add an option" id="add_new_option_for_<?php echo $p->post_id ?>">
					<script>
						$(document).ready(function(){
							$("#add_new_option_for_<?php echo $p->post_id; ?>").click(function(){
								var newopt=$("#new_option_for_<?php echo $p->post_id; ?>").val();									
								$.get(base,function(data,status){
									$("#option_for_<?php echo $p->post_id; ?>").append(data);
							});
						});
					</script>
					<?php }
				}
			}
		}
	}
	else if($type==1)                   //////// if table is event_edit
	{
		foreach($posts as $p)
		{ ?>
			<div class="row" style="text-shadow:none;color:black">
				<div class="col-md-2">
					<img src="<?php echo base_url()?>images/users/<?php echo $p->image?>" style="border-radius:25px;width:50px">
				</div>
				<div class="col-md-9">
					<span class="poster-name">
						<a href="<?php echo base_url()?>users/account/<?php echo $p->uid ?>">
							<b>
								<?php echo $p->name ?>  
							</b> 
						</a>
							<?php 
								if($p->field==1) echo 'Changed Title ' ;
								if($p->field==2) echo 'Changed Location ' ;
								if($p->field==3) echo 'Changed Location and City ' ;
								if($p->field==4) echo 'Changed Start date ' ;
								if($p->field==5) echo 'Changed Start Time ' ;
								if($p->field==6) echo 'Changed Start Time and Date ' ;
								if($p->field==7) echo 'Changed Finish Date ' ;
								if($p->field==8) echo 'Changed Finish Time ' ;
								if($p->field==9) echo 'Changed Finish Time and Date ' ;
								if($p->field==10) echo 'Changed Description ' ;
								if($p->field==11) echo 'Changed Public Access ' ;
								if($p->field==12) echo 'One More Guest has been added ';
								if($p->field==13) echo 'Changed Organiser Details ' ;
								if($p->field==14) echo 'Changed Event other Links ' ;
								if($p->field==15) echo 'Added Hashtag ' ;
							?>
						for the event 
					</span>
					<hr style="padding:0px;margin:2px;border-color:white"><?php echo $p->time ?>					
				</div>
			</div>
				
		<?php }
	}
	?>
</div>