$(document).ready(function(){		                    //// search an event matching the string typed in the input field
	$("#search").keypress(function(e){	                ////  whenever smthng typed in the search box 
		var search = $("#search").val()+String.fromCharCode(e.keyCode); ////
		feed(search);									////  search for the string and get the results
	});
	$("#search").keyup(function(e){		             ////  to find the same as above but only for backspace keypress
		if(e.which==8)
		{
			var search = $("#search").val();
			if(search.length>1)
				feed(search);
			else{$("#src-res").hide();}
		}
	});	
	$("#search").focusin(function(e){		              //// whenever focus to search box goes in the ressult should be shown
			var search = $("#search").val();
			if(search.length>0)
				feed(search);
			else
			$("#src-res").hide();
	});
	
	function feed(search)                                	////  how the search is done using AJAX
	{
		search = search.replace(/#/gi,'');
		search = search.replace(/ /gi,'{{}}');
			$.get(base+"site/SearchEvent/"+search,function(data,status){   			//// getting all the event title and id and imagename
				$("#src-res").html(data);
				$("#src-res").show();
				
			});
		
	}
});
