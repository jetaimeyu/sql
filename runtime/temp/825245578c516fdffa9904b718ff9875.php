<?php /*a:1:{s:64:"D:\phpStudy\WWW\sqlQuery\application\index\view\index\index.html";i:1535101146;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>迈迪网-sql查询</title>
    <link href="/static/common/layui/css/layui.css" rel="stylesheet" type="text/css" >
</head>

<body>
<ul class="layui-nav" >
    <li class="layui-nav-item">
        <a href="javascript:;">Sql查询</a>
    </li>
    <li class="layui-nav-item" style="float: right">
        <a href="javascript:;"><img src="//t.cn/RCzsdCq" class="layui-nav-img"><?php echo htmlentities($uname); ?></a>
        <dl class="layui-nav-child">
            <dd><a href="<?php echo url('index/Index/userSignout'); ?>">退了</a></dd>
        </dl>
    </li>
</ul>
<iframe src="<?php echo url('index/Index/querysql'); ?>" frameborder="0"  style="width: 100%; height: 100%;" name="moduleiframe" id="moduleiframe"></iframe>
<script  src="/static/common/js/jquery.js"></script>
<script  src="/static/common/layui/layui.all.js"></script>
</body>
</html>
<script>
    $("#moduleiframe").height($(document).height()*1-64+'px');
    $(function(){
        layui.use('element', function(){
            var element = layui.element;
        });
    })

</script>