/*动态获取宽高*/
window.onresize = function(){
	width_height();
}
window.onload = function(){
	width_height();
}
function width_height(){
	var clientWidth = document.documentElement.clientWidth+"px";
	document.getElementById('login').style.width = clientWidth;
	document.getElementById('login_tab').style.width = clientWidth;
	var clientHeight = document.documentElement.clientHeight+"px";
	document.getElementById('login').style.height = clientHeight;
	document.getElementById('login_tab').style.height = clientHeight;
}