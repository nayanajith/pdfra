<?php
$db_orig=$GLOBALS['DB'];
if(isset($GLOBALS['DB_ORIG'])){
	$db_orig=$GLOBALS['DB_ORIG'];
}


add_to_main_top("<center>
<b>".$GLOBALS['TITLE']."</b><br>
<u>-System Status-</u>
<table class='clean' border=1>
<tr><th align='right'>Original Database</th><td><code style='font-size10px'>$db_orig</code></td></tr>
<tr><th align='right'>Active Database</th><td><code style='font-size10px'>".$GLOBALS['DB']."</code></td></tr>
<tr><th align='right'>Disk</th><td><code style='font-size10px'>".exec('df -h .')."</code></td></tr>
<tr><th align='right'>Uptime</th><td><code style='font-size10px'>".exec('uptime')."</code></td></tr>
<tr><th align='right'>Last</th><td><code style='font-size10px'>".exec('last -3')."</code></td></tr>
<tr><th align='right'>Who</th><td><code style='font-size10px'>".exec('who')."</code></td></tr>
</table>
</center>");

//List of online users
$online_arr=exec_query("select * from users where last_login > last_logout",Q_RET_ARRAY);
$online="<center><h4>Online Users</h4>";
foreach($online_arr as $row){
   $online.=$row['email']."<br/>";
}
$online.="</center>";
add_to_main_bottom($online);

set_layout_property('app2','MAIN_TOP','style','height','30%');
set_layout_property('app2','MAIN_BOTTOM','style','height','70%');

?>
