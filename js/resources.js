$(document).ready(function(){

	$('#bookOption .bookOptions a').eq(0).click(function(e){
		$('#bookOption').slideUp(500);
		$('#contentWrapper #bookRoom').slideDown(1500);
	});
	$('#bookOption .bookOptions a').eq(1).click(function(e){
		$('#bookOption').slideUp(500);
		$('#contentWrapper #bookComponent').slideDown(1500);
	});
	$('#bookOption .bookOptions a').eq(2).click(function(e){
		$('#bookOption').slideUp(500);
		$('#contentWrapper #bookBook').slideDown(1500);
	});
	
	$('#bookRoom .button').click(function(e){
		event.preventDefault();
		if(isLoggedIn()){
			//extract data
			data = $(this).parent().serialize();
			data += '&method=bookRoom';
			//send data
			$.post("php/api.php", data,function(retData){
					if(retData.head.status == 200){//accepted
						$('#contentWrapper #bookRoom').slideUp(1000);	
						$('#bookOption').slideDown(1500);

					}else{
						alert("Some error occured");
					}
				}, "json");	
									
		}else{
			$("#LoginMenu, #siteLogin").fadeIn('slow');  
		}
	});

		$('#bookComponent .button').click(function(e){
		event.preventDefault();
		if(isLoggedIn()){
			//extract data
			data = $(this).parent().serialize();
			data += '&method=bookComponent';
			//send data
			$.post("php/api.php", data,function(retData){
					if(retData.head.status == 200){//accepted
						$('#contentWrapper #bookComponent').slideUp(1000);	
						$('#bookOption').slideDown(1500);

					}else{
						alert("Some error occured");
					}
				}, "json");	
									
		}else{
			$("#LoginMenu, #siteLogin").fadeIn('slow');  
		}
	});


	$('#bookBook .button').click(function(e){
		event.preventDefault();
		if(isLoggedIn()){
			//extract data
			data = $(this).parent().serialize();
			data += '&method=bookBook';
			//send data
			$.post("php/api.php", data,function(retData){
					if(retData.head.status == 200){//accepted
						$('#contentWrapper #bookRoom').slideUp(1000);	
						$('#bookOption').slideDown(1500);

					}else{
						alert("Some error occured");
					}
				}, "json");	
									
		}else{
			$("#LoginMenu, #siteLogin").fadeIn('slow');  
		}
	});


});