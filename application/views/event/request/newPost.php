
<?php 
				foreach($activity as $act)
				{
				?>
					<div class="post">
						<div id="activityFor<?php echo $act->activity_id; ?>">
							<?php if($act->table_name==1){?>
								changed
							<?php }else if($act->table_name==2){ ?>
							<div style="background:#ddd;margin:10px;padding:10px">
								<?php 
									foreach($posts as $p)
									{
									
										if($p->type==5)
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
														<?php echo $p->Content ?>
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
										if($p->type==4)
										{
											
										}
									}
								?>
							</div>
							<?php }?>
						</div>
					</div>
					<?php if ($act->table_name==2){?>	
					<script>
						
					</script>
					<?php
					}
				}
?>