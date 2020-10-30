<?php
error_reporting(0);//不显示警告信息
header("Content-Type:text/html;charset=utf-8");
$id=$_GET["id"];
$page=$_GET['page'];
$db_path = './modbus.db';
$db = new SQLite3($db_path);
$pagenum=($page-1)*10;

$query="select * from link_args where is_delete=0 and template_id=".$id." limit 10 offset $pagenum";;

$qry_result=$db->query($query);

if($qry_result->numColumns()==0)
{
    echo json_encode(['data'=>'<h2>未找到符合条件的记录</h2>']);
    return ;
}

$display_string ="<tr>";
$display_string .="<th class=\"table-id\">ID</th>";
$display_string .="<th class=\"table-type\">plc的IP地址</th>";
$display_string .="<th class=\"table-type\">plc的端口号</th>";
$display_string .="<th class=\"table-type\">plc的slaveID</th>";
$display_string .="<th class=\"table-author am-hide-sm-only\">创建时间</th>";
$display_string .="<th class=\"table-date am-hide-sm-only\">修改时间</th>";
$display_string .="<th class=\"table-set\">操作</th>";
$display_string .="</tr>";

//insert a new row in the table for each person returned
while($row=$qry_result->fetchArray(SQLITE3_ASSOC)){
    $display_string.="<tr>";
    $display_string.="<td><input type='text' style=\"width:20px;\" value='$row[id]'></td>";
    $display_string.="<td><input type='text' id='linkplc_ip$row[id]' style=\"width:80px;\" value='$row[plc_ip]'></td>";
    $display_string.="<td><input type='text' id='plc_port$row[id]' style=\"width:50px;\" value='$row[plc_port]'></td>";
    $display_string.="<td><input type='text' id='plc_slave_id$row[id]' style=\"width:80px;\" value='$row[plc_slave_id]'></td>";
    $display_string.="<td>$row[create_time]'</td>";
    $display_string.="<td>$row[update_time]'</td>";
    $display_string.="<td><div class=\"am-btn-toolbar\">
                            <div class=\"am-btn-group am-btn-group-xs\">
                                 <button onclick=\"deleteLinkArgs($row[id])\" class=\"am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only\"> 删除</button>
                                 <button onclick=\"updateLinkArgs($row[id])\" class=\"am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only\"> 保存</button>
                             </div>
                         </div>
                      </td></tr>";
}

echo json_encode(['data'=>$display_string]);//返回json数据格式
?>