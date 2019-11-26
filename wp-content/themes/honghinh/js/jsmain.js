//tự động nhảy đến div container, khi load một page, trừ homepage
//code đặt tại header vì web xài chung một header
	// var chcao = 20; 
	window.location.hash = '#single-container-taileu';

    



window.onload = function () { 
	window.history.pushState("", document.title, window.location.pathname);
	window.scrollBy(0, -100);
 }