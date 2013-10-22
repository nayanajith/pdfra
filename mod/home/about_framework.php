<?php 
$vfile="/tmp/yape_version";
exec('git log -1 '.A_ROOT.' > '.$vfile);
$version_local=exec('awk -F: /Date/\'{print $2":"$3":"$4}\' '.$vfile);
//exec('git log -1 origin/master > '.$vfile);
//$version_origin=exec('awk -F: /Date/\'{print $2":"$3":"$4}\' '.$vfile);

?>
<table>
   <tr>
      <td rowspan="4">
         <img src="<?php echo IMG."/black_feather.svg"; ?>" width="150px">
      </td>
      <td style="font-size:25px">
         YAPE
      </td>
   </tr>
   <tr>
      <td style="color:gray">
		You are currently in the release on <?php echo $version_local ?>.<!-- Latest version is at  <?php echo $version_origin ?> -->
      </td>
   </tr>
   <tr>
      <td>
         YAPE is a web application framework which allow users to create a high grade web application in few minuts.
      </td>
   </tr>
   <tr>
      <td >
         <div style="font-weight:bold">Modules enabled</div>
         <div style="overflow:auto;overflow-x:hidden;height:110px">
            <ul>
<?php
foreach($GLOBALS['MODULES'] as $key =>$arr){
	if(is_array($arr)){
		echo "<li>".$arr['MODULE'];
	}else{
		echo "<li>".$arr;
	}
}
?>
            </ul>
         </div>
      </td>
   </tr>
   <tr>
      <td colspan="2" style="color:gray; background-color:whitesmoke;font-size:8px;align:center" align="center">
         Yape and yape logos are trade marks of UCSC.<br>Developed by Nayanajith Mahendra Laxaman, mail: nmlaxaman@gmail.com
      </td>
   </tr>
</table>
