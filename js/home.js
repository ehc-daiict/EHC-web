$(document).ready(function(){
	var date = new Date();
	var year = date.getFullYear();
	var month = date.getMonth();;

	fetchRecentBlogs(year, month);

});

function makeBlog(title, date, author, post){
	var blog = "<article class='blogPost'>\
                      <header>\
                        	<h1>" + title + "</h1>\
                            <hr>\
                      </header>\
                      <section>\
                        	<div class='clear blogPostMeta' >\
                            	<span class='writtenDate'>" + date + "</span> , \
                                <span class='author'>" + author + "</span>\
                            </div>\
                            <div class='clear blogPostContent'>" + post + "</div>\
                            <div class='clear comment'></div>\
                            <hr/>​\
                      </section>\
                 </article>";
	return blog;
}
function putRecentBlogs(blogs){
	$('#contentWrapper #recentBlog').empty();
	for(i = 0; i < blogs.length ; i++){
		blogArticle = makeBlog(blogs[i].title, blogs[i].date, blogs[i].author, blogs[i].post);
		$('#contentWrapper #recentBlog').append(blogArticle);
	}
}

function fetchRecentBlogs(year, month){
	
//	monthNum = {'January':0, 'February':1, 'March':2, 'April':3, 'May':4, 'June':5, 'July':6, 'August':7, 'September':8, 'October':9, 'November':10, 'December':11};
	
	$.post("php/api.php", {method : 'fetchRecentBlogs', year : year , month : month},function(retData){
		//alert(retData.head.status + retData.body.username);
		if(retData.head.status == 200){//accepted
			putRecentBlogs(retData.body);
		}else if(retData.head.status == 404){//not found
			$('#contentWrapper #recentBlog').empty();
		}else if(retData.head.status == 400){//bad request
			//form not completly filled
		}
	}, "json");		
}