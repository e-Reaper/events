$(document).ready(function(){         //// for making the form more responsive
  $("#add_more_opt").click(function(){   
	var k=parseInt($("#num_opt").val());
	var option=$("#option_value").val();
	if(option=="") return false;
	$("#num_opt").val(k+1);
	var str="\
	<div class='opts'>\
	<input type='text' name='option"+k+"' id='option"+k+"' readonly hidden>\
	OPTION "+k+" : <span id='optNamespan"+k+"' style='font-weight:bold'>"+option+"</span>\
	</div>";
	$("#opt_table").append(str);
	$("#option"+k).val(option);	
	$("#option_value").val("");
	$("#option_id").val("");
  });
  $("#reset_all_opt").click(function(){              //// reset all the organiser data filled till now
	$("#opt_table").html("");
	$("#num_opt").val(0);
	});
});

