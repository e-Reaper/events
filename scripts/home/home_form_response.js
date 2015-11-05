$(document).ready(function(){         //// for making the form more responsive

  $("#org_team").click(function(){      //// slide down the organiser detail's input field
	$("#org_table_cont").slideDown();
  });  
  $("#add_more_org").click(function(){           //// to add more organisers, Adds the organiser and then gives you a fresh input field for another one
	var k=parseInt($("#num_org").val());
	var organiser=$("#org_name_edit").val();
	var details=$("#org_desc_edit").val();
	var orgId=$("#org_id_edit").val();
	if(organiser=="") return false;
	$("#num_org").val(k+1);
	var str="\
	<div class='orgs'>\
	<input type='text' name='orgName"+k+"' id='orgName"+k+"' readonly>\
	<input type='text'  autocomplete='off' name='orgDesc"+k+"' id='orgDesc"+k+"' readonly>\
	<input type='text' id='orgId"+k+"' name='orgId"+k+"' readonly>\
	<span id='orgNamespan"+k+"' style='font-weight:bold'>"+organiser+" :</span>\
	<span id='orgDescspan"+k+"'>"+details+"</span>\
	</div>";
	$("#org_table").append(str);
	$("#orgName"+k).val(organiser);
	if(orgId!="")$("#orgNamespan"+k).html("<a href='"+base+"users/accounts/"+orgId+"'>"+organiser+"</a>");
	$("#orgDesc"+k).val(details);
	$("#orgId"+k).val(orgId);
	$("#org_name_edit").val("");
	$("#org_desc_edit").val("");
	$("#org_id_edit").val("");
	});
  
  $("#reset_all_org").click(function(){              //// reset all the organiser data filled till now
	$("#org_table").html("");
	$("#num_org").val(0);
  });
  $("#reset_all_link").click(function(){              //// reset all the link data filled till now
	$("#link_table").html("");
	$("#num_link").val(0);
  });
  
  
  $("#eve_logo").click(function(){               //// show the upload image column when clicked on the add event logo button             
	$("#get_logo").slideDown();
  });
  
  
  $("#oth_link").click(function(){               //// show the field to enter other links related to event when clicked on add other link
	$("#link_table_cont").slideDown();
  });
  
  
  $("#add_more_link").click(function(){          //// add the previous link and then gives a new filed to input anothe link
	var k=parseInt($("#num_link").val());
	$("#num_link").val(k+1);
	var link=$("#link").val();
	$("#link").val("");
	var detlink=$("#detLink").val();
	$("#detLink").val("");
	var str="<div class='row'><span>"+detlink+" : </span><span style='color:blue'>"+link+"</span><input type='hidden' name='link"+k+"' id='link"+k+"' placeholder='link "+(k+1)+"' value='"+link+"'><input type='hidden' name='detLink"+k+"' id='detLink"+k+"'  value='"+detlink+"' placeholder='detail of link "+(k+1)+"'></div>";
	$("#link_table").append(str);
	});
  
    
  $("#gen_hash").click(function(){              /////   show the hashtag input field when clicked on add hashtag
	$("#hash_table_cont").slideDown();
  });  

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


  $("#add-finish-time").click(function(){        ////// shows finish date time column when clicked on  " add finish time "
	$("#add-finish-time").hide();
    $("#f_timing").slideDown();
	$("#delete-finish-time").show();
  });
  
  $("#delete-finish-time").click(function(){    ////// hide finish date time column when clicked on  " delete finish time "
    $("#delete-finish-time").hide();
    $("#f_timing").slideUp();
	$("#add-finish-time").show();
  });
 
  $("#show_options").click(function(){          ///// show extra options when clicked on show option
    $("#options").slideDown();
	$("#show_options").hide();
	$("#hide_options").show();
	return false;
  });
  
  $("#hide_options").click(function(){           //// hide all the option when clicked on hide option
    $("#options").slideUp();	
	$("#show_options").show();
	$("#hide_options").hide();
	return false;
  });
    
	$("#org_name_edit").keypress(function(e){	                                 ///// when a key is pressing in the textbox,it gives sugggestions		
		var search = $("#org_name_edit").val()+String.fromCharCode(e.keyCode);
		feedUsers(search);
	});	
	$("#org_name_edit").keyup(function(e){	                                 ///// when a key is pressing in the textbox,it gives sugggestions		
		var search = $("#org_name_edit").val();
		feedUsers(search);
	});	  
	function feedUsers(search)
	{
		$("#org_name_edit").css("color","red");
		$("#org_id_edit").val("");
		if(search.search("#")!=-1||search==""||search==" ") {
			$('#userSuggestion').html("");
			return false;
		}
		search = search.replace(/#/gi,'');
		search = search.replace(/ /gi,'{{}}');
		
		$.get(base+"users/search/"+search,function(data,status){                         ////// getting all the username and email and id of users you search
			$('#userSuggestion').html(data);
			//alert(data);
		});
	}
	$("#allumini_type").hide();
});
function put_into_organiser(e,f)
{
	$("#org_name_edit").val(f);
	$("#org_name_edit").css("color","green");
	$("#org_id_edit").val(e);	
	$('#userSuggestion').html("");
}
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





