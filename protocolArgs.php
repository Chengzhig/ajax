<?php
$id=$_GET["id"];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>4/5G网关WEB管理系统</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="stylesheet" href="assets/css/amazeui.min.css" />
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <script src="assets/js/jquery-2.1.1.js"></script>
    <script src="assets/js/echarts.min.js"></script>
    <script>
        var linkpageCount=<?php
            require_once 'PageInfo.php';
            $tool1=new Pagetool();
            $linkpagecount=(int)($tool1->getPageCount("link_args")/10+1);
            echo "$linkpagecount"?>;
        var linkpage=1;

        var datapageCount=<?php
            $datapagecount=(int)($tool1->getPageCount("data_args")/10+1);
            echo "$datapagecount"?>;
        var datapage=1;

        $(document).ready(function(){
            $("#addbtn1").click(function(){
                document.getElementById('add_linkArgs').style.display='';
            });
            $("#closebtn1").click(function(){
                document.getElementById('add_linkArgs').style.display='none';
            });
            $("#addbtn2").click(function(){
                document.getElementById('add_dataArgs').style.display='';
            });
            $("#closebtn2").click(function(){
                document.getElementById('add_dataArgs').style.display='none';
            });
        });
    </script>
    <script>
        function Load() {
            window.location.reload();
        }


        function FirstDataPage() {
            datapage=1;
            document.onload(getdataArgs());
        }

        function NextDataPage() {
            datapage++;
            if(datapage>datapageCount){
                datapage=datapageCount;
            }
            document.onload(getdataArgs());
        }
        function PriorDataPage() {
            datapage--;
            if(datapage<1){
               datapage=1;
            }
            document.onload(getdataArgs());
        }
        function LastDataPage() {
            datapage=datapageCount;
            document.onload(getdataArgs());
        }

        function FirstLinkPage() {
            linkpage=1;
            document.onload(getlinkArgs());
        }

        function NextLinkPage() {
            linkpage++;
            if(linkpage>linkpageCount){
                linkpage=linkpageCount;
            }
            document.onload(getlinkArgs());
        }
        function PriorLinkPage() {
            linkpage--;
            if(linkpage<1){
                linkpage=1;
            }
            document.onload(getlinkArgs());
        }
        function LastLinkPage() {
            linkpage=linkpageCount;
            document.onload(getlinkArgs());
        }


        var tid=<?php echo $id?>;
        function getlinkArgs()
        {

            var xmlHttp;
            try{
                xmlHttp = new XMLHttpRequest();
            }catch(e){
                //IE浏览器需要用ActiveXObject来创建 XMLHttpRequest对象
                try{
                    //如果Javascript的版本大于5
                    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
                }catch(e){
                    try{
                        //如果不是 则使用老版本的ActiveX对象
                        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }catch(e){
                        alert("您的浏览器不支持");
                        return false;
                    }
                }
            }
            xmlHttp.onreadystatechange=function(){
                if(xmlHttp.readyState==4){
                    var ajaxData=document.getElementById("linkArgs");
                    var jsonData=JSON.parse(xmlHttp.responseText);//解析json数据
                    ajaxData.innerHTML=jsonData.data;
                }
            }
            xmlHttp.open("GET","./getLinkArgs.php?id="+tid+"&page="+linkpage ,true);
            xmlHttp.send();
        }

        function getdataArgs()
        {

            var xmlHttp;
            try{
                xmlHttp = new XMLHttpRequest();
            }catch(e){
                //IE浏览器需要用ActiveXObject来创建 XMLHttpRequest对象
                try{
                    //如果Javascript的版本大于5
                    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
                }catch(e){
                    try{
                        //如果不是 则使用老版本的ActiveX对象
                        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }catch(e){
                        alert("您的浏览器不支持");
                        return false;
                    }
                }
            }
            xmlHttp.onreadystatechange=function(){
                if(xmlHttp.readyState==4){
                    var ajaxData=document.getElementById("dataArgs");
                    var jsonData=JSON.parse(xmlHttp.responseText);//解析json数据
                    ajaxData.innerHTML=jsonData.data;
                }
            }
            xmlHttp.open("GET","./getDataArgs.php?id="+tid+"&page="+datapage,true);
            xmlHttp.send();
        }

        function addLinkArgs() {
            //window.location.href='/del_protocol.php?id='+id;
            var plc_ip1=document.getElementById('plc_ip1').value;
            var plc_port=document.getElementById('plc_port').value;
            var plc_slaveID=document.getElementById('plc_slaveID').value;
            $.ajax({
                url:"./add_linkArgs.php",
                data:{plc_ip:plc_ip1,plc_port:plc_port,plc_slaveID:plc_slaveID,id:tid},
                type:"POST",
                dataType:"TEXT",
                success:function(xx){
                    if(xx.trim()=="OK")
                    {
                        alert("添加成功");
                        Load();
                    }
                    else{
                        alert("添加失败");
                        Load();
                    }
                }
            })
        }

        function addDataArgs() {
            //window.location.href='/del_protocol.php?id='+id;
            var plc_ip2=document.getElementById('plc_ip2').value;
            var plc_reg_type=document.getElementById('plc_reg_type').value;
            var data_type=document.getElementById('data_type').value;
            var data_name=document.getElementById('data_name').value;
            var data_multi=document.getElementById('data_multi').value;
            $.ajax({
                url:"./add_dataArgs.php",
                data:{plc_ip:plc_ip2,plc_reg_type:plc_reg_type,data_type:data_type,data_name:data_name,data_multi:data_multi,id:tid},
                type:"POST",
                dataType:"TEXT",
                success:function(xx){
                    if(xx.trim()=="OK")
                    {
                        alert("添加成功");
                        Load();
                    }
                    else{
                        alert("添加失败");
                        Load();
                    }
                }
            })
        }

        function deleteLinkArgs(id) {
            //window.location.href='/del_linkArgs.php?tid='+tid+'&id='+id;
            $.ajax({
                url:"./del_linkArgs.php",
                data:{tid:tid,id:id},
                type:"POST",
                dataType:"TEXT",
                success:function(xx){
                    if(xx.trim()=="OK")
                    {
                        alert("删除成功");
                        Load();
                    }
                    else{
                        alert("删除失败");
                        Load();
                    }
                }
            })
        }

        function deleteDataArgs(id) {
            //window.location.href='/del_dataArgs.php?tid='+tid+'&id='+id;
            $.ajax({
                url:"./del_dataArgs.php",
                data:{tid:tid,id:id},
                type:"POST",
                dataType:"TEXT",
                success:function(xx){
                    if(xx.trim()=="OK")
                    {
                        alert("删除成功");
                        Load();
                    }
                    else{
                        alert("删除失败");
                        Load();
                    }
                }
            })
        }

        function updateLinkArgs(id)
        {
            var linkplc_ip=document.getElementById('linkplc_ip'+id).value;
            var plc_port=document.getElementById('plc_port'+id).value;
            var plc_slave_id=document.getElementById('plc_slave_id'+id).value;
            //alert(id+" "+template_sn+" "+template_version+" "+template_agreement+" "+template_desc);
            $.ajax({
                url:"./update_LinkArgs.php",
                data:{id:id,plc_ip:linkplc_ip,plc_port:plc_port,plc_slave_id:plc_slave_id},
                type:"POST",
                dataType:"TEXT",
                success:function(xx){
                    if(xx.trim()=="OK")
                    {
                        alert("修改成功");
                        Load();
                    }
                    else{
                        alert("修改失败");
                        Load();
                    }
                }
            })
        }
        function updateDataArgs(id)
        {
            var dataplc_ip=document.getElementById('dataplc_ip'+id).value;
            var plc_reg_type=document.getElementById('plc_reg_type'+id).value;
            var data_type=document.getElementById('data_type'+id).value;
            var data_name=document.getElementById('data_name'+id).value;
            var data_multi=document.getElementById('data_multi'+id).value;
            //alert(id+" "+template_sn+" "+template_version+" "+template_agreement+" "+template_desc);
            $.ajax({
                url:"./update_DataArgs.php",
                data:{id:id,plc_ip:dataplc_ip,plc_reg_type:plc_reg_type,data_type:data_type,data_name:data_name,data_multi:data_multi},
                type:"POST",
                dataType:"TEXT",
                success:function(xx){
                    if(xx.trim()=="OK")
                    {
                        alert("修改成功");
                        Load();
                    }
                    else{
                        alert("修改失败");
                        Load();
                    }
                }
            })
        }


    </script>
	<?php include "navigation.html" ?>
