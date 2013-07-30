monthNum = {'January':0, 'February':1, 'March':2, 'April':3, 'May':4, 'June':5, 'July':6, 'August':7, 'September':8, 'October':9, 'November':10, 'December':11};
monthName = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

$(document).ready(function(){

	var date = new Date();
	var year = date.getFullYear();
	var month = date.getMonth();

	makeTimeline(year);
	
	window.onpopstate = function(e) {
		
    	if(e.state == null){ //this is for first page load on chrome, for mozilla this event is not fired for the first page load
			return;
		} else {
			
			loadData(e.state.year, monthNum[ e.state.month ], null);
		}
	}
	
	//this is for first page load
	init(year, month);	

	$('#blogPeriod ul li h2').click(function(e) {
		$('.simpleShow').toggleClass('simpleShow');
        $(this).parent().find('div').toggleClass('simpleShow');
		$('#blogPeriod ul li div.clickShow').toggleClass('clickShow');
				
		if ($(this).find('span.year').html() == year){
			$('.simpleShow').eq(month).toggleClass('clickShow');
		}
		else {
			$('.simpleShow').eq(0).toggleClass('clickShow');	
		}
		
		var yearSpec = $(this).find('span.year').html();
		var monthSpec = $('.clickShow').html();
		addNewState(yearSpec, monthSpec, null);
		loadData(yearSpec, monthNum[ monthSpec ], null);
		
		$('.clickBullet').toggleClass('clickBullet');
		$(this).parent().toggleClass('clickBullet');
    });
	
	
	$('#blogPeriod ul li div').click(function(e) {
		$('#blogPeriod ul li div.clickShow').toggleClass('clickShow');
        $(this).toggleClass('clickShow');
		var yearSpec = $(this).siblings('h2').find('span.year').text();
		var monthSpec = $(this).html();
		addNewState(yearSpec, monthSpec, null);
		loadData(yearSpec, monthNum[ monthSpec ], null);
   });	
   
});

function getHash(name){
	var hash = window.location.hash.slice(1).split("&");
	for (i=0;i<hash.length;i++){
		pairs = hash[i].split('=');
		pairs[0]=pairs[0].replace(/^\s+|\s+$/g,"");
		if (pairs[0]==name)
		{
			pairs[1]=pairs[1].replace(/^\s+|\s+$/g,"");
			return unescape(pairs[1]);
		}
	}	
}

function addNewState(year, month, articleId){
	if(articleId == null){
		history.pushState({'year':year, 'month': month}, document.title, location.pathname+location.search+"#year="+ year +"&month="+ month);
	}else {
		history.pushState({'year':year, 'month': month}, document.title, location.pathname+location.search+"#year="+ year +"&month="+ month + "&articleID=" + articleId);
	}
}

function replaceCurrentState(year, month, articleId){
	if(articleId == null){
		history.replaceState({'year':year, 'month': month}, document.title, location.pathname+location.search+"#year="+ year +"&month="+ month);
	}else {
		history.replaceState({'year':year, 'month': month}, document.title, location.pathname+location.search+"#year="+ year +"&month="+ month + "&articleID=" + articleId);
	}
}


function init(year, month){
	if(getHash('year') == null){
		loadData(year, month, null);
		replaceCurrentState(year, monthName[ month ], null);
	}else if(getHash('month') == null){
		var yearSpec = getHash('year');
		
		loadData(yearSpec, 0, null);
		replaceCurrentState(yearSpec, monthName[ 0 ], null);
	}else {
		var yearSpec = getHash('year');
		var monthSpec = getHash('month');
		var articleId = getHash('articleID');
		loadData(yearSpec, monthNum[ monthSpec ], articleId );
		replaceCurrentState(yearSpec, monthSpec, articleId);
	}			
}

function loadData(year, month, articleId){	

	//Changing categories selection and highlighting
	var yearElements = $('#blogPeriod ul li h2 span.year');
	var yearsLength = yearElements.length;
	for(var i =0; i < yearsLength ; i++) {
		if($(yearElements[i]).html() == year){
			$(yearElements[i]).parents().eq(1).addClass('clickBullet');
			$('.simpleShow').toggleClass('simpleShow');
			$(yearElements[i]).parents().eq(1).find('div').addClass('simpleShow'); //getting to parent li
			$('.clickShow').toggleClass('clickShow');
			$('.simpleShow').eq(month).toggleClass('clickShow');
			break;
		}
	}
	loadBlogs(year, month);	
}


function makeYear(year){
	var li = "<li class='dropdown'> \
				<h2><span class='bullet'></span><span class='year'>" + year + "</span></h2> \
				<div>January</div>\
				<div>February</div>\
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
	$('#blogPeriod ul').append( makeYear( year - 1) );	
	$('#blogPeriod ul').append( makeYear(year) );
	$('#blogPeriod ul').append( makeYear( year + 1) );
}
function makeBlog(id, title, timeStamp, data, author){
	var blog = "<article class='blogPost' id='" + id +"'>\
                      <header>\
                        	<h1>" + title + "</h1>\
                            <hr>\
                      </header>\
                      <section>\
                        	<div class='clear blogPostMeta' >\
                            	<span class='writtenDate'>" + timeStamp + "</span> , \
                                <span class='author'>" + author + "</span>\
                            </div>\
                            <div class='clear blogPostContent'>" + data + "</div>\
                            <div class='clear comment'></div>\
                            <hr/>​\
                      </section>\
                 </article>";
	return blog;
}

function putBlogs(blogs){
	$('#contentWrapper #blogs').empty();
	for(i = 0; i < blogs.length ; i++){
		blog = makeBlog(blogs[i].articleId, blogs[i].title, blogs[i].timeStamp, blogs[i].data, blogs[i].author);
		$('#contentWrapper #blogs').append(blog);
	}
	
	//this must be added here so that scrolling must occur after completion of the loading process
	//alert(getHash('articleID'));
	if(getHash('articleID') != null){
		$('html, body').animate({
        	scrollTop: $('#'+getHash('articleID')).offset().top
    		}, 1000);
	}
}

function loadBlogs(year, month){
	$.post("php/api.php", {method : 'fetchBlogs', year : year , month : month + 1},function(retData){
		//alert(retData.head.status + retData.body.username);
		if(retData.head.status == 200){//accepted
			putBlogs(retData.body);
		}else if(retData.head.status == 404){//not found
			$('#contentWrapper #blogs').empty();
		}else if(retData.head.status == 400){//bad request
			//form not completly filled
		}
	}, "json");		
}