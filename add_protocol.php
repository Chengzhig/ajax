<?php
header("Content-Type:text/html;charset=utf-8");
$sn=$_POST['sn'];
$desc=$_POST['desc'];
$agreement=$_POST['agreement'];
$version=$_POST['version'];
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
    $sql="INSERT INTO protocol(template_sn, template_agreement, template_version,template_desc,create_time,create_uid,update_time,update_uid) VALUES ('$sn','$agreement','$version','$desc','$datetime',1,'$datetime',1);";
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