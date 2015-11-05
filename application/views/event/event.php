<?php require_once("include/convert.inc"); ?>
<?php foreach($event as $e) { ?>
	<?php function can($e,$user){		
			if($e->creator==$user)
			return true;
			else{
				if(isset($organisers))
				{
					foreach($organisers as $o){
						if($o->User_Id==$user){
							return true;
						}
						else
							return false;
					}
				}
				else
				return false;
			}					
		}
		function checked($l)
		{
			$sub="http://";
			$c=str_replace($sub,"",$l);
			return "http://".$c;
		}
?>
	<?php echo '<script>var base="'.base_url().'"; var event_id="'.$e->event_id.'"</script>'; ?>
	<center>
		<div class="row container">
			<img class="img-rsponsive" style="height:300px;width:90%" src="<?php echo base_url();?>images/eventlogos/<?php echo $e->event_logo ?>">
			<div class="row container" id="control-bar">
				<div class="col-md-4 options" id="title">
					<span class="" style="font-size:40px;padding:0px;margin:0px;"><?php echo $e->title; ?></span><br>
					<?php if(!$hash && can($e,$this->session->userdata('user_id'))){?>
							<span id='hashtag_content' style='padding:0px 0px 0px 20px'>#<span id='hashtag_only'>Click Edit to add HashTaag</span>
							<input type="text" id="hashtag_changed_content" value="no hashtags allotted yet"  style="display:none;border:none">
							<span id="hash_favour"><span class="btn btn-default" id="edit-hashtag-button">Edit</span>
							<span class="btn btn-default" id="save-hashtag-button" style="display:none">Save</span>							
							</span><script>
								$(document).ready(function(){  
									$("#edit-hashtag-button").click(function(){
										$("#hashtag_changed_content").show();
										$("#hashtag_only").hide();
										$("#save-hashtag-button").show();
										$("#edit-hashtag-button").hide();
									});	
									$("#save-hashtag-button").click(function(){
										var new_hash=$("#hashtag_changed_content").val();
										
										$.post(base+"site/editHash/"+new_hash+"/"+event_id,function(data,status){
											$("#hashtag_changed_content").hide();
											$("#hashtag_only").html(new_hash);
											$("#hashtag_only").show();
											$("#save-hashtag-button").hide();
											$("#hash_favour").html("");
										});
									});
										
								});
							</script>								
					<?php }?>
					<?php foreach($hash as $h)
					{
						echo "<span id='hashtag_content' style='padding:0px 0px 0px 20px'>#<span id='hashtag_only'>".$h->hashtag."</span>";
						echo '</span>';
					}
					?>
				</div>
				<div class="col-md-3 options" id="attending">
					<?php 
					$current_date=date('Y/m/d');
					$current_time=date('G:i');
					if($e->sdate>$current_date || $e->sdate==$current_date && $e->stime> $current_time) {
					?>
					<br>
					<input type="radio" id="Rattending" name="attend" value="yes" onchange="attend('<?php echo $e->event_id; ?>',1,'<?php echo base_url(); ?>','<?php echo $this->session->userdata('user_id'); ?>')" <?php if($attend==1) echo 'checked';?>> Attending
					&nbsp;&nbsp;&nbsp;
					<input type="radio" id="Rnotattending" name="attend" value="no" onchange="attend('<?php echo $e->event_id; ?>',0,'<?php echo base_url(); ?>','<?php echo $this->session->userdata('user_id'); ?>')" <?php if($attend==0) echo 'checked';?>> Not Attending
					<?php }else { 
						if($attend==1) {  echo "<span style='font-weight:bold;font-size:20px;color:grey'>you attended this event</span>"; }
						if($attend==-1) {  echo "<span style='font-weight:bold;font-size:20px;color:grey'>you Missed this event</span>"; }
						if($attend==0) {  echo "<span style='font-weight:bold;font-size:20px;color:grey'>you refused to go to this event</span>"; }
					} ?>
					
				</div>
				<div class="col-md-5 " id="notattending"><br>
				<span class="submit" onclick="guestList(<?php echo $e->event_id; ?>,'<?php echo base_url(); ?>')">Guests</span>
				<?php if($e->sdate>$current_date || $e->sdate==$current_date && $e->stime> $current_time) { ?>
					<span class="submit" onclick="getUserToInvite(<?php echo $e->event_id; ?>,'<?php echo base_url(); ?>')">Invite</span>
				<?php } ?>
				<span class="submit" style="">Share</span>
				<?php
				if(can($e,$this->session->userdata('user_id')))
				{
				?>
				<span class="submit" id="edit-event" style="" onclick="edit-event(<?php echo $e->event_id; ?>,'<?php echo base_url(); ?>')">Edit</span>
				<?php
				}
				?>
				</div>	
			
		</div>
	</center>	
			
	<div class="container" style="padding:0px 0px 10px 5%">  <!---------------- event details ------------------------>
		<div class="col-md-6" id="contains-details">
			<br><span class="h3">
				<?php echo $e->location; ?>
				<br>
				<b><span id="cityFor<?php echo $e->event_id; ?>"></span></b>
				<script>
					$(document).ready(function(){
						
						$.get(base+"help/city_by_id/"+<?php echo $e->city; ?>,function(data,status){			
							$('#cityFor<?php echo $e->event_id; ?>').html(data);
						});
					});
				</script>
			</span>
			<br>
			<br>
			<span style="color:black;"><tt>(<?php echo convertdateback($e->sdate); ?> <?php echo converttimeback($e->stime) ?>
			<?php if($e->fdate){ ?> 
			- <?php echo convertdateback($e->fdate); ?><?php echo converttimeback($e->ftime);}?>)
			</tt></span>
			<br>
			<br>
			<div class="description"><?php echo $e->desc; ?></div>
			<div class="info">
			<h4>Other Links :</h4>
				<ul><?php foreach($links as $l){ ?>
					<li><?php echo '<a target="_blank" href="'.checked($l->link).'"><span>'.$l->link_detail.'</span></a>';?></li>
				<?php } ?>
				</ul>
			</div>
			
			<div class="info">
			<h4>Organisers :</h4>
				<ul>
				<?php foreach($organisers as $o){?>
					<li><?php if($o->User_Id) echo '<a href="'.base_url().'users/Account/'.$o->User_Id.'"><span>'.$o->Name.'</span></a>';
							else  echo '<span>'.$o->Name.'</span>';
					?>
					<br><?php echo $o->Description; ?>
					<br>
					</li>
				<?php } ?>
				</ul>
				
			</div>
			<hr>
	<!---------------for the comment,poll and post section --------------->	
		<div style="background:#eee;padding-bottom:30px"> <!---------------------poll-------------------->
		Add Poll question
		<?php echo form_open_multipart("site/createPoll/".$e->event_id);?>
		<ul>
			<li>
				<label for="poll_ques">Question:</label> <br>
				<textarea name="poll_ques" id="poll_ques" placeholder="Give a poll question" required pattern="[a-z A-Z 0-9]+" rows="4" style="width:80%;"></textarea><br><br>
			</li>
			
			<li>
				<label for="poll_type" class="">Type:</label> 
				<select name="poll_type" id="poll_type" required style="width:150px;" required>
					<option value="0">Single Choice</option>
					<option value="1">Multiple Choice</option>
				</select>
			</li>
			<li>
				<label for="poll_restriction" class="">Who can add Option?:</label> 
				<select name="poll_restriction" id="poll_restriction"  style="width:150px;"  required>
					<option value="0">Only me</option>
					<option value="1">Everyone</option>
				</select>	
			</li>
		</ul>
		<div id="options">
					<!----------------------Add options------------------------->
			<div>
				<div id="poll_options">
					<div id="opt_table_cont" class="option-items">
						<div id="opt_table">
						</div>	
					   <div id="add">
						<center>
							<input type='text' id="option_value" placeholder='Option'><span id="add_more_opt" class="btn btn-default">+ Add</span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="reset_all_opt" class="btn btn-default" style="">- Reset</span>
							<input type="hidden" id="option_id">
						</center>
						</div>
					</div>
				</div>
				<input type="hidden" name="num_opt" value="0" id="num_opt">
			</div>
		</div>
		<input class="submit pull-right" type="submit" name="submit" id="submit_poll" value="create poll">
		</form>
		</div><!-------------------end of poll----------------------->
		<hr>
		<!----------------------------post--------------------------->
		<div  style="background:#eee;padding-bottom:30px">
		<textarea name="post_by_user" id="post_by_user" style="height:100px;width:100%;" placeholder="Write a post ..."></textarea><br><br>
		<div>
		<input type="button" class="submit pull-right" value="Add Post" onclick="submit_post()" id="submit_post">
		</div>
		</div>
		<!----------------------------end of post--------------------------------->
		
		<legend><span  class="btn btn-default disabled" >Recent Activities</span></legend>
		<!--------------------------------recent activities--------------->
		<div id="post_and_comment" >
				<?php 
				foreach($activity as $act)
				{
				?>
					<div class="post">
						<div id="activityFor<?php echo $act->id; ?>">
							
						</div>
					</div>
					<?php if($act->table_name==1){?>
						<script>
							$(document).ready(function(){
								$.get(base+"help/edit_history_by_id/<?php echo $act->activity_id;?>/<?php echo $act->table_name; ?>",function(data,status){
									$("#activityFor<?php echo $act->id; ?>").html(data);
								});
							});
						</script>	
					<?php } ?>
					<?php if ($act->table_name==2){?>	
						<?php if($act->activity_type==1||$act->activity_type==6) { ?>
							<script>
								$(document).ready(function(){
									$.get(base+"help/post_by_id/<?php echo $act->activity_id;?>/<?php echo $act->table_name; ?>",function(data,status){
										$("#activityFor<?php echo $act->id; ?>").html(data);
									});
								});
							</script>
						<?php
						}
					}
				}
				?>
		</div>
		<!-----------------------end of recent activities--------------->
	<!--------------------------------------------------------------->		
		</div>
		<div class="col-md-5 list">
			<center>			
				<div id="invite-search-box">
				<h3>Invite Guests</h3>
				<div class="row" style="padding:10px 0px;border-radius:10px;background:white;width:95%;"><input type="text" name="search-invitee" id="search-invitee" placeholder="enter name or keyword"></div><br>
				</div>
				<div id="guest-search-box">
				<h3>Guests</h3>
				<div class="row" style="padding:10px 0px;border-radius:10px;background:white;width:95%;"><input type="text" name="search-guest" id="search-guest" placeholder="enter name or keyword"></div><br>
				</div>
				<div id="errmsg">
					
				</div>
			</center>
			
			<div id="list">

			</div>
		</div>
	</div>
	
<?php }
?>	

