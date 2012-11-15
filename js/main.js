$(document).ready(function(){
	////////////////////////_____LOGIN________////////////////////////////
	
	$("#bar a").click(function(){ 
		event.preventDefault();
		$("#LoginMenu, #siteLogin").fadeIn('slow');
	});
	
	$("#siteLogin").click(function(e) {
        event.preventDefault();
		$("#LoginMenu, #siteLogin").fadeOut('slow');
	});
	
	$('#loginButton').click(function(e) {
		if( $('#LoginMenu').find('form')[0].checkValidity() ){ //writing 0 is of utter importance as find return collection of node instead we need a node
			$.post("php/api.php", {method : 'login', username :$('#LoginMenu').find('form').find('input').eq(0).val() , password : $('#LoginMenu').find('form').find('input').eq(1).val()},function(retData){
				if(retData.head.status == 202){//accepted
					
				}else if(retData.head.status == 401){//unauthorized
					//wrong username or password
				}else if(retData.head.status == 400){//bad request
					//form not completly filled
				}
			}, "json");
		} else {
			alert($('#LoginMenu').find('form')[0].checkValidity());
			//$('#LoginMenu').find('form')[0].submit();
		}
	});
});