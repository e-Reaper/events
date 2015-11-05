<script>
	$(document).ready(function(){     

	//////////////////////////////////////////////////////////////////////
	$("#show-edit-event-details").click(function(){ 		         
		$("#edit-event-details").slideDown();
		$("#hide-edit-event-details").show();
		$("#show-edit-event-details").hide();
	});	
	$("#hide-edit-event-details").click(function(){
		$("#edit-event-details").slideUp();
		$("#hide-edit-event-details").hide();
		$("#show-edit-event-details").show();
	});
	/////////////////////////////////////////////////////////////////////
	
	//////////////////////////////////////////////////////////////////////
	$("#show-edit-organiser-details").click(function(){ 		         
		$("#edit-organiser-details").slideDown();
		$("#hide-edit-organiser-details").show();
		$("#show-edit-organiser-details").hide();
	});	
	$("#hide-edit-organiser-details").click(function(){ 		         
		$("#edit-organiser-details").slideUp();
		$("#show-edit-organiser-details").show();
		$("#hide-edit-organiser-details").hide();
	});	
	/////////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////////////////
	$("#show-edit-link-details").click(function(){ 		         
		$("#edit-link-details").slideDown();
		$("#hide-edit-link-details").show();
		$("#show-edit-link-details").hide();
	});	
	$("#hide-edit-link-details").click(function(){ 		         
		$("#edit-link-details").slideUp();
		$("#show-edit-link-details").show();
		$("#hide-edit-link-details").hide();
	});	
	/////////////////////////////////////////////////////////////////////
    $( "#e_s_date" ).datepicker({                   //// pick date for start date column
	changeMonth: true,//this option for allowing user to select month
	changeYear: true //this option for allowing user to select from year range
	  });
	  $( "#e_f_date" ).datepicker({                   //// pick date for finish date column
		changeMonth: true,//this option for allowing user to select month
		changeYear: true //this option for allowing user to select from year range
	  });
	  $("#e_s_time").timepicker({ 'step': 15 }); //timepicker for start time 
	  $("#e_f_time").timepicker({ 'step': 15 }); //timepicker for finish time
});	
</script>
<?php foreach($event as $e) { ?>
<?php echo form_open_multipart("site/EditEventPic/".$e->event_id."/".$e->event_logo); ?>
<div class="">
	<input type="file" name="file" id="file-type-input" class="hidden">
	<input class="" id="choose-file" type="button" value="Change Image" name="submit"> 
	<span id="messege-before-upload">the image should be in a jpg | png | jpeg only with size less than 2MB other wise the uploaded image will be ignored</span>	
</div>
<div id="submit-edited-image" style="display:none">
	<input class="col-md-3 submit" type="submit" value="Change" name="submit"><input class="col-md-3 submit" id="edit-image-reset" type="reset" value="cancel" name="cancel">
</div>
<br>
<script>
	$("#choose-file").click(function(){
		$("#file-type-input").click();
	});
	$("#file-type-input").change(function(){
		$("#messege-before-upload").html("<b>You have selected your image . Are you sure you want to change the display pic of the event</b>");
		$("#submit-edited-image").show();
		$("#choose-file").hide();
	});
	$("#edit-image-reset").click(function(){
		$("#messege-before-upload").html("the image should be in a jpg | png | jpeg only with size less than 2MB other wise the uploaded image will be ignored");
		$("#submit-edited-image").hide();
		$("#choose-file").show();
	});
</script>
<?php echo form_close(); ?>			
<?php echo form_open('site/EditEvent/'.$e->event_id); ?>

	<div class="show-edit-details-button" >
		Edit Event Details
		<span class="bold pull-right show-editable-form" id="show-edit-event-details"><a>&#9660;</a></span>
		<span class="bold pull-right hide-editable-form" id="hide-edit-event-details"><a>&#9650;</a></span>
	</div>
	<div id="edit-event-details" >
			<label for="e_title">Title:</label><br> 
			<input type="text" name="e_title" id="e_title" placeholder="Title" required pattern="[a-z A-Z 0-9]+" value="<?php echo $e->title?>"><br><br>
			<label for="e_location">Venue:</label><br>
			<input type="text" name="e_location" id="e_location" placeholder="Location" value="<?php echo $e->location ?>" required/><br><br>
			<label for="e_location">City:</label> 
			<select name="e_city" id="e_city" required style="width:80%;">
				<?php foreach($list_of_cities as $c) { ?>
				<?php if($c->id==$e->city){
				?>
					<option value="<?php echo $c->id ?>" selected><?php echo $c->name." (".$c->region.")"; ?></option> 				 
				<?php 
					}
					else{
				?>
					<option value="<?php echo $c->id ?>"><?php echo $c->name." (".$c->region.")"; ?></option>
				<?php 
					}
				} ?>
			</select><br><br>
			<label for="event_type" class="">Type:</label> <br>
			<select name="event_type" id="event_type" required style="width:150px;" onchange="setType()">
				<option value="1" <?php if($e->type==1) echo "selected";?>>student</option>
				<option value="0" <?php if($e->type>2)  echo "selected";?>>Allumini</option>
				<option value="2" <?php if($e->type==2) echo "selected";?>>Other</option>
			</select>
			<select name="allumini_type" id="allumini_type"  style="width:170px;"  onchange="setType()" required>
				<option value="3" <?php if($e->type==3) echo "selected";?>>Location Based</option>
				<option value="4" <?php if($e->type==4) echo "selected";?>>Batch Based</option>
				<option value="5" <?php if($e->type==5) echo "selected";?>>Other</option>
			</select>
			<script>
			$(document).ready(function(){
				$("#allumini_type").hide();
				<?php if($e->type>2) echo '$("#allumini_type").show();'; ?>

			});
				function setType()
				{
					var x=$("#event_type").val();
					if(x==0)
					{
						$("#allumini_type").show();
						$("#e_type").val($("#allumini_type").val());
					}
					else
					{
						if(x==1||x==2)
						$("#allumini_type").hide();
						$("#e_type").val(x);
					}
				}
			</script>
			
			<input type="hidden" value="<?php echo $e->type; ?>" name="e_type" id="e_type">
			<br><br>
			<div id="s_timing">
				<label for="e_s_timing">Start Date/Time:</label><br> 
				<input  class="small" type="text" style="width:100px;" name="e_s_date" id="e_s_date" value="<?php echo convertDateForForm($e->sdate); ?>" required/>
				<input class="small" type="text" style="width:100px;" name="e_s_time" id="e_s_time" value="<?php echo $e->stime; ?>" required/>
			</div><br>
			<div id="f_timing">
				<label for="e_s_timing">End Date/Time:</label><br>
				<input class="small" type="text" name="e_f_date" value="<?php echo convertDateForForm($e->fdate); ?>" style="width:100px;" id="e_f_date" />
				<input class="small" type="text" name="e_f_time" value="<?php echo $e->ftime; ?>" style="width:100px;" id="e_f_time"  />
				<br>
			</div><br><br>
			<label style="">Description:</label><br>
			<textarea name="e_desc" id="e_desc" style="width:100%;height:150px" required>
				<?php echo $e->desc ?>
			</textarea>
			<br>			
			<br>			
			<input type="checkbox" name="e_public" id="e_public" <?php if ($e->event_public) echo "checked='true'"; ?>>  Make Event public
			<br>
			
		<?php } ?>
	</div>
	<div class="show-edit-details-button" >
		Edit Organiser
		<span class="bold pull-right show-editable-form" id="show-edit-organiser-details"><a>&#9660;</a></span>
		<span class="bold pull-right hide-editable-form" id="hide-edit-organiser-details"><a>&#9650;</a></span>
	</div>
	<div id="edit-organiser-details">
		<div id="org-table">
			<?php $num_org=0; foreach($organisers as $o){ ?>
				<input type="text" name='orgName<?php echo $num_org;?>' autocomplete="off"  id="org<?php echo $num_org; ?>" class="user-selector" value="<?php echo $o->Name; ?>" placeholder='name'>
				<input type="text" value="<?php echo $o->Description;?>" name="orgDesc<?php echo $num_org;?>" placeholder='details'>
				<input type="hidden" id="idorg<?php echo $num_org;?>" name="orgId<?php echo $num_org; ?>" value="<?php if(isset($o->User_Id))echo $o->User_Id; ?>"><br><div id="Suggestorg<?php echo $num_org; ?>"></div>
			<?php $num_org++; } ?>
		</div>
		<input type="hidden" value="<?php echo $num_org?>" name="num_org"  id="num_org">
		<span id="add-more-organiser-column" class="btn btn-default">Add More</span><span class="btn btn-default" id="reset-num-org">Reset</span>
	</div>
	<div class="show-edit-details-button" >
		Edit Links
		<span class="bold pull-right show-editable-form" id="show-edit-link-details"><a>&#9660;</a></span>
		<span class="bold pull-right hide-editable-form" id="hide-edit-link-details"><a>&#9650;</a></span>
	</div>
	<div id="edit-link-details">
		<div id="link-table">
			<?php $num_links=0; foreach($links as $l){ ?>
				<input type="text" name="link<?php echo $num_links; ?>" class="" value="<?php echo $l->link; ?>" placeholder='link'>
				<input type="text" name="detLink<?php echo $num_links; ?>" class="" value="<?php echo $l->link_detail;?>" placeholder='details'>
			<?php $num_links++;} ?>
		</div>
		<input type="hidden" value="<?php echo $num_links;?>" name="num_links" id="num_links">
		<span id="add-more-link-column" class="btn btn-default">Add More</span><span class="btn btn-default" id="reset-num-link">Reset</span>
	</div><br>
	<input class="submit pull-right" type="submit" name="submit" id="save-event-details-changes" value="Save changes">
