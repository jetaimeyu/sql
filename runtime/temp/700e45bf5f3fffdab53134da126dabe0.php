<?php /*a:1:{s:67:"D:\phpStudy\WWW\sqlQuery\application\index\view\index\querysql.html";i:1535160472;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>迈迪网-sql查询</title>
    <link href="/static/common/layui/css/layui.css" rel="stylesheet" type="text/css" >
</head>
<body>
<style>
    .layui-table td, .layui-table th{
        padding: 10px 6px;
        line-height: 1;
        white-space: nowrap;
        max-width: 130px;
        overflow-x: auto;
    }
    .layui-table td::-webkit-scrollbar
    {
        width: 8px;
        height:5px;
        background-color: #F5F5F5;
    }

    /*定义滚动条轨道 内阴影+圆角*/
    .layui-table td::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    /*定义滑块 内阴影+圆角*/
    .layui-table td::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #555;
    }
    .layui-table th::-webkit-scrollbar
    {
        width: 8px;
        height:5px;
        background-color: #F5F5F5;
    }

    /*定义滚动条轨道 内阴影+圆角*/
    .layui-table th::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    /*定义滑块 内阴影+圆角*/
    .layui-table th::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #555;
    }
</style>
<div style="padding:30px">
    <form class="layui-form layui-form-pane" action=""method="post" style="position: relative;z-index: 100">
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">请输入sql</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入sql语句" class="layui-textarea" id="sqlinput" name="sqldata" ><?php echo htmlentities($sqlString); ?></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <button class="layui-btn" id="submitbtn" >提交</button>
        </div>
    </form>
    <?php if(count($sqlData)>0): ?>
    <div style="width:100%;overflow: auto">
        <table class="layui-table" >
            <thead>
            <tr>
                <?php foreach($sqlData[0] as $k=>$v): ?>
                <th><?php echo htmlentities($k); ?></th>
                <?php endforeach; ?>
            </tr>
            <?php foreach($sqlData as $key=>$vo): ?>
            <tr>
                <?php foreach($vo as $k=>$v): ?>
                <td><?php echo htmlentities($v); ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
            </thead>
        </table>
        <div id="pagebox" style="position: relative;z-index: 100;"></div>
    </div>
    <?php else: ?>
    暂无数据
    <?php endif; ?>
