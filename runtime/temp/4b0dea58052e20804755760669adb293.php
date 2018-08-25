<?php /*a:1:{s:70:"D:\phpStudy\WWW\sqlQuery\application\index\view\index\error_index.html";i:1535101579;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>迈迪网-sql查询</title>
    <link href="/static/common/layui/css/layui.css" rel="stylesheet" type="text/css" >
</head>
<body>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend>错误提示：</legend>
</fieldset>
<div style="padding: 20px; background-color: #F2F2F2;">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">sql语句：</div>
                <div class="layui-card-body">
                    <?php echo htmlentities($errorSql); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">错误原因：</div>
                <div class="layui-card-body">
                    <?php echo htmlentities($errorMsg); ?>
                </div>
            </div>
        </div>
    </div>
    <a href="JavaScript:history.back(-1)"><button class="layui-btn" type="button"">返回</button></a>
</div>

<script  src="/static/common/js/jquery.js"></script>
<script  src="/static/common/layui/layui.all.js"></script>
</body>
</html>