<?php
header("Content-Type:text/html;charset=utf-8");
$id=$_POST['id'];
$db_path = './modbus.db';
$db = new SQLite3($db_path);
if( !$db ) {
    echo '不能连接数据库文件,请及时联系管理员<br />';
}
else
{
    $sql="update protocol set is_delete=1 where id=".$id;
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