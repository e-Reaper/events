<?php  $num_org=$k;  ?>


<input type="text" name='orgName<?php echo $num_org;?>' autocomplete="off"  id="org<?php echo $num_org; ?>" placeholder='name'>
<input type="text" name="orgDesc<?php echo $num_org;?>" placeholder='details'>
<input type="hidden" id="idorg<?php echo $num_org;?>" name="orgId<?php echo $num_org; ?>">
<br><div id="Suggestorg<?php echo $num_org; ?>"></div>

<script>
	$("#org<?php echo $k; ?>").focusin(function(e){	    ///// when a key is pressed in the textbox for organisers,it gives sugggestions		
		var _this=$(this).attr('id');
		global_organiser_var=_this;
		var search = $("#"+_this).val();
		feedUsers(search,_this);
	});
	
/*	$("#org<?php echo $k; ?>").focusout(function(e){ ///// when a focus out of the textbox for organisers,it gives no sugggestions		
		var _this=$(this).attr('id');
		$('#Suggest'+_this).hide();	
	});
	*/
	
	$("#org<?php echo $k; ?>").keypress(function(e){     ///// when a key is pressed in the textbox for organisers,it gives sugggestions		
		var _this=$(this).attr('id');
		global_organiser_var=_this;
		var search = $("#"+_this).val()+String.fromCharCode(e.keyCode);
		feedUsers(search,_this);
	});	

	
	$("#org<?php echo $k; ?>").keyup(function(e){        ///// when a key is unpressed in the textbox for organisers ,it gives sugggestions		
		var _this=$(this).attr('id');
		var search = $("#"+_this).val();
		global_organiser_var=_this;
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
	}
</script>