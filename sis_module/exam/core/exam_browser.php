<?php
if(!isset($_SESSION['username'])){return;}
openDB();

/*
 * @query : mysql query which returns single column
 * Return : 1D array of the list of elements return by the given query
 */

function item_array($query){
	$result  = mysql_query($query, $GLOBALS['CONNECTION']);
   $items = array();
	
 	while($row = mysql_fetch_array($result)){
      if($row[1]){
         $items[$row[1]]=$row[0];
      }else{
         $items[]=$row[0];
      }
	}
   return $items;
}

//Compose the url
/*
function gen_url($append){
	$url='?';
	$key_in_url=false;
   foreach($_GET as $key => $value ){
		if($key == $append[0]){
			$url.=$key."=".$append[1]."&";
			$key_in_url=true;
		}else{
			$url.=$key."=".$value."&";
		}
	}
	if($key_in_url){
	return $url;
	}else{
	return $url.$append[0]."=".$append[1];
	}
}
*/

function gen_url($append){
	global $module;
	global $page;
	return "?module=$module&page=$page&$append";
}
/*
 * Print the array as a list (formatted acoording to the provided values)
 * $items: Array of items to be print in ($key => $value) format or ($value) format
 * $url  : Former URL where values of the array is to be appended 
 * $name : Name of the list to be printed at the top of the list
 * $selection: The selecte item to be hihglighted
 * $usekey: If this value is set/true $key will be used in URLs in ($key => $value) arrays 
 */

