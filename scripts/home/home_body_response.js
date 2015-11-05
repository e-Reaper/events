$(document).ready(function(){
  $("#show-event-form").click(function(){  //// shows the event form when clicked on the add event button
    $("#create-event-form").slideToggle(500);
	$("#message-report").hide();
  });
});