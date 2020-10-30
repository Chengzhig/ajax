<?php
class Pagetool {
    function getPageCount($name)
    {
        $db_path = './modbus.db';
        $db = new SQLite3($db_path);
        if( !$db ) {
            echo '不能连接数据库文件,请及时联系管理员<br />';
        }
        else
        {
            $result = $db->query("SELECT count(*) FROM $name WHERE is_delete = 0");
            while ($row=$result->fetchArray(SQLITE3_ASSOC)){
                return $row["count(*)"];
            }
        }
        return "ERROR";
    }

}