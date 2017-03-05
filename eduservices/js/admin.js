// nav
$(document).ready(function(){
  $('.t_nav').click(function(){
	var html='dis'+($(this).attr('id'));
		var display='none';
		
		if($(this).next('ul').css('display')=='none'){
			display='block';
		}
		// alert(display)
		setCookie(html,display);
    $(this).next('ul.sub-nav').slideToggle()
  });
})
function showList(type,obj){
	if(type==1){
	// alert($('.column').attr('class'))
		if($('.column')&&$('.linebg')){
			$('.linebg').attr("class",'nolinebg');
			$('.column').attr("class",'nocolumn');
			$('.btnbg1').css('background','#ddd')
			$('.btnbg2').css('background','')
			setCookie('showtype','nocolumn')
		}
	}else{
		if($('.nocolumn')&&$('.nolinebg')){
			$('.nolinebg').attr("class",'linebg');
			$('.nocolumn').attr("class",'column');
			$('.btnbg1').css('background','')
			$('.btnbg2').css('background','#ddd')
			setCookie('showtype','column')
		}
	}
}	


function openUploadMK(editid,imgid,btnid){
	openUweb('upmkimg',editid,imgid,btnid)
}
function openUploadZP(editid,imgid,btnid){
	openUweb('upheadimg',editid,imgid,btnid)
}
function openUploadSF(editid,imgid,btnid){
	openUweb('upsfimg',editid,imgid,btnid)
}
function openUploadZJ(editid,imgid,btnid){
	openUweb('upimg',editid,imgid,btnid)
}
function openUpload(editid){
	openUweb('upfile',editid)
}
function openUweb(Uaction,editid,imgid,btnid){

	if(editid){
		var searchStr='/editid/'+editid;
	}
	if(imgid){
		searchStr+='/imgid/'+imgid;
	}
	if(btnid){
		searchStr+='/btnid/'+btnid;
	}
	//,'','status=no,scrollbars=no,top=400,left=500,width=440,height=200'
     // alert('/site/'+Uaction+searchStr);
	window.open('/site/'+Uaction+searchStr)

}
function selectOne(obj,name){
		if(name){
			 var objCheckBox = document.getElementsByName(name); 
			 for(var i=0;i<objCheckBox.length;i++){ 
				 //判断复选框集合中的i元素是否为obj，若为否则便是未被选中 
				 if (objCheckBox[i]!=obj) { 
					 objCheckBox[i].checked = false; 
				 } else{ 
					 //若是，原先为被勾选的变成勾选，反之则变成未勾选 
					 objCheckBox[i].checked = obj.checked; 
				 } 
			 } 
		 }
    }