<?php echo form_close();?>

<script>
	var global_organiser_var="";
	$("#add-more-organiser-column").click(function(){  //// to add more organisers, Adds the organiser and then gives you a fresh input field for another one
	var k=parseInt($("#num_org").val());
	$("#num_org").val(k+1);
		$.get(base+"help/getNewOrganiserColumn/"+k,function(data,status){                         ////// getting a new column for organiser
			$("#org-table").append(data);
		});
	});
  
  $("#reset-num-org").click(function(){              //// reset all the organiser data filled till now
	$("#org-table").html("");
	$("#num_org").val(0);
  });
  
   $("#add-more-link-column").click(function(){           //// to add more links, gives you a fresh input field for another one
	var k=parseInt($("#num_links").val());
	$("#num_links").val(k+1);
	var str="<input type='text' name='link"+k+"' placeholder='link'  required> <input type='text' placeholder='details' name='detLink"+k+"' >";
	$("#link-table").append(str);
	});
  
  $("#reset-num-link").click(function(){              //// reset all the organiser data filled till now
	$("#link-table").html("");
	$("#num_links").val(0);
  });

  
	$(".user-selector").focusin(function(e){	                      ///// when a key is pressed in the textbox for organisers,it gives sugggestions		
		var _this=$(this).attr('id');
		var search = $("#"+_this).val();
		feedUsers(search,_this);
	});
