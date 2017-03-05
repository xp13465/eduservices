function ajax_login() {
    $("#login_logintype").focus();
    var username=$("#login_username").val();
    var password=$("#login_password").val();
    var logintype=$("#login_logintype").val();
    $.ajax({
        type: 'POST',
        url: '/admin/manageuser/login',
        data: {'username':username,'password':password,'ajax':'login-form','logintype':logintype},
        async :true,
        success: function(msg){
            if(msg=='success'){
                jw.pop.alert("登录成功！!<script>setTimeout('window.location.href=\"/admin\";window.reload()',1500)</script>")
            }else if(msg=='error'){
                jw.pop.alert("用户名或密码错误!<script>//setTimeout('window.location.reload();',1500)</script>")
            }
        }
    });
    
    return false;
}
function ajax_logout(){
    $.post("/site/logout.html", function(data) {
        // alert("退出成功！");
        jw.pop.alert("退出成功!<script>setTimeout('location.reload()',3000)</script>")
    });
}