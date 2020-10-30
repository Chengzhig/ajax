<?php

header("Content-Type:text/html;charset=utf-8");

$id=$_POST['id'];
$template_sn=$_POST['template_sn'];
$template_version=$_POST['template_version'];
$template_agreement=$_POST['template_agreement'];
$template_desc=$_POST['template_desc'];
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
    $sql="UPDATE protocol SET template_sn='$template_sn',template_version='$template_version',template_agreement='$template_agreement',template_desc='$template_desc',update_time='$datetime' where id=".$id;
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