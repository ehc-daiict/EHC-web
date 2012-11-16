$(document).ready(function(){

	var date = new Date();
	var year = date.getFullYear();
	var month = date.getMonth();

	makeTimeline(year);
	selectCurrentMonth(year, month);

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
		
		fetchEvents($('#eventPeriod ul li div.clickShow').siblings('h2').find('span.year').text(), $('#eventPeriod ul li div.clickShow').text());
		
		$('.clickBullet').toggleClass('clickBullet');
		$(this).parent().toggleClass('clickBullet');
    });
	$('#eventPeriod ul li div').click(function(e) {
		$('#eventPeriod ul li div.clickShow').toggleClass('clickShow');
        $(this).toggleClass('clickShow');
		fetchEvents($('#eventPeriod ul li div.clickShow').siblings('h2').find('span.year').text(), $('#eventPeriod ul li div.clickShow').text());
   });	
   
   //Registration Link
   $('#events').on('click','.event section div.field a',function(e){
	  event.preventDefault();
	  if(isLoggedIn()){
		  window.location.href = $(this).attr('href');
	  }else{
		$("#LoginMenu, #siteLogin").fadeIn('slow');  
	  }
   });
});

function selectCurrentMonth(year, month){	
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
	fetchEvents($('#eventPeriod ul li div.clickShow').siblings('h2').find('span.year').text(), $('#eventPeriod ul li div.clickShow').text());	
}

function generateYear(year){
	var li = "<li class='dropdown'> \
				<h2><span class='bullet'></span><span class='year'>" + year + "</span></h2> \
				<div>January</div>\
				<div>Februaury</div>\
				<div>March</div>\
				<div>April</div>\
				<div>May</div>\
				<div>June</div>\
				<div>July</div>\
				<div>August</div>\
				<div>September</div>\
				<div>October</div>\
				<div>November</div>\
				<div>December</div>\
			</li>"
	return li;
}
function makeTimeline(year){
	
	$('#eventPeriod ul').append( generateYear(year) );
	$('#eventPeriod ul').append( generateYear( year + 1) );
}
function makeEvent(title, time, duration, venue, host, audience, registration, regLink, prerequisite, tools, desc){
	var eventArticle = "<article class='event'>\
                    	<header>\
                        	<h1>" + title + "</h1>\
                            <hr>\
                        </header>\
                        <section>\
                        	<div class='clear'>\
                            	<div class='label'>Time</div><div class='colon'>:</div><div class='field'>" + time + "</div>\
                            </div>\
                            <div class='clear'>\
                            	<div class='label'>Duration</div><div class='colon'>:</div><div class='field'>" + duration + "</div>\
                            </div>\
                            <div class='clear'>\
                            	<div class='label'>Venue</div><div class='colon'>:</div><div class='field'>" + venue + "</div>\
                            </div>\
                            <div class='clear'>\
                            	<div class='label'>Host</div><div class='colon'>:</div><div class='field'>" + host + "</div>\
                            </div>\
                            <div class='clear'>\
                            	<div class='label'>Target Audience</div><div class='colon'>:</div><div class='field'>" + audience + "</div>\
                            </div>\
                            <div class='clear'>\
                            	<div class='label'>Registration</div><div class='colon'>:</div><div class='field'>" + registration + " <a href=\"" + regLink + "\"> (Click to register)</a></div>\
                            </div>\
	                        <div class='clear'>\
                            	<div class='label'>Prerequisite</div><div class='colon'>:</div><div class='field'>" + prerequisite + "</div>\
                            </div>\
                            <div class='clear'>\
                            	<div class='label'>Tools Needed</div><div class='colon'>:</div><div class='field'>" + tools + "</div>\
                            </div>\
                            <div class='clear'>\
                            	<div class='label'>Description</div><div class='colon'>:</div><div class='description'>" + desc + "</div>\
                            </div>\
                            <hr/>​\
                        </section>\
                    </article>	";
	return eventArticle;
}

function putEvents(events){
	$('#contentWrapper #events').empty();
	for(i = 0; i < events.length ; i++){
		eventArticle = makeEvent(events[i].title, events[i].time, events[i].duration, events[i].venue, events[i].host, events[i].audience, events[i].registration, events[i].regLink, events[i].prerequisite, events[i].tools, events[i].desc );
		$('#contentWrapper #events').append(eventArticle);
	}
}

function fetchEvents(year, month){
	
	monthNum = {'January':0, 'February':1, 'March':2, 'April':3, 'May':4, 'June':5, 'July':6, 'August':7, 'September':8, 'October':9, 'November':10, 'December':11};
	
	$.post("php/api.php", {method : 'fetchEvents', year : year , month : monthNum[month]},function(retData){
		//alert(retData.head.status + retData.body.username);
		if(retData.head.status == 200){//accepted
			putEvents(retData.body);
		}else if(retData.head.status == 404){//not found
			$('#contentWrapper #events').empty();
		}else if(retData.head.status == 400){//bad request
			//form not completly filled
		}
	}, "json");		
}