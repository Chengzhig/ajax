<?php
header("Content-Type:text/html;charset=utf-8");
$plc_ip=$_POST['plc_ip'];
$plc_port=$_POST['plc_port'];
$plc_slaveID=$_POST['plc_slaveID'];
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
    $sql="INSERT INTO link_args(template_id, plc_ip, plc_port,plc_slave_id,create_time,create_uid,update_time,update_uid) VALUES ('$templateid','$plc_ip','$plc_port','$plc_slaveID','$datetime',1,'$datetime',1);";
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