<?php /*a:1:{s:64:"D:\phpStudy\WWW\sqlQuery\application\admin\view\index\index.html";i:1535100079;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>sql查询后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/common/layui/css/layui.css"  media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
<ul class="layui-nav">
<li class="layui-nav-item">
<a href="javascript:;">功能模块</a>
    <dl class="layui-nav-child">
        <dd><a href="<?php echo url('admin/User/index'); ?>" target="moduleiframe">账户管理</a></dd>
        <dd><a href="<?php echo url('admin/Operationlog/index'); ?>"target="moduleiframe">日志管理</a></dd>
    </dl>
</li>
    <li class="layui-nav-item" style="float: right">
        <a href="javascript:;"><img src="//t.cn/RCzsdCq" class="layui-nav-img"><?php echo htmlentities($adminName); ?></a>
        <dl class="layui-nav-child">
            <dd><a href="<?php echo url('admin/Index/editAdmin'); ?>" target="moduleiframe">修改信息</a></dd>
            <dd><a href="<?php echo url('admin/Index/adminSignout'); ?>">退了</a></dd>
        </dl>
    </li>
</ul>
<iframe src="<?php echo url('admin/User/index'); ?>" frameborder="0"  style="width: 100%; height: 100%;" name="moduleiframe" id="moduleiframe"></iframe>
<script  src="/static/common/js/jquery.js"></script>
<script  src="/static/common/layui/layui.js"></script>
<script>
    $(function(){
        layui.use('element', function(){
            var element = layui.element;
        });
        $("#moduleiframe").height($(document).height()*1-64+'px');
    })
</script>

</body>
</html>