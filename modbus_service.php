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
        $(document).ready(function(){
            $("#addbtn").click(function(){
                document.getElementById('add_protocol').style.display='';
            });
            $("#closebtn").click(function(){
                document.getElementById('add_protocol').style.display='none';
            });
        });

        var pageCount=<?php
        require_once 'PageInfo.php';
        $tool1=new Pagetool();
        $pagecount=(int)($tool1->getPageCount("protocol")/10+1);
        echo "$pagecount"?>;
        var page=1;

        function getProtocol()
        {
            var xmlHttp;
            try{
                xmlHttp = new XMLHttpRequest();
            }catch(e)
            {
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
                    var ajaxData=document.getElementById("protocol");
                    var jsonData=JSON.parse(xmlHttp.responseText);//解析json数据
                    ajaxData.innerHTML=jsonData.data;
                }
            }
            xmlHttp.open("GET","./getProtocol.php?page="+page ,true);
            xmlHttp.send();
        }



        function FirstPage() {
            page=1;
            document.onload(getProtocol());
        }

        function NextPage() {
            page++;
            if(page>pageCount){
                page=pageCount;
            }
            document.onload(getProtocol());
        }
        function PriorPage() {
            page--;
            if(page<1){
                page=1;
            }
            document.onload(getProtocol());
        }
        function LastPage() {
            page=pageCount;
            document.onload(getProtocol());
        }

        function updateProtocolArgs(id)
        {
            var template_sn=document.getElementById('template_sn'+id).value;
            var template_version=document.getElementById('template_version'+id).value;
            var template_agreement=document.getElementById('agreement'+id).value;
            var template_desc=document.getElementById('template_desc'+id).value;
            //alert(id+" "+template_sn+" "+template_version+" "+template_agreement+" "+template_desc);
            $.ajax({
                url:"./update_protocol.php",
                data:{id:id,template_sn:template_sn,template_version:template_version,template_agreement:template_agreement,template_desc:template_desc},
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



        function setProtocolArgs(id) {
            window.location.href='./protocolArgs.php?id='+id;
        }

        function Load() {
            window.location.reload();
        }

        function deleteProtocol(id) {
            //window.location.href='/del_protocol.php?id='+id;
            $.ajax({
                url:"./del_protocol.php",
                data:{id:id},
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

        function addProtocol() {
            //window.location.href='/del_protocol.php?id='+id;
            var sn=document.getElementById('sn').value;
            var version=document.getElementById('version').value;
            var agreement=document.getElementById('agreement').value;
            var desc=document.getElementById('desc').value;
            $.ajax({
                url:"./add_protocol.php",
                data:{sn:sn,version:version,agreement:agreement,desc:desc},
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

    </script>
	<?php include "navigation.html" ?>
</head>
<body onload="getProtocol()" >
       <div class="tpl-content-wrapper">
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home">系统配置</a></li>
                <li class="am-active">modbus配置</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold"> 配置
                    </div>
                </div>

                    <form id="add_protocol" style="display: none" class="am-form tpl-form-line-form"  >
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">协议编号</label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" placeholder="请输入协议编号" id="sn" name="sn">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">协议描述</label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" placeholder="请输入协议描述" id="desc" name="desc">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">选择协议 </label>
                            <div class="am-u-sm-9">
                                <select data-am-selected="{searchBox: 1}" id="agreement" name="agreement">
                                    <option value="1">inovancePic</option>
                                    <option value="2">12345pic</option>
                                </select>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">协议版本</label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input"  placeholder="请输入协议版本" id="version" name="version">
                            </div>
                        </div>

                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <button onclick="addProtocol()" class="am-btn am-btn-primary tpl-btn-bg-color-success " >提交</button>

                                <button type="button" class="am-btn am-btn-primary tpl-btn-bg-color-success " id="closebtn">关闭</button>
                            </div>
                        </div>
                    </form>

                <div class="tpl-block">
                    <div class="am-g">
                        <div class="am-u-sm-12 am-u-md-6">
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button type="button" class="am-btn am-btn-default am-btn-success" id="addbtn">新增<span class="am-icon-plus"></span> </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="am-g">
                        <div class="am-u-sm-12">
                            <table class="am-table am-table-striped am-table-hover table-main" id="protocol">
                            </table>
                        </div>



                        <div class='am-cf'>
                            <div class='am-fr'>
                                <ul class='am-pagination tpl-pagination'>
                                    <li><a onclick='FirstPage()'>首页</a></li>
                                    <li><a onclick='PriorPage()'>上一页</a></li>
                                    <li><a onclick='NextPage()'>下一页</a></li>
                                    <li><a onclick='LastPage()'>尾页</a></li>
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
