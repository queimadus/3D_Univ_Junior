var pop = false;

$(document).ready(function(){
	var menus = $("header a:not(.external)");
	menus.click(click_handler);
});

function click_handler(){
	var href = $(this).attr('href');
	change_page(href);

	return event.preventDefault();
}

function change_page(href){
	$.get(href, function(data) {
		history.pushState(null, href, href);
		console.log(event);
		var title = href.split("/")[1];
		title+=title==""?"":" - ";
		document.title = capitalize(title) + "Modelação 3D de objectos :: UJr 2013"; 
		$('.content').replaceWith(data);
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