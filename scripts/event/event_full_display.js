
function attend(e,f,g,h)
{	
	$.post( g+"site/attend/"+e+"/"+f+"/"+h, function( data ){  });
}
function guestList(e,g)
{		$("#invite-search-box").hide();
		$("#guest-search-box").show();
		$("#list").html("<img src='"+e+"images/gly.png'>");
	$.post( g+"site/guests/"+e, function( data ) {
		$("#list").html(data);
	});
}
function getUserToInvite(e,g)
{	
	$("#invite-search-box").show();
	$("#guest-search-box").hide();
	$("#list").html("loading...");
	$.post( g+"site/to_invite/"+e, function( data ) {
		$("#list").html(data);
	});
}
function invite(e,f,h,g){
	$.post( g+"site/invite/"+e+"/"+f+"/"+h+"/n", function( data ){  
		$("#invitee"+e).remove();		
	});
}

$(document).ready(function(){                                 ///// when search is done to see guests
	$("#invite-search-box").hide();
	$("#guest-search-box").hide();
			
	$("#search-guest").keypress(function(e){	                ////  whenever smthng typed in the search box 
		var search = $("#search-guest").val()+String.fromCharCode(e.keyCode); ////
		feed(search);									////  search for the string and get the results
	});
	$("#search-guest").keydown(function(e){		             ////  to find the same as above but only for backspace keypress
		if(e.which==8)
		{
			var search = $("#search-guest").val();
			if(search.length>1)
				feed(search);
			else
			{
				guestList(event_id,base);
			}
		}
	});	
	$("#search-guest").focusin(function(e){		              //// whenever focus to search box goes in the ressult should be shown
			var search = $("#search-guest").val();
			if(search.length>0)
				feed(search);
			else
				guestList(event_id,base);
	});
	function feed(search)                                	////  how the search is done 
	{
	
		search = search.replace(/#/gi,'');
		search = search.replace(/ /gi,'{{}}');
		if(search!=""){
			$("#list").html("");
			$.get(base+"site/SearchGuests/"+search+"/"+event_id,function(data,status){   			//// getting all the event title and id and imagename
				$("#list").html(data);
			});
		}
	}
});

$(document).ready(function(){                                 ///// when search is done to invite people
			
	$("#search-invitee").keypress(function(e){	                ////  whenever smthng typed in the search box 
		var search = $("#search-invitee").val()+String.fromCharCode(e.keyCode); ////
		feed(search);									////  search for the string and get the results
	});
	$("#search-invitee").keyup(function(e){		             ////  to find the same as above but only for backspace keypress
		if(e.which==8)
		{
			var search = $("#search-invitee").val();
			if(search.length>1)
				feed(search);
			else{getUserToInvite(event_id,base);}
		}
	});	
	$("#search-invitee").focusin(function(e){		              //// whenever focus to search box goes in the ressult should be shown
			var search = $("#search-invitee").val();
			if(search.length>0)
				feed(search);
			else
				getUserToInvite(event_id,base);
	});
	function feed(search)                                	////  how the search is done 
	{
		search = search.replace(/#/gi,'');
		search = search.replace(/ /gi,'{{}}');
		if(search!=""){
			$.get(base+"site/SearchInvitees/"+search+"/"+event_id,function(data,status){   			//// getting all invitable names for the event
				$("#list").html(data);
			});
		}
	}
});


$(document).ready(function(){                                 ///// when editing of event is done by clicking edit button
	$("#edit-event").click(function(e){		         
		$("#invite-search-box").hide();
		$("#guest-search-box").hide();
		$.get(base+"site/EditEventForm/"+event_id,function(data,status){
			$("#list").html(data);
		});
	});	
});	