function jsSetCookie(name, value, expires, path, domain, secure) {
        document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");    
}    
function setCookie(name,value,isreload)
{
    jsSetCookie(name,value,0,"/")
    if(isreload){
		location.reload()
	}
    /*
	$.ajax({
			type: "POST",
			url: '/site/setcookie',
			data: {'name':name,'value':value},
			async:true,
			success: function(msg){
				if(isreload){
					location.reload()
				}
			}
		});
       */
}
function ajaxPage(Url,Data){
  // alert(Url)
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

function checkiout(value,obj){
	if($(obj).val()==""){
		$(obj).val(value)
	}
}
function checkifocus(value,obj){
	if($(obj).val()==value){
		$(obj).val('')
	}
}
function previewImage(file)

{
// alert($(file).hide())
  var MAXWIDTH  = 100;
  var MAXHEIGHT = 100;
  var div = document.getElementById('preview');
  if (file.files && file.files[0])
  {
      div.innerHTML = '<img id=imghead>';
      var img = document.getElementById('imghead');
      img.onload = function(){
        var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
        img.width = rect.width;
        img.height = rect.height;
        img.style.marginLeft = rect.left+'px';
        img.style.marginTop = rect.top+'px';
      }
      var reader = new FileReader();
      reader.onload = function(evt){img.src = evt.target.result;}
      reader.readAsDataURL(file.files[0]);
  }
  else
  {
    var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
    file.select();
    var src = document.selection.createRange().text;
    div.innerHTML = '<img id=imghead>';
    var img = document.getElementById('imghead');
    img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
    var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
    status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
    div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;margin-left:"+rect.left+"px;"+sFilter+src+"\"'></div>";
  }
}
function clacImgZoomParam( maxWidth, maxHeight, width, height ){
    var param = {top:0, left:0, width:width, height:height};
    if( width>maxWidth || height>maxHeight )
    {
        rateWidth = width / maxWidth;
        rateHeight = height / maxHeight;
        
        if( rateWidth > rateHeight )
        {
            param.width =  maxWidth;
            param.height = Math.round(height / rateWidth);
        }else
        {
            param.width = Math.round(width / rateHeight);
            param.height = maxHeight;
        }
    }
    
    param.left = Math.round((maxWidth - param.width) / 2);
    param.top = Math.round((maxHeight - param.height) / 2);
    return param;
}

function GetCheckbox(contrl,type){
		var str=type?"恢复":"删除";
		var tid=type?"1":"2";
		if(contrl){
			var data=new Array();
			$("input:checkbox[name='selectdel[]']").each(function (){
					if($(this).attr("checked")){
							data.push($(this).val());
					}
			});
			if(data.length > 0){
				var ok=confirm("确认"+str+"ID为：\n"+data+"\n的数据？");
				if(ok){
					var Url="/admin/"+contrl+"/delall";
					ajaxPage(Url,{'selectdel[]':data,"tid":tid});
					
				}
			}else{
					alert("请选择要"+str+"的选项!");
			}
		}
}
function StatusAll(contrl,status){
		var str=status==1?"禁用":"启用";
		if(contrl&&status){
			var data=new Array();
			$("input:checkbox[name='selectdel[]']").each(function (){
					if($(this).attr("checked")){
							data.push($(this).val());
					}
			});
			if(data.length > 0){
				var ok=confirm("确认"+str+"ID为：\n"+data+"\n的数据？");
				if(ok){
					var Url="/admin/"+contrl+"/statusall";
					ajaxPage(Url,{'selectdel[]':data,"status":status});
					
				}
			}else{
					alert("请选择要"+str+"的选项!");
			}
		}
}
function explodeChecked(t){ 
        type=t?t:1;
		var data='';
		$("input:checkbox[name='selectdel[]']").each(function (){
			
				if($(this).attr("checked")){
						data+=data?","+$(this).val():$(this).val();
				}
		});
		if(data){
			var ok=confirm("确认导出ID为：\n"+data+"\n的数据？");
			if(ok){
				$("#albumform form input[name='studentsids']").val(data);
                $("#exolodetype option[value='"+t+"']").attr("selected","true")
                
				$("#albumform form").submit();
				$("#albumform form input[name='studentsids']").val('');
                $("#exolodetype option[value='1']").attr("selected","true")
				
			}
		}else{
				alert("请选择要导出的选项!");
		}
		
}
function deleteOne(contrl,id){
// alert(contrl+id);
	var ok=confirm("确认删除？");
	if(ok&&id&&contrl){
		var data=new Array();
		data.push(id);
        // alert(data);
		var Url="/admin/"+contrl+"/delall";
		ajaxPage(Url,{'selectdel[]':data});
	}
}
function changestatus(contrl,id){
	if(id&&contrl){		
		var Url="/admin/"+contrl+"/changestatus";
		ajaxPage(Url,{'id':id});
	}
}
function StatusOne(contrl,id,status){
    
	if(id&&contrl,status){
		var data=new Array();
		data.push(id);
		var Url="/admin/"+contrl+"/statusall";
		ajaxPage(Url,{'selectdel[]':data,'status':status});
	}
}

function setpagesize(name,value){
    if(value>=100)value=100;
	setCookie(name,value,true);	
}
function setshowlisttype(name,value){
	setCookie(name,value,false);	
}
function SelectAll(name) {
var checkboxs=document.getElementsByName(name);
if($("#selectAll").attr("checked")){
	for (var i=0;i<checkboxs.length;i++) {
	 var e=checkboxs[i];
	 e.checked=true;
	}
}else{
	for (var i=0;i<checkboxs.length;i++) {
	  var e=checkboxs[i];
	  e.checked=false;
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


function stopExamOne(contrl,id){
	var ok=confirm("确认强制交卷？");
	if(ok&&id&&contrl){
		var data=new Array();
		data.push(id);
		var Url="/admin/"+contrl+"/stopall";
		ajaxPage(Url,{'selectdel[]':data});
	}
}
function stopExam(contrl){
		var str="强制交卷";
		if(contrl){
			var data=new Array();
			$("input:checkbox[name='selectdel[]']").each(function (){
					if($(this).attr("checked")){
							data.push($(this).val());
					}
			});
			if(data.length > 0){
				var ok=confirm("确认"+str+"ID为：\n"+data+"\n的数据？");
				if(ok){
					var Url="/admin/"+contrl+"/stopall";
					ajaxPage(Url,{'selectdel[]':data});
					
				}
			}else{
					alert("请选择要"+str+"的选项!");
			}
		}
}
//url整理
function checkSearch(obj,returnurl){
    var searchArr=$(obj).serializeArray();
    var url='';
    for (i in searchArr){ 
        if(searchArr[i]['name']=="u_name"&&searchArr[i]['value']=="负责人..")continue;  
        if(searchArr[i]['name']=="o_name"&&(searchArr[i]['value']=="机构.."||searchArr[i]['value']=="学习中心名称.."||searchArr[i]['value']=="报名点名称.."||searchArr[i]['value']=="机构名称.."))continue;  
        if(searchArr[i]['name']=="stsfz"&&searchArr[i]['value']=="身份证...")continue;   
        if(searchArr[i]['name']=="stpkcc"&&searchArr[i]['value']=="排考场次...")continue;   
        if(searchArr[i]['name']=="stname"&&searchArr[i]['value']=="姓名...")continue;   
        if(searchArr[i]['name']=="s_id"&&searchArr[i]['value']=="ID..")continue;
        if(searchArr[i]['name']=="sa_id"&&searchArr[i]['value']=="ID..")continue;
        if(searchArr[i]['name']=="s_insertid"&&searchArr[i]['value']=="录入编号..")continue;   
        if(searchArr[i]['name']=="s_name"&&searchArr[i]['value']=="姓名..")continue;
        if(searchArr[i]['name']=="s_credentialsnumber"&&searchArr[i]['value']=="证件..")continue;
        if(searchArr[i]['name']=="s_birthaddress"&&searchArr[i]['value']=="出生地..")continue;
        if(searchArr[i]['name']=="type"&&searchArr[i]['value']=="1")continue;
        if(searchArr[i]['name']=="i_id"&&searchArr[i]['value']=="ID..")continue;
        if(searchArr[i]['name']=="i_label"&&searchArr[i]['value']=="标签..")continue;
        if(searchArr[i]['name']=="i_title"&&searchArr[i]['value']=="标题..")continue;

        if(searchArr[i]['name']=="mk_cardnumber"&&searchArr[i]['value']=="证件号码..")continue;
        if(searchArr[i]['name']=="mk_xh"&&searchArr[i]['value']=="学号..")continue;
        if(searchArr[i]['name']=="mk_sname"&&searchArr[i]['value']=="姓名..")continue;
        if(searchArr[i]['name']=="mk_moblie"&&searchArr[i]['value']=="手机..")continue;
        
        if(searchArr[i]['name']&&searchArr[i]['value']){
           url+=url?"&"+searchArr[i]['name']+"="+searchArr[i]['value']:"?"+searchArr[i]['name']+"="+searchArr[i]['value'];
        }
    }
    location.href=returnurl+url;
 return false;
}


function scrollDiv(obj){
    if(document.getElementById('w-auto2').scrollLeft==obj.scrollLeft){
        document.getElementById('w-auto1').scrollLeft=obj.scrollLeft;
    }
    if(document.getElementById('w-auto1').scrollLeft==obj.scrollLeft){
        document.getElementById('w-auto2').scrollLeft=obj.scrollLeft;
    }
}
$(document).ready(function(){
    $("#btnshowlist").click(
    function(){
        if($(this).val()=="精简模式"){
            setshowlisttype("showlisttype","notall")
            $(this).val("显示所有")
            $(".userwidth").css("min-width","890px");
            $(".userwidth").css("width","890px");
            $(".showlist").hide();
            $("#showjjtype").show();
        }else{
             setshowlisttype("showlisttype","all")
            $(this).val("精简模式")
            $(".userwidth").css("min-width","1420px");
            $(".userwidth").css("width","1420px");
            $(".showlist").show();
            $("#showjjtype").hide();
        }
	});
    $("#showjjtype").click(
    function(){
        if($("#btnshowlist").val()=="显示所有"){
            if($(this).val()=="模式2"){
                setshowlisttype("showjjtype","type1")
                $(this).val("模式1")
                $(".showtype1").show();
                $(".showtype2").hide();
            }else{
                 setshowlisttype("showjjtype","type2")
                $(this).val("模式2")
                $(".showtype1").hide();
                $(".showtype2").show();
            }
        }else{
            $(".showtype1").show();
            $(".showtype2").show();
        }
	});
    /*
    if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE7.0")
    {
    alert("7")
        $('.userwidth tbody tr').mouseover(function() {
            $(this)["addClass"]('selected-tr')
        }).mouseout(function() {
            $(this)["removeClass"]('selected-tr')
        });
    }*/
	
    
});