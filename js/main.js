$(document).ready(function(){
	$("#bar a").click(function(){ 
event.preventDefault();
		$("#menu").slideToggle("slow");
	});
});