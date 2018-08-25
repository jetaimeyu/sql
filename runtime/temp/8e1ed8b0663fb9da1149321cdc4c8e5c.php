<?php /*a:1:{s:64:"D:\phpStudy\WWW\sqlQuery\application\index\view\login\index.html";i:1535015931;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>登录</title>
    <link href="/static/home/css/login.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="login">
    <div class="message">迈迪网-sql查询</div>
    <div id="darkbannerwrap"></div>
    <form method="post">
        <input name="action" value="login" type="hidden">
        <input name="name" placeholder="用户名"  type="text" id="name">
        <hr class="hr15">
        <input name="password" placeholder="密码"  type="password" id="password">
        <hr class="hr15">
        <input value="登录" style="width:100%;" type="button" class="loginbtn">
        <hr class="hr20">
    </form>
</div>
<div class="copyright"></div>
<script  src="/static/common/js/jquery.js"></script>
<script  src="/static/common/layui/layui.all.js"></script>
</body>
</html>
<script>
    $(function(){
        $(".loginbtn").click(function(){
            var name,password,status;
            status = true;
            name = $.trim($("#name").val());
            password = $.trim($("#password").val());
            if(!name){
             layer.msg('用户名不能为空。。', {icon: 5});
             return false;
            }else if(!password){
                layer.msg('密码不能为空', {icon: 5});
                return false;
            }
            var url,data;
            data = {'name':name,'password':password};
            url = "<?php echo url('index/Login/homeLogin'); ?>";
            $.post(url,data,function(res){
                if(res.status==1){
                    layer.msg(res.msg, {icon: 6});
                    setTimeout(jumphref,1000)
                    function jumphref(){
                        window.location.href = "<?php echo url('index/Index/index'); ?>";
                    }
                }else{
                    layer.msg(res.msg, {icon: 5});
                }
            })
        })
    })
</script>

