function setCookie(name,value)
{
	$.ajax({
			type: "POST",
			url: '/site/setcookie',
			data: {'name':name,'value':value},
			async:true,
			success: function(msg){
			}
		});
}
function ajaxPage(Url,Data){
	$.ajax({
			type: "POST",
			url: Url,
			data: Data,
			async:true,
			success: function(msg){
				if (msg=='ok') {
                    alert('操作成功！');
                }else{
					alert('操作失败！');
				}
				window.location.reload();
			}
		});
}
function GetCheckbox(contrl){
		if(contrl){
			var data=new Array();
			$("input:checkbox[name='selectdel[]']").each(function (){
					if($(this).attr("checked")){
							data.push($(this).val());
					}
			});
			if(data.length > 0){
				var ok=confirm("确认删除ID为：\n"+data+"\n的数据？");
				if(ok){
				var Url="/admin/"+contrl+"/delall";
					ajaxPage(Url,{'selectdel[]':data});
					
				}
			}else{
					alert("请选择要删除的选项!");
			}
		}
    }
$(document).ready(function(){

	$('div.l_menu').find('span.title').click(function(){
	
		var html='dis'+($(this).attr('id'));
		var display='none';
		
		if($(this).next('ul').css('display')=='none'){
			display='block';
		}
		setCookie(html,display);
		$(this).next('ul').slideToggle()
	});
});