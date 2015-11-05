$(document).ready(function(){                                 ///// posts for events and comments and polls
	$("#submit_post").click(function(){
		var e=$("#post_by_user").val();
		$.post(base+"site/addPost/"+e+"/"+event_id+"/5",function(data,status){
			$("#post_and_comment").prepend(data);
						
		});
	});
});	

function get_like(e,f)
{
	$.get(base+"site/get_like/"+e+"/"+f,function(data,status){
		$("#liked_"+e+"_"+f).html(data);
	});
}
function like(e,f)
{
	$.post(base+"site/like/"+e+"/"+f,function(data,status){
		get_like(e,f);
	});
}

function get_comment(e,f)
{
	$.get(base+"site/getComment/"+e+"/"+f,function(data,status){
	$("#commentFor"+e).html(data);
	});
}
function comment(e,f)
{
	var g=$("#newComment"+e).val();	
	$.post(base+"site/comment/"+e+"/"+f+"/"+g,function(data,status){
		get_comment(e,f);
		$("#newComment"+e).val("");	
	});
}
