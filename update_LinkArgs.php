<?php

header("Content-Type:text/html;charset=utf-8");

$id=$_POST['id'];
$plc_ip=$_POST['plc_ip'];
$plc_port=$_POST['plc_port'];
$plc_slave_id=$_POST['plc_slave_id'];
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
    $sql="UPDATE link_args SET plc_ip='$plc_ip',plc_port='$plc_port',plc_slave_id='$plc_slave_id',update_time='$datetime' where id=".$id;
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