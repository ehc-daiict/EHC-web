$(document).ready(function(){
	$("#bar a").click(function(){ 
		event.preventDefault();
		$("#LoginMenu, #siteLogin").fadeIn('slow');
	});
	
	$("#siteLogin").click(function(e) {
        event.preventDefault();
		$("#LoginMenu, #siteLogin").fadeOut('slow');
	});
});