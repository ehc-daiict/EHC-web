$(document).ready(function(){
	var date = new Date();
	var year = date.getFullYear();
	var month = date.getMonth();
	
	var yearElements = $('#eventPeriod ul li h2 span.year');
	var yearsLength = yearElements.length;
	for(var i =0; i < yearsLength ; i++) {
		if($(yearElements[i]).html() == year){
			$(yearElements[i]).parents().eq(1).toggleClass('clickBullet');
			$(yearElements[i]).parents().eq(1).find('div').toggleClass('simpleShow'); //getting to parent li
			$('.simpleShow').eq(month).toggleClass('clickShow');
			break;
		}
	}
	$('#eventPeriod ul li h2').click(function(e) {
		$('.simpleShow').toggleClass('simpleShow');
        $(this).parent().find('div').toggleClass('simpleShow');
		$('#eventPeriod ul li div.clickShow').toggleClass('clickShow');
				
		if ($(this).find('span.year').html() == year){
			$('.simpleShow').eq(month).toggleClass('clickShow');
		}
		else {
			$('.simpleShow').eq(0).toggleClass('clickShow');	
		}
		$('.clickBullet').toggleClass('clickBullet');
		$(this).parent().toggleClass('clickBullet');
    });
	$('#eventPeriod ul li div').click(function(e) {
		$('#eventPeriod ul li div.clickShow').toggleClass('clickShow');
        $(this).toggleClass('clickShow');
    });	
});