<?php
/*
 * <marks user="nayanajith"><student id="1" INDEX_NO="07000014" PAPER="0" ASSIGNMENT="85" PUSH=""/></marks>
 */
$xml = simplexml_load_file('test.xml');
$i=0;
$cols=array("id"=>"","INDEX_NO"=>"","PAPER"=>"","ASSIGNMENT"=>"","PUSH"=>"");
foreach($xml->student as $student) {
   foreach ($cols as $key => $value) {
      $student_arr=$student->attributes();
      //echo  $key."=".$student_arr[$key]."<br/>";
   }
}

function get_row($xml,$row_id,$cols){
   foreach($xml->student[$row_id]->attributes() as $a => $b) {
      $cols[$a]=$b;
   }
   return $cols;
}
$abc=get_row($xml,2,$cols);
echo $abc['id'];
?>

