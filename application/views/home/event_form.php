<body>
<?php  echo '<script> var base = "'.base_url().'";</script>' ?>
<br>
<br>
<br>
<center>
<div class="container row">
	<div class="col-md-8 search-panel">
	<input type="text" name="search" id="search" placeholder="Search Event | Enter a keyword"><img src="<?php echo base_url();?>images/glass.png" id="glass" onclick="searchEvent()"><div id="event-search-result"></div>
	</div>
	<div class="col-md-3" style="position:relative;top:14px;"><span class="submit" id="show-event-form">Create Event</span></div>
</div>
<div class="row container">
	<div  id="src-res">
	</div>
</div>
<br>
</center>
<div class="container" id="create-event-form">
	<?php echo form_open_multipart('site/createEvent'); ?>
		<ul>
			<li>
				 <br/><h1>Event Details<br><br></h1>
				 <span class="required_notification">* Denotes Required Field</span>
			</li>
			<li>
				<label for="e_title">Title:</label> 
				<input type="text" name="e_title" id="e_title" placeholder="Give a short name to event" required pattern="[a-z A-Z 0-9]+"/><br>
			</li>
			<li>
				<label for="e_location">Venue:</label> 
				<input type="text" name="e_location" id="e_location" placeholder="Where it is going to be held" required/><br>
			</li>
			<li>
				<label for="e_city">City:</label> 
				<select name="e_city" id="e_city" required>
					<?php foreach($list_of_cities as $c) { ?><option value="<?php echo $c->id ?>"><?php echo $c->name." (".$c->region.")"; ?></option> <?php } ?>
				</select><br>
			</li>
			<li>
				<label for="event_type" class="">Type:</label> 
				<select name="event_type" id="event_type" required style="width:150px;" onchange="setType()">
					<option value="1">student</option>
					<option value="0">Allumini</option>
					<option value="2">Other</option>
				</select>
				<script>$(document).ready(function(){ alert(1);$("#allumini_type").hide(); }</script>
				<select name="allumini_type" id="allumini_type"  style="width:170px;"  onchange="setType()" required>
					<option value="3">Location Based</option>
					<option value="4">Batch Based</option>
					<option value="5">Other</option>
				</select>	
				<input type="hidden" value="1" name="e_type" id="e_type">
			</li>
			
			<li id="s_timing">
				<label for="e_s_timing">Start Date/Time:</label> 
				<input  class="small" type="text" style="width:200px;" placeholder="Start Date" name="e_s_date" id="e_s_date" required/>
				<input class="small" type="text" style="width:100px;" placeholder="Start Time" name="e_s_time" id="e_s_time" required/>
				<span id="add-finish-time" class="btn btn-default">+ Add End Date</span>
			</li>
			<li id="f_timing">
				<label for="e_s_timing">End Date/Time:</label> 
				<input class="small" type="text" name="e_f_date" placeholder="End Date" style="width:200px;" id="e_f_date" />
				<input class="small" type="text" name="e_f_time" placeholder="End Time" style="width:100px;" id="e_f_time" />
				<br>
				<span id="delete-finish-time" class="btn btn-default" >+ Remove End Date</span>
			</li>
			<li>
				<label style="">Description:</label><br><textarea name="e_desc" id="e_desc" required/></textarea><br>
			</li>	
			<li>
				<input type="checkbox" name="e_public" id="e_public"> Make Event public(Event page to be visible outside almashines)
			</li>
		</ul>
			<div>
				<div id="options">
						<!----------------------Add organisers------------------------->
						<div class="row">
							<div class=" more_options" id="org_team">
								<span id="org_team" class="other-option-item">+add organising team</span>
								<div id="org_table_cont" class="options-items">
									<div id="org_table">
									</div>	
									<div id="org_edit">
										<center>
										<input type='text' autocomplete="off"  id="org_name_edit" autofill="off" style="width:30%" class="organisers" placeholder='name of organiser'><input type='text' id="org_desc_edit" style="width:50%" class="organiserDetails" autocomplete='off' id='orgDesc0' placeholder='detail of organiser '><span id="add_more_org" class="btn btn-default">+ Add</span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="reset_all_org" class="btn btn-default" style="">- Reset</span>
										<input type="hidden" id="org_id_edit">
										</center>
									</div>
									<div id="userSuggestion"></div>
									<input type="hidden" name="num_org" value="0" id="num_org">
								</div>
							</div>
						</div><br>
						<!------------------------add links------------------------------->
						<div class="row">
						<div class="more_options">
								<span id="oth_link" class="other-option-item">+add other links</span>
								<div id="link_table_cont" class="options-items">
									<div id="link_table" style="display:block">
									</div>
										<div id="link_edit"  class="row container">
											<input type='url' name='link' id='link' placeholder='http://www.almashinesevents.com' style="width:40%">
											<input type='text' name='detLink' id='detLink' placeholder='detail of link'  style="width:30%">
											<span id="add_more_link"  class="btn btn-default">Add</span>&nbsp;&nbsp;&nbsp;&nbsp;
											<span id="reset_all_link" class="btn btn-default" style="">- Reset</span>
									</div>
									<input type="hidden" name="num_link" value="0" id="num_link" >
									
								</div>
							</div>
						</div><br>
						<div class="row">
							<div class="more_options" id="gen_hash">
								<span id="gen_hash" class="other-option-item">+Generate hashtag</span>
								<div id="hash_table_cont" class="options-items">
										<div>
											<input type='text' name='hash' id='hash' placeholder='hash 1'>
										</div>
								</div>
							</div>
						</div><br>
						<div class="row">
							<div class="more_options">
								<span id="eve_logo" class="other-option-item">+add event logo/photograph</span>
								<div id="get_logo" class="options-items">
									<input type="file" name="file" id="file_logo">
									<br><span style="color:red">Please upload gif/png/jpg/jpeg format image of size less than 2MB)</span>
								</div>
							</div>
						</div><br>
						<div class="row">
							<div class="more_options" id="inv_guest">
								<span id="invite" class="other-option-item">+invite	guests</span>
							</div>
						</div><br>
						<div class="row">
							<div class="more_options" id="pai_reg">
								<span id="paid_reg" class="other-option-item">Paid Registration</span>
							</div>
						</div><br>
				</div>
				<div>
					<br>
					<input type="button" class="submit" id="hide_options" value="Hide Options">
					<input type="button" class="submit" id="show_options" value="Options">
					<input class="submit" type="submit" name="submit" id="submit" value="create event">
				</div>
			</div>
	</form>
</div>
</center>
