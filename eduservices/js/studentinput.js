function checkqh(type){
    unbindunbeforunload()
    location.href="/admin/students/add.html?type="+type;
}
function bindunbeforunload(){
    window.onbeforeunload=perforresult;
}
function unbindunbeforunload(){
    window.onbeforeunload=null;
}
function perforresult(){
	return"当前操作未保存，如果你此时离开，所做操作信息将全部丢失，是否离开?";
}
function openSearchschool(){
    window.open('/site/searchschool')
}	
function checkSFCARD(){
	if(!$('#s_credentialstype').val()){
		alert('请先选择证件类型');$('#s_credentialstype').focus()
	}
}
function selectCode(obj){
	jQuery("#s_oldschoolcode").val('')
	$.ajax({
		'type':'GET',
		'url':'/admin/admin/getscode.html',
		'data':{'name':$(obj).val()},
		'cache':false,
		'success':function(msg){
		jQuery("#s_oldschoolcode").val(msg)
		
		}
	});return false;
}
function checksfcode(obj){
	var sfztype=$('#s_credentialstype').val();
	if(sfztype=='1'){
		$.ajax({
			'type':'GET',
			'url':'/admin/admin/getsfcode.html',
			'data':{'num':$(obj).val()},
			'cache':false,
			'success':function(msg){
			
				if(msg){
					var data=eval("("+msg+")");
					if(data.sex=='1'){
						$('#s_sex_0').attr('checked','checked')
					}
					if(data.sex=='0'){
						$('#s_sex_1').attr('checked','checked')
					}
					$('#s_birthdate').val(data.birthday[0])
					$('#s_birthaddress').val(data.location[0])	
				}else{
					alert("此身份证可能存在问题;请检查")
				}
			}
		});return false;
	}
	return false;

}
$(document).ready(function() {
    jQuery('body').on('change','#s_highesteducation',function(){
        var arr=["s_oldschool",'s_oldschoolcode',"s_oldzhuanye",'s_oldtime','s_oldimgnumber'];
        if($(this).val()=="2"||$(this).val()=='3'||$(this).val()=='4'||$(this).val()=='5'){
            for(k in arr){
                if($("#"+arr[k]).val()=="NULL"){
                $("#"+arr[k]).val('')
                }
            }
            $(".oldshoworhide").show()
        }else{
            for(k in arr){
            $("#"+arr[k]).val('NULL')	
            }
            $(".oldshoworhide").hide();	
            
        }
        jQuery.ajax({'type':'GET','url':'/admin/admin/getbk.html','data':{'mid':0,'typeid':2},'cache':false,'success':function(html){jQuery("#s_baokaozhuanye").html(html)}});return false;
    });

    jQuery('body').on('change','#s_baokaocengci',function(){
        if($(this).val()=="2"){
            $("#s_zsbzm").val('')
            $(".oldshoworhide1").show()
        }else{
            $("#s_zsbzm").val('NULL')
            $(".oldshoworhide1").hide();	
            
        }

    });
	jQuery.validator.addMethod("cnCharset", function(value, element) {   
	return this.optional(element) || /^[\u0391-\uFFE5]+$/.test(value);   
	});
	jQuery.validator.addMethod("cndate", function(value, element) {   
    var ereg = /^(\d{1,4})(\d{1,2})(\d{1,2})$/;	var r = value.match(ereg);	if (r == null) {		return false;	}	var d = new Date(r[1], r[2] - 1, r[3]);	var result = (d.getFullYear() == r[1] && (d.getMonth() + 1) == r[2] && d.getDate() == r[3]);	return this.optional(element) || (result);
	});
	jQuery.validator.addMethod("cndatenoday", function(value, element) {   
	return this.optional(element) || /^[1-2][0-9][0-9][0-9]-[0-1][0-9]$/.test(value);   
	});
    jQuery.validator.addMethod("chkoldcode", function(value, element) {   
        if(jQuery("#s_highesteducation").val()!==1){
            if(jQuery("#s_oldschoolcode").val()){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    });
	// 手机号码验证
	jQuery.validator.addMethod("mobile", function(value, element) {
		var length = value.length;
		var mobile =  /^(((18[0-9]{1})|(13[0-9]{1})|(15[0-9]{1}))+\d{8})$/
		return this.optional(element) || (length == 11 && mobile.test(value));
	}, "手机号码格式错误");   
	$(".controls").find("input").change(function(){
		if($(this).parent('div.controls').find("p.pl8").css("display")=="block"){
			$(this).parent('div.controls').find("p.pl8").hide()
		}
	})
    
	$("a.btn-success").mouseover(function(){
		$(this).next("img").show();
		
	}).mouseout(function(){
		$(this).next("img").hide();
		
	})
 });