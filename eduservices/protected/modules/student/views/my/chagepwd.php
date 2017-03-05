<?php
$this->breadcrumbs=array("修改密码");
?>
<form method="post" action="#" onsubmit="return submitForm()">
    <table>
        <tr>
            <td align="right">旧密码：</td>
            <td><input type="password" name="oldpwd" /></td>
            <td><span class="errormsg"></span></td>
        </tr>
        <tr>
            <td align="right">新密码：</td>
            <td><input type="password" name="newpwd1" /></td>
            <td><span class="errormsg"></span></td>
        </tr>
        <tr>
            <td align="right">重复新密码：</td>
            <td><input type="password" name="newpwd2" /></td>
            <td><span class="errormsg"></span></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="right"><input type="submit" value="修改" /></td>
        </tr>
    </table>
</form>
<script type="text/javascript">
function submitForm(){
    var oldpwd = $("form input[name='oldpwd']").val()
    if(oldpwd==""){
        $("form .errormsg").eq(0).html("请输入旧密码！");
        return false;
    }else{
        $("form .errormsg").eq(0).html("");
    }
    var newpwd1 = $("form input[name='newpwd1']").val()
    if(newpwd1==""){
        $("form .errormsg").eq(1).html("请输入新密码！");
        return false;
    }else{
        $("form .errormsg").eq(1).html("");
    }
    if(newpwd1.length<6||newpwd1.length>16){
        $("form .errormsg").eq(1).html("密码长度6-16个字符！");
        return false;
    }else{
        $("form .errormsg").eq(1).html("");
    }
    var newpwd2 = $("form input[name='newpwd2']").val()
    if(newpwd1!=newpwd2){
        $("form .errormsg").eq(2).html("两次密码输入不一致！");
        return false;
    }else{
        $("form .errormsg").eq(2).html("");
    }
    $.post("/admin/manageuser/chagepwd", $("form").serialize(), function(msg){
        $.each($("form input[type='password']"),function(){
            $(this).val("");
        })
        if(msg=="success"){
            jw.pop.alert("修改密码成功！",{autoClose:1000});
        }else{
            jw.pop.alert(msg,{autoClose:1000,icon:2});
        }
        $("form input[name='oldpwd']").focus();
    }, "text")
    
    return false;
}
</script>