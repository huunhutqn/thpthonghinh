//tự động nhảy đến div container, khi load một page, trừ homepage
//code đặt tại header vì web xài chung một header

window.location.hash = '#single-container';

window.onload = function () { 
	window.history.pushState("", document.title, window.location.pathname);
	window.scrollBy(0, -100);
 }
