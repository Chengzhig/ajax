<?php
header("Content-Type:text/html;charset=utf-8");
$id=$_POST['id'];
$tid=$_POST['tid'];
$db_path = './modbus.db';
$db = new SQLite3($db_path);
if( !$db ) {
    echo '不能连接数据库文件,请及时联系管理员<br />';
}
else
{
    $sql="update data_args set is_delete=1 where id=".$id;
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