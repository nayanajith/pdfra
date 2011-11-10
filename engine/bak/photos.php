<?php
$cs_photos='2010-CS-PHOTO';
$ict_photos='2010-ICT-PHOTO';
$dir=$_GET['dir'];

if(empty($dir)){
	echo "<a href='?dir=$cs_photos'>CS</a><br/>";
	echo "<a href='?dir=$ict_photos'>ICT</a>";
	return;
}
$columns=5;
$width='';
$height='200px';
$padding='5px';
$spacing='5px';
// Open a known directory, and proceed to read its contents
$count=1;
if (is_dir($dir)) {
	if ($dh = opendir($dir)) {
		echo "<table cellpadding=$padding cellspacing=$cpacing><tr>";
		while (($file = readdir($dh)) !== false) {
			$file_info = getimagesize("$dir/$file");
			if($file_info['mime']=='image/jpeg'){
				$arr=explode(".", $file);
				$reg= $arr[0];

				echo "<td align=center><img src='$dir/$file' width='$width' height='$height' ><br/><h3>$reg</h3></td>\n";
				if($count%$columns==0){
					echo "</tr><tr>\n";
				}
				$count++;
			}
		}
		echo "</tr></table>";
		closedir($dh);
	}
}
?>
