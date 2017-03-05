/*动态获取宽高*/
window.onresize = function(){
	width_height();
}
window.onload = function(){
	width_height();
}
function width_height(){
	var clientWidth = document.documentElement.clientWidth;
	var dt_width = clientWidth+'px';
	var dt_width_main = clientWidth-244+'px';
	document.getElementById('top').style.width = dt_width;
	//document.getElementById('main').style.width = dt_width_main;
	
	var clientHeight = document.documentElement.clientHeight;
	var dt_height = clientHeight-40+'px';
	var dt_height01 = clientHeight-100+'px';
	document.getElementById('spliter01').style.height = dt_height;
	document.getElementById('spliter02').style.height = dt_height;
	document.getElementById('menu_height').style.height = dt_height;
	document.getElementById('main-right').style.height = dt_height01;
}
/*jqurey*/
/*点击展开隐藏菜单*/
$(document).ready(function(){
						   
  $("#spliter01").click(function(){
  $("#spliter02").show();
  $("#spliter01").hide();
  $("#menu").hide(500);
  });
  $("#spliter02").click(function(){
  $("#spliter01").show();
  $("#spliter02").hide();
  $("#menu").show(500);
  });
});
/*产品树展开和关闭*/
$(function(){
	$(".ico_show").click(function(){
		var $ul = $(".menu_list_show").siblings(".menu_list_show > ul > li");
		if($ul.is(":visible")){
			$(this).parent().attr("class",".menu_list_hide");
			$ul.hide();
			}else{
				$(this).parent().attr("class",".menu_list_show");
				$ul.show();
			}
		return false;
	})
})