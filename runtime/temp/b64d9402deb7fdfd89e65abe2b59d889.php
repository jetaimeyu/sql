<?php /*a:1:{s:64:"D:\phpStudy\WWW\sqlQuery\application\admin\view\login\index.html";i:1535095196;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>后台管理</title>
    <link href="/static/admin/css/login.css" rel="stylesheet" type="text/css" />
    <?php if($isMobile): ?>
    <link href="/static/admin/css/mobilelogin.css" rel="stylesheet" type="text/css" />
    <?php endif; ?>
</head>
<body>
<div class="login_box">
    <div class="login_l_img"><img src="/static/admin/images/login-img.png" /></div>
    <div class="login">
        <div class="login_logo"><a href="#"><img src="/static/admin/images/login_logo.png" /></a></div>
        <div class="login_name">
            <p>后台管理系统</p>
        </div>
        <form method="post">
            <input name="username" type="text"  id="name" value="" placeholder="用户名"/>
            <input name="password" id ="password" type="password" placeholder="密码"/>
            <input value="登录" style="width:100%;" type="button" class="loginbtn">
        </form>
    </div>
</div>
<script  src="/static/common/js/jquery.js"></script>
<script  src="/static/common/layui/layui.all.js"></script>
</body>
</html>
<script>
    $(function(){
        $(".loginbtn").click(function(){
            var name,password;
            name = $.trim($("#name").val());
            password = $.trim($("#password").val());
            if(!name){
                layer.msg('用户名不能为空', {icon: 5});
                return false;
            }else if(!password){
                layer.msg('密码不能为空', {icon: 5});
                return false;
            }
            var url,data;
            data = {'name':name,'password':password};
            url = "<?php echo url('admin/Login/adminLogin'); ?>";
            $.post(url,data,function(res){
                if(res.status==1){
                    layer.msg(res.msg, {icon: 6});
                    setTimeout(jumphref,1000);
                    function jumphref(){
                        window.location.href = "<?php echo url('admin/Index/index'); ?>";
                    }
                }else{
                    layer.msg(res.msg, {icon: 5});
                }
            })
        })
    })
</script>