</head>
<body onload="getlinkArgs();getdataArgs()">
       <div class="tpl-content-wrapper">
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home">系统配置</a></li>
                <li class="am-active">协议配置</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold"> 协议配置
                    </div>
                </div>
                <form id="add_linkArgs" style="display: none" class="am-form tpl-form-line-form" ">
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">plc的IP地址</label>
                        <div class="am-u-sm-9">
                            <input type="text" class="tpl-form-input" placeholder="请输入plc的IP地址" id="plc_ip1" name="plc_ip">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">plc的端口号</label>
                        <div class="am-u-sm-9">
                            <input type="text" class="tpl-form-input" placeholder="请输入plc的端口号" id="plc_port" name="plc_port">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">plc的slaveID</label>
                        <div class="am-u-sm-9">
                            <input type="text" class="tpl-form-input"  placeholder="请输入plc的slaveID" id="plc_slaveID" name="plc_slaveID">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <button onclick="addLinkArgs()" class="am-btn am-btn-primary tpl-btn-bg-color-success " >提交</button>

                            <button type="button" class="am-btn am-btn-primary tpl-btn-bg-color-success " id="closebtn1">关闭</button>
                        </div>
                    </div>
                </form>

                <form id="add_dataArgs" style="display: none" class="am-form tpl-form-line-form" >
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">plc的IP地址</label>
                        <div class="am-u-sm-9">
                            <input type="text" class="tpl-form-input" placeholder="请输入plc的IP地址" id="plc_ip2" name="plc_ip">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">plc的reg类型</label>
                        <div class="am-u-sm-9">
                            <input type="text" class="tpl-form-input" placeholder="请输入plc的reg类型" id="plc_reg_type" name="plc_reg_type">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">数据类型</label>
                        <div class="am-u-sm-9">
                            <input type="text" class="tpl-form-input"  placeholder="请输入数据类型" id="data_type" name="data_type">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">数据名称</label>
                        <div class="am-u-sm-9">
                            <input type="text" class="tpl-form-input"  placeholder="请输入数据名称" id="data_name" name="data_name">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">数据multi</label>
                        <div class="am-u-sm-9">
                            <input type="text" class="tpl-form-input"  placeholder="请输入数据multi" id="data_multi" name="data_multi">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <button onclick="addDataArgs()" class="am-btn am-btn-primary tpl-btn-bg-color-success " >提交</button>

                            <button type="button" class="am-btn am-btn-primary tpl-btn-bg-color-success " id="closebtn2">关闭</button>
                        </div>
                    </div>
                </form>
                <div class="tpl-block">
                    <div class="am-g">
                        <div class="am-u-sm-12 am-u-md-6">
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button type="button" class="am-btn am-btn-default am-btn-success" id="addbtn1">新增<span class="am-icon-plus"></span> </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="am-g">
                        <div class="am-u-sm-12">
                            <table class="am-table am-table-striped am-table-hover table-main" id="linkArgs">
                            </table>
                        </div>
                        <div class='am-cf'>
                            <div class='am-fr'>
                                <ul class='am-pagination tpl-pagination'>
                                    <li><a onclick='FirstLinkPage()'>首页</a></li>
                                    <li><a onclick='PriorLinkPage()'>上一页</a></li>
                                    <li><a onclick='NextLinkPage()'>下一页</a></li>
                                    <li><a onclick='LastLinkPage()'>尾页</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tpl-block">
                    <div class="am-g">
                        <div class="am-u-sm-12 am-u-md-6">
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button type="button" class="am-btn am-btn-default am-btn-success" id="addbtn2">新增<span class="am-icon-plus"></span> </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="am-g">
                        <div class="am-u-sm-12">
                            <table class="am-table am-table-striped am-table-hover table-main" id="dataArgs">
                            </table>
                        </div>
                        <div class='am-cf'>
                            <div class='am-fr'>
                                <ul class='am-pagination tpl-pagination'>
                                    <li><a onclick='FirstDataPage()'>首页</a></li>
                                    <li><a onclick='PriorDataPage()'>上一页</a></li>
                                    <li><a onclick='NextDataPage()'>下一页</a></li>
                                    <li><a onclick='LastDataPage()'>尾页</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <script src="assets/js/amazeui.min.js"></script>
    <script src="assets/js/app.js"></script>


</body>
<?php include "foot.html" ?>
</html>
