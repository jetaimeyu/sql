<?php /*a:1:{s:63:"D:\phpStudy\WWW\sqlQuery\application\admin\view\user\index.html";i:1534925581;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/common/layui/css/layui.css"  media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<style>
    .layui-table td, .layui-table th{
      padding: 9px 8px;
    }
</style>
<body>
<div class="layui-layout layui-layout-admin" style="padding:0 1%">
<div style="float: right;margin:15px 0">
    <a href="<?php echo url('admin/User/edituser'); ?>" style="color: white">
        <button class="layui-btn" type="button" >
        <i class="layui-icon">&#xe608;</i> 添加用户
        </button>
    </a>
</div>
<table class="layui-table">
    <thead>
    <tr>
        <th>#</th>
        <th>用户名</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($usrLists) || $usrLists instanceof \think\Collection || $usrLists instanceof \think\Paginator): $i = 0; $__LIST__ = $usrLists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <tr>
        <td><?php echo htmlentities($i); ?></td>
        <td style="max-width:90px;word-break:break-all;"><?php echo htmlentities($vo['name']); ?></td>
        <td><?php echo htmlentities($vo['CNstate']); ?></td>
        <td>
            <div class="layui-btn-group">
                <a href="<?php echo url('admin/User/edituser',['uid'=>$vo['id']]); ?>">
                    <button class="layui-btn layui-btn-primary layui-btn-sm"><i class="layui-icon"></i></button>
                </a>
                <?php if($vo['state']==2): ?>
                <button class="layui-btn layui-btn-primary layui-btn-sm changeState"state="1" uid="<?php echo htmlentities($vo['id']); ?>">启用</button>
                <?php else: ?>
                <button class="layui-btn layui-btn-primary layui-btn-sm changeState" state="2" uid="<?php echo htmlentities($vo['id']); ?>">禁用</button>
                <?php endif; ?>
               <button class="layui-btn layui-btn-primary layui-btn-sm delUser" uid="<?php echo htmlentities($vo['id']); ?>"><i class="layui-icon"></i></button>
            </div>
        </td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>
</div>
<script  src="/static/common/js/jquery.js"></script>
<script  src="/static/common/layui/layui.js"></script>
</body>
</html>
<script>
    $(function(){
        //启用与禁用
        $(".changeState").click(function(){
            var uid,state,url,data;
                uid = $(this).attr('uid');
                state = $(this).attr("state");
                data = {'uid':uid,'state':state};
                url = "<?php echo url('admin/User/changeUserState'); ?>";
            $.post(url,data,function(res){
                if(res.status==1){
                    layui.use('layer', function(){
                        layer.alert(res.msg, {icon: 6},function(){
                            location.reload();
                        });
                    });
                }else{
                    layui.use('layer', function(){
                        layer.msg(res.msg, {icon: 5});
                    });
                }
            })
        })
        //删除
        $(".delUser").click(function(){
            var This = $(this);
            layui.use('layer', function(){
                layer.msg('你确定要删除吗？', {
                    time: 0 //不自动关闭
                    ,btn: ['确定', '取消']
                    ,shade: [0.8, '#393D49']
                    ,yes: function(index){
                        layer.close(index);
                        var uid,url,data;
                        uid = This.attr('uid');
                        data = {'uid':uid};
                        url = "<?php echo url('admin/User/deluser'); ?>";
                        $.post(url,data,function(res){
                            if(res.status==1){
                                layui.use('layer', function(){
                                    layer.alert(res.msg, {icon: 6},function(){
                                        location.reload();
                                    });
                                });
                            }else{
                                layui.use('layer', function(){
                                    layer.msg(res.msg, {icon: 5});
                                });
                            }

                        })
                    }
                });
            })

        })
    })
</script>
