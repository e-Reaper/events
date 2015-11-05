$(document).ready(function(){                               
  $("#bulb").click(function(){                   /////     dummy
    $("#notification-box").toggle();
	$("#message-box").hide();
    $("#account-box").hide();
  });
  
  $("#message").click(function(){                 ////      dummy
    $("#message-box").toggle();
	$("#notification-box").hide();
	$("#account-box").hide();
    
  });
  
  $("#account").click(function(){                 ////    dummy
    $("#notification-box").hide();
	$("#message-box").hide();
    $("#account-box").toggle();
  });
});