/*	$(".user-selector").focusout(function(e){	                      ///// when a focus out of the textbox for organisers,it gives no sugggestions		
		var _this=$(this).attr('id');
		$('#Suggest'+_this).hide();	
	});*/
	
	$(".user-selector").keypress(function(e){	                      ///// when a key is pressed in the textbox for organisers,it gives sugggestions		
		var _this=$(this).attr('id');
		var search = $("#"+_this).val()+String.fromCharCode(e.keyCode);
		feedUsers(search,_this);
	});	

	$(".user-selector").keyup(function(e){	                         ///// when a key is unpressed in the textbox for organisers ,it gives sugggestions		
		var _this=$(this).attr('id');
		var search = $("#"+_this).val();
		feedUsers(search,_this);
	});	  
	function feedUsers(search,_this)
	{
		$("#"+_this).css("color","red");
		$("#id"+_this).val("");
		if(search.search("#")!=-1||search==""||search==" ") {
			$('#Suggest'+_this).html("");
			return false;
		}
		search = search.replace(/#/gi,'');
		search = search.replace(/ /gi,'{{}}');

		$.get(base+"users/search/"+search,function(data,status){                         ////// getting all the username and email and id of users you search
			$('#Suggest'+_this).html(data);
		});
		global_organiser_var=_this;
	}
	function put_into_organiser(e,f)
	{
		$("#"+global_organiser_var).val(f);
		$("#"+global_organiser_var).css("color","green");
		$("#id"+global_organiser_var).val(e);	
		$('#Suggest'+global_organiser_var).html("");
	}
</script>