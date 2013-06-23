var pop = false;
var weeks;
var days;
var day_tabs;

$(document).ready(function(){
	var menus = $("header a:not(.external)");
	menus.click(click_handler);
	binds();
});

function binds(){
	weeks = $("#weeks .week-item");
	days=   $("#days .week-item");
	day_tabs = $("#days");
	weeks.click(weeks_click);
	days.click(days_click);
}

function click_handler(){
	var href = $(this).attr('href');
	history.pushState(null, href, href);
	change_page(href);
	return event.preventDefault();
}

function weeks_click(){

	if($(this).hasClass("active")){
		day_tabs.hide();
		$(this).removeClass("active");
		days.removeClass("active");
		filter_projects(null,null);
		history.pushState(null, "/trabalhos", "/trabalhos");
	}
	else
	{
		weeks.removeClass("active");
		days.removeClass("active");
		$(this).addClass("active");
		filter_projects($(this).data("week"),null);
		populate_days($(this));

		history.pushState(null, $(this).attr("href"), $(this).attr("href"));
	}
	
	return event.preventDefault();
}

function days_click(){
	if($(this).hasClass("active")){
		$(this).removeClass("active");
		var week_nr = $(this).data("week");
		filter_projects(week_nr,null);
		history.pushState(null, "", "/trabalhos/semana"+week_nr);
	}
	else
	{
		days.removeClass("active");
		$(this).addClass("active");
		filter_projects($(this).data("week"),$(this).data("day"));
		history.pushState(null, $(this).attr("href"), $(this).attr("href"));
	}
	//history.pushState(null, href, href);

	
	return event.preventDefault();
}

function populate_days(week){
	var day_dom,day,week_nr;

	day = week.data("start");
	week_nr = week.data("week");

	for(var i=0; i<5; ++i){
		$(days[i]).attr("href","/trabalhos/semana"+week_nr+"/dia"+day);
		$(days[i]).attr("data-week",week_nr);
		$(days[i]).attr("data-day",day);
		$(days[i]).children(".week-subname").text((day++));
	}

	day_tabs.show();
}

function filter_projects(week,day){

	var week_q, day_q,q;
	$(".project").removeClass("filtered");

	if(week!==null){
		week_q = '.project[data-week!='+week+']';
		$(week_q).addClass("filtered");
	}
	if(day!==null){
		day_q = '.project[data-day!='+day+']';
		$(day_q).addClass("filtered");
	}
	//if(week==null&&day==null)
	//	$(".projects").show();
}

function change_page(href){
	$.get(href, function(data) {
		console.log(event);
		var title = href.split("/")[1];
		title+=title==""?"":" - ";
		document.title = capitalize(title) + "Modelação 3D de objectos :: UJr 2013"; 
		$('.content').replaceWith(data);
		binds();
	});
}

function capitalize(s){
	return s.charAt(0).toUpperCase() + s.slice(1);
}

window.onpopstate = function(event) {
	if (pop) {
		change_page(document.location.pathname);
	} else {
		pop = true;
	}
};
