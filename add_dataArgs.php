<?php
header("Content-Type:text/html;charset=utf-8");
$plc_ip=$_POST['plc_ip'];
$plc_reg_type=$_POST['plc_reg_type'];
$data_type=$_POST['data_type'];
$data_name=$_POST['data_name'];
$data_multi=$_POST['data_multi'];
$templateid=$_POST['id'];
$db_path = './modbus.db';
$db = new SQLite3($db_path);
if( !$db ) {
    echo '不能连接数据库文件,请及时联系管理员<br />';
}
else
{
    $now=new DateTime('now');
    $datetime=$now->format("Y-m-d H:i:s");
    //echo '成功连接SQlite文件<br />';
    $sql="INSERT INTO data_args(template_id, plc_ip, plc_reg_type,data_type,data_name,data_multi,create_time,create_uid,update_time,update_uid) VALUES ('$templateid','$plc_ip', '$plc_reg_type','$data_type','$data_name','$data_multi','$datetime',1,'$datetime',1);";
    if($db->query($sql))
    {
        echo "OK";
    }
    else{
        echo"NO";
    }
    $db->close();
}
?>