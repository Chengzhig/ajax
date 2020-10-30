<?php
error_reporting(0);//不显示警告信息
header("Content-Type:text/html;charset=utf-8");
$page=$_GET['page'];
$db_path = './modbus.db';
$db = new SQLite3($db_path);
$pagenum=($page-1)*10;

$query="select * from protocol where is_delete=0 limit 10 offset $pagenum";

$qry_result=$db->query($query);

if($qry_result->numColumns()==0)
{
    echo json_encode(['data'=>'<h2>未找到符合条件的记录</h2>']);
    return ;
}

$display_string ="<tr>";
$display_string .="<th class=\"table-id\">ID</th>";
$display_string .="<th class=\"table-type\">协议编号</th>";
$display_string .="<th class=\"table-type\">协议版本</th>";
$display_string .="<th class=\"table-type\">协议类型</th>";
$display_string .="<th class=\"table-type\">描述</th>";
$display_string .="<th class=\"table-author am-hide-sm-only\">创建时间</th>";
$display_string .="<th class=\"table-date am-hide-sm-only\">修改时间</th>";
$display_string .="<th class=\"table-set\">操作</th>";
$display_string .="</tr>";

//insert a new row in the table for each person returned
while($row=$qry_result->fetchArray(SQLITE3_ASSOC)){
    $display_string.="<tr>";
    $display_string.="<td><p name='id'>$row[id]</p></td>";
    $display_string.="<td><input style=\"width:50px;\" type='text' name='template_sn' id='template_sn$row[id]' value='$row[template_sn]'></td>";
    $display_string.="<td><input style=\"width:50px;\" type='text' name='template_version' id='template_version$row[id]' value='$row[template_version]'></td>";
    if($row[template_agreement]=='1'){
        $display_string.="<td><select data-am-selected=\"{searchBox: 1}\" name=\"agreement\" id='agreement$row[id]'  >
                                    <option value=\"1\" selected>inovancePic</option>
                                    <option value=\"2\">12345pic</option>
                                </select></td>";
    }
    else{
        $display_string.="<td><select data-am-selected=\"{+searchBox: 1}\" name=\"agreement\" id='agreement$row[id]' >
                                    <option value='1'>inovancePic</option>
                                    <option value='2' selected>12345pic</option>
                                </select></td>";
    }
    $display_string.="<td><input style=\"width:100px;\" type='text' name='template_desc' id='template_desc$row[id]'  value='$row[template_desc]'></td>";
    $display_string.="<td>$row[create_time]</td>";
    $display_string.="<td>$row[update_time]</td>";
    $display_string.="<td><div class=\"am-btn-toolbar\">
                            <div class=\"am-btn-group am-btn-group-xs\">
                                 <button onclick=\"setProtocolArgs($row[id])\" class=\"am-btn am-btn-default am-btn-xs am-text-secondary\">参数设置</button>
                                 <button onclick=\"updateProtocolArgs($row[id])\" class=\"am-btn am-btn-default am-btn-xs am-text-secondary\" >保存</button>
                                 <button onclick=\"deleteProtocol($row[id])\" class=\"am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only\"> 删除</button>
                             </div>
                         </div>
                      </td></tr>
                      ";
}

echo json_encode(['data'=>$display_string]);//返回json数据格式
?>