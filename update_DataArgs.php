<?php

header("Content-Type:text/html;charset=utf-8");

$id=$_POST['id'];
$plc_ip=$_POST['plc_ip'];
$plc_reg_type=$_POST['plc_reg_type'];
$data_type=$_POST['data_type'];
$data_name=$_POST['data_name'];
$data_multi=$_POST['data_multi'];
$now=new DateTime('now');
$datetime=$now->format("Y-m-d H:i:s");
//$db_path = './db/Login_test.db';
$db_path = './modbus.db';
$db = new SQLite3($db_path);
if( !$db ) {
    echo '不能连接数据库文件,请及时联系管理员<br />';
}
else
{
    //echo '成功连接SQlite文件<br />';
    $sql="UPDATE data_args SET plc_ip='$plc_ip',plc_reg_type='$plc_reg_type',data_type='$data_type',data_name='$data_name',data_multi='$data_multi',update_time='$datetime' where id=".$id;
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