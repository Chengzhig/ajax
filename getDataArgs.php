<?php
error_reporting(0);//不显示警告信息
header("Content-Type:text/html;charset=utf-8");
$id=$_GET["id"];
$page=$_GET['page'];
$db_path = './modbus.db';
$db = new SQLite3($db_path);
$pagenum=($page-1)*10;

$query="select * from data_args where is_delete=0 and template_id=".$id." limit 10 offset $pagenum";;

$qry_result=$db->query($query);

if($qry_result->numColumns()==0)
{
    echo json_encode(['data'=>'<h2>未找到符合条件的记录</h2>']);
    return ;
}

$display_string ="<tr>";
$display_string .="<th>ID</th>";
$display_string .="<th>plc的IP地址</th>";
$display_string .="<th>plc的reg类型</th>";
$display_string .="<th>数据类型</th>";
$display_string .="<th>数据名称</th>";
$display_string .="<th>数据multi</th>";
$display_string .="<th>创建时间</th>";
$display_string .="<th>修改时间</th>";
$display_string .="<th>操作</th>";
$display_string .="</tr>";

//insert a new row in the table for each person returned
while($row=$qry_result->fetchArray(SQLITE3_ASSOC)){
    $display_string.="<tr>";
    $display_string.="<td><p name='id'>$row[id]</p></td>";
    $display_string.="<td><input style=\"width:100px;\" id='dataplc_ip$row[id]' name='plc_ip' value='$row[plc_ip]'></td>";
    $display_string.="<td><input style=\"width:100px;\" id='plc_reg_type$row[id]' name='plc_reg_type' value='$row[plc_reg_type]'></td>";
    $display_string.="<td><input style=\"width:50px;\" id='data_type$row[id]' name='data_type'  value='$row[data_type]'></td>";
    $display_string.="<td><input style=\"width:50px;\" id='data_name$row[id]' name='data_name'  value='$row[data_name]'></td>";
    $display_string.="<td><input style=\"width:30px;\" id='data_multi$row[id]' name='data_multi'  value='$row[data_multi]'></td>";
    $display_string.="<td>$row[create_time]</td>";
    $display_string.="<td>$row[update_time]</td>";
    $display_string.="<td><div class=\"am-btn-toolbar\">
                            <div class=\"am-btn-group am-btn-group-xs\">
                                 <button onclick=\"deleteDataArgs($row[id])\" class=\"am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only\"> 删除</button>
                                 <button onclick=\"updateDataArgs($row[id])\" class=\"am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only\"> 保存</button>
                          
                             </div>
                         </div>
                      </td></tr>";
}

echo json_encode(['data'=>$display_string]);//返回json数据格式
?>