function print_items($items,$url,$name,$selection,$usekey){

   echo "<td>".ucfirst($name)."<div  class=items_div id='$name'><ul class=items>\n";
   foreach($items as $key => $item ){

      if(!$usekey){
         $key=$item; 
      }

      //Generate/validate variables
      $escape=array('/','(',')');
      //$href =$_SERVER["REQUEST_URI"]."$url&$name=$key";
      $href =gen_url("$name=$key".$url);
      //$href =gen_url(array($name,$key));
      $id   =str_replace($escape,"_",$key."_".$name);

      if($key==$selection){
         echo "<li><a href='$href' id='$id' onMouseDown='getScrollXY(\"$id\")' title='$key'><div class=selected_folder>$item</div></a></li>\n";
      }else{
         echo "<li><a href='$href' id='$id' onMouseDown='getScrollXY(\"$id\")' title='$key'><div class=normal_folder>$item</div></a></li>\n";
      }
   }
   echo "</ul>
   </div>\n
   <script>
      setScrollXY(\"$name\",".(empty($_GET['scroll_'.$name])?0:$_GET['scroll_'.$name]).",".(empty($_GET['scroll_left_'.$name])?0:$_GET['scroll_left_'.$name]).");
   </script> 
      </td>
   ";
}

$examid     =$_GET['examid'];
$courseid   =$_GET['courseid'];
$indexno    =$_GET['indexno'];
$courseid2  =$_GET['courseid2'];
$table      =$_GET['table'];
$batch      =$_GET['batch'];
$batchwise  =$_GET['batchwise'];


/*
 * Generate the javascript functions required
 */

$names=array(
   "examid",
   "courseid",
   "courseid2",
   "table",
   "batch",
   "indexno"
   );

echo "
<script>
function getScrollXY(href_id) {
   var scroll_ids=new Array('".implode('\',\'',$names)."');

  var obj_href=document.getElementById(href_id);
  for (i in scroll_ids)
  {
   var obj_scroll=document.getElementById(scroll_ids[i]);
   obj_href.href+='&scroll_'+scroll_ids[i]+'='+obj_scroll.scrollTop;
   obj_href.href+='&scroll_left_'+scroll_ids[i]+'='+obj_scroll.scrollLeft;
  }
}

function setScrollXY(id,scroll_top,scroll_left) {
  obj=document.getElementById(id);
  obj.scrollTop=scroll_top;
  obj.scrollLeft=scroll_left;
}

function set_batchwize(id){
   obj_bw=document.getElementById(id);
   obj_it=document.getElementById('itmarks_table');
   obj_cs=document.getElementById('csmarks_table');
   var bw='batchwise';
   if(obj_it.href.match(bw)){
      obj_it.href=obj_it.href.replace(/(batchwise=true)|(batchwise=false)/i,'batchwise='+obj_bw.checked);
      obj_cs.href=obj_cs.href.replace(/(batchwise=true)|(batchwise=false)/i,'batchwise='+obj_bw.checked);
   }else{
      obj_it.href=obj_it.href+='&batchwise='+obj_bw.checked;
      obj_cs.href=obj_cs.href+='&batchwise='+obj_bw.checked;
   }
}

</script>
";



echo "<div id='browser_box' >
   <table cellpadding=0 cellspacing=0 border=0 margin=0>
   </tr><td>";
if($batchwise=="true"){
   echo "<input type=checkbox name=batchwise id=batchwise checked=checked onclick='set_batchwize(\"batchwise\")'>";
}else{
   echo "<input type=checkbox name=batchwise id=batchwise onclick='set_batchwize(\"batchwise\")'>";
}
   
echo "<label for=batchwise>Batch wise</label></td>";

$tables   = array("itmarks"=>"ICT","csmarks"=>"CS");
/*
 * Selecte table2 -> student_registration table according to the the given marks table
 */
$table2="";
switch($table){
case 'itmarks':
   $table2='itstudent';
   break;
case 'csmarks':
   $table2='csstudent';
   break;
}

/*
 * Print streams
 */
$name    = "table";

if($batchwise=="true"){
   $url     = "batchwise=true";
}else{
   $url     = "";
}
$selected= $table;
print_items($tables,$url,$name,$selected,true);

/*
 * if the stream is not empty; print list of batches related to that table
 */


if($batchwise=="true"){

if($table){
$limit   = 50;
$name    = "batch";
$url    .= "&table=$table";
$query   = "SELECT DISTINCT $name FROM $table2   ORDER BY $name DESC" ;	
$selected= $batch;
print_items(item_array($query),$url,$name,$selected);
}

/*
 *
 * if the batches not empty; print list of examids related to that batch
 * Courses can be selected batch wise or examid wise
 *
 */
/*
if(!empty($batch)){
$limit   = 20;
$name    = "examid";
$url    .= "&batch=$batch";
$selected= $examid;
//NOTE: examids generated statically --> SHOULD do some validations <--

print_items(get_examids($batch),$url,$name,$selected,true);
}

if(!empty($examid)){
$name    = "courseid";
$url    .= "&examid=$examid";
//$query   = "SELECT DISTINCT m.$name,c.coursename FROM $table as m,courses as c  WHERE m.examid='$examid' AND m.courseid=c.courseid ORDER BY $name DESC";	
$query   = "SELECT DISTINCT $name FROM $table WHERE examid='$examid'  ORDER BY $name";	
$selected= $courseid;

print_items(item_array($query),$url,$name,$selected);
}
 */

if(!empty($batch)){
$limit   = 1000;
$name    = "indexno";
$url    .= "&batch=$batch";
//$query   = "SELECT DISTINCT m.$name FROM $table as m,$table2 as s WHERE s.batch='$batch' and s.indexno=m.indexno and m.courseid='$courseid' ORDER BY $name DESC LIMIT 1,$limit" ;	
$query   = "SELECT DISTINCT indexno FROM $table2  WHERE batch='$batch'" ;	
$selected= $indexno;

print_items(item_array($query),$url,$name,$selected);
}



//not batch wise
}else{
if($table){
$limit   = 30;
$name    = "examid";
$url    .= "&table=$table";
$query   = "SELECT DISTINCT $name FROM $table WHERE $name like '09%' or $name like '10%'  ORDER BY abs($name)" ;	
$selected= $examid;
print_items(item_array($query),$url,$name,$selected);
}


if(!empty($examid)){
$name    = "courseid";
$url    .= "&examid=$examid";
$query   = "SELECT DISTINCT $name FROM $table WHERE examid='$examid' ORDER BY $name";	
$selected= $courseid;

print_items(item_array($query),$url,$name,$selected);
}
if(!empty($courseid)){
$limit   = 1000;
$name    = "indexno";
$url    .= "&courseid=$courseid";
$query   = "SELECT DISTINCT $name FROM $table WHERE examid='$examid' AND courseid='$courseid' ORDER BY $name DESC LIMIT 1,$limit" ;	
$selected= $indexno;

print_items(item_array($query),$url,$name,$selected);
}

}

if(!empty($indexno)){
$limit   = 1000;
$name    = "courseid";
$url    .= "&indexno=$indexno";
$query   = "SELECT DISTINCT $name FROM $table WHERE examid='$examid' and indexno='$indexno' ORDER BY $name DESC LIMIT 1,$limit" ;	
$selected= $courseid2;

print_items(item_array($query),$url,"courseid2",$selected);

}

if(!empty($courseid2)){
$name    = "final";
$url    .= "&courseid2=$courseid2";
$query   = "SELECT $name FROM $table WHERE examid='$examid' and indexno='$indexno' and courseid = '$courseid2'" ;	
$selected= $final;

print_items(item_array($query),$url,"courseid2",$selected);

}

echo "</tr></table>
    <script>
      setScrollXY(\"$name\",".(empty($_GET['scroll_box'])?0:$_GET['scroll_'.$name]).",".(empty($_GET['scroll_left_box'])?0:$_GET['scroll_left_'.$name]).");
   </script> 
</div>
";
?>

