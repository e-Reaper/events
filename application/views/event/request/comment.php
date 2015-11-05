<?php
	foreach($comments as $p)
	{
	?>
			<div class="row" style="background:#eee;padding:6px">
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
							<?php echo $p->time ?>
						</span>
						<div>
							<?php echo $p->comment ?>
						</div>
						<span onclick="like(<?php echo $p->comment_id ?>,4)">
							Like
						</span><br>
						<span id="liked_<?php echo $p->comment_id ?>_4">
							<script>
								$.get(base+"site/get_like/"+e+"/"+f,function(data,status){
									$("#liked_"+e+"_"+f).html(data);
								});
							</script>
						</span>
						
				</div>
			</div>
			<hr style="padding:0px;margin:2px;border-color:white">
	<?php
	}
?>
			