</div>
<script  src="/static/common/js/jquery.js"></script>
<script  src="/static/common/layui/layui.all.js"></script>
</body>
</html>
<script>
    layui.use('element', function(){
        var element = layui.element;
    });
    if("<?php echo htmlentities($dataCount); ?>"!=0){
        var currPage ="<?php echo htmlentities((app('request')->get('page') ?: 0)); ?>";
        currPage = currPage*1 +1;
        layui.use(['laypage', 'layer'], function() {
            var laypage = layui.laypage, layer = layui.layer;
            laypage.render({
                elem: 'pagebox'
                ,hash:true
                ,count: "<?php echo htmlentities($dataCount); ?>" //数据总数
                ,limit:10
                ,curr:currPage
                ,layout: ['count', 'prev', 'page', 'next']
                , jump: function (obj,first) {
                    if(!first){
                        var page = obj.curr-1;
                        console.log(page);
                        window.location.href ="<?php echo url('index/Index/querysql'); ?>?page="+page;
                    }
                }
            })
        })
    }
    $("#submitbtn").click(function(){
        if(!$.trim($("#sqlinput").val())){
            layer.msg('查询语句不能为空。。', {icon: 5});
            return false;
        }
    });
    //水印
    if("<?php echo htmlentities($dataCount); ?>">0){
        watermark({ watermark_txt: "迈迪网" });//传入动态水印内容
    }
    function watermark(settings) {
        //默认设置
        var defaultSettings={
            watermark_txt:"text",
            watermark_x:100,//水印起始位置x轴坐标
            watermark_y:20,//水印起始位置Y轴坐标
            watermark_rows:20,//水印行数
            watermark_cols:20,//水印列数
            watermark_x_space:100,//水印x轴间隔
            watermark_y_space:50,//水印y轴间隔
            watermark_color:'#000000',//水印字体颜色
            watermark_alpha:0.3,//水印透明度
            watermark_fontsize:'18px',//水印字体大小
            watermark_font:'微软雅黑',//水印字体
            watermark_width:120,//水印宽度
            watermark_height:80,//水印长度
            watermark_angle:15//水印倾斜度数
        };
        //采用配置项替换默认值，作用类似jquery.extend
        if(arguments.length===1&&typeof arguments[0] ==="object" )
        {
            var src=arguments[0]||{};
            for(key in src)
            {
                if(src[key]&&defaultSettings[key]&&src[key]===defaultSettings[key])
                    continue;
                else if(src[key])
                    defaultSettings[key]=src[key];
            }
        }

        var oTemp = document.createDocumentFragment();

        //获取页面最大宽度
        var page_width = Math.max(document.body.scrollWidth,document.body.clientWidth);
        //获取页面最大长度
        var page_height = Math.max(document.body.scrollHeight,document.body.clientHeight);

        //如果将水印列数设置为0，或水印列数设置过大，超过页面最大宽度，则重新计算水印列数和水印x轴间隔
        if (defaultSettings.watermark_cols == 0 ||
                (parseInt(defaultSettings.watermark_x
                        + defaultSettings.watermark_width *defaultSettings.watermark_cols
                        + defaultSettings.watermark_x_space * (defaultSettings.watermark_cols - 1))
                > page_width)) {
            defaultSettings.watermark_cols =
                    parseInt((page_width
                            -defaultSettings.watermark_x
                            +defaultSettings.watermark_x_space)
                            / (defaultSettings.watermark_width
                            + defaultSettings.watermark_x_space));
            defaultSettings.watermark_x_space =
                    parseInt((page_width
                            - defaultSettings.watermark_x
                            - defaultSettings.watermark_width
                            * defaultSettings.watermark_cols)
                            / (defaultSettings.watermark_cols - 1));
        }
        //如果将水印行数设置为0，或水印行数设置过大，超过页面最大长度，则重新计算水印行数和水印y轴间隔
        if (defaultSettings.watermark_rows == 0 ||
                (parseInt(defaultSettings.watermark_y
                        + defaultSettings.watermark_height * defaultSettings.watermark_rows
                        + defaultSettings.watermark_y_space * (defaultSettings.watermark_rows - 1))
                > page_height)) {
            defaultSettings.watermark_rows =
                    parseInt((defaultSettings.watermark_y_space
                            + page_height - defaultSettings.watermark_y)
                            / (defaultSettings.watermark_height + defaultSettings.watermark_y_space));
            defaultSettings.watermark_y_space =
                    parseInt((page_height
                            - defaultSettings.watermark_y
                            - defaultSettings.watermark_height
                            * defaultSettings.watermark_rows)
                            / (defaultSettings.watermark_rows - 1));
        }
        var x;
        var y;
        for (var i = 0; i < defaultSettings.watermark_rows; i++) {
            y = defaultSettings.watermark_y + (defaultSettings.watermark_y_space + defaultSettings.watermark_height) * i;
            for (var j = 0; j < defaultSettings.watermark_cols; j++) {
                x = defaultSettings.watermark_x + (defaultSettings.watermark_width + defaultSettings.watermark_x_space) * j;

                var mask_div = document.createElement('div');
                mask_div.id = 'mask_div' + i + j;
                mask_div.appendChild(document.createTextNode(defaultSettings.watermark_txt));
                //设置水印div倾斜显示
                mask_div.style.webkitTransform = "rotate(-" + defaultSettings.watermark_angle + "deg)";
                mask_div.style.MozTransform = "rotate(-" + defaultSettings.watermark_angle + "deg)";
                mask_div.style.msTransform = "rotate(-" + defaultSettings.watermark_angle + "deg)";
                mask_div.style.OTransform = "rotate(-" + defaultSettings.watermark_angle + "deg)";
                mask_div.style.transform = "rotate(-" + defaultSettings.watermark_angle + "deg)";
                mask_div.style.visibility = "";
                mask_div.style.position = "absolute";
                mask_div.style.left = x + 'px';
                mask_div.style.top = y + 'px';
                mask_div.style.overflow = "hidden";
                mask_div.style.zIndex = "99";
                //mask_div.style.border="solid #eee 1px";
                mask_div.style.opacity = defaultSettings.watermark_alpha;
                mask_div.style.fontSize = defaultSettings.watermark_fontsize;
                mask_div.style.fontFamily = defaultSettings.watermark_font;
                mask_div.style.color = defaultSettings.watermark_color;
                mask_div.style.textAlign = "center";
                mask_div.style.width = defaultSettings.watermark_width + 'px';
                mask_div.style.height = defaultSettings.watermark_height + 'px';
                mask_div.style.display = "block";
                oTemp.appendChild(mask_div);
            };
        };
        document.body.appendChild(oTemp);
    }

</script>