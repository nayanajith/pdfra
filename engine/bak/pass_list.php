<?php
include_once("config.php");
include_once("student.php");
openDB();

if(empty($_GET['batch']) || empty($_GET['scheme'])){
	echo "Please Provide BATCHID";
	return;
}

$batch		=$_GET['batch'];
$fouthyear	=null;
$repeat		=null;
$all			=true;

if(!empty($_GET['all'])){
	$all=true;
}else{
	$all=false;
}

$all			=false;

$cs_repeat=array(
"A0427",
"A1067",
"A1113", 
"A1121",

"04000072",
"04000392",
"04000919",
"04000978",

"05000132",
"05000191",
"05000505",
"05000612",
"05000858",
"05001196",
"05001293",
"05001536",
"04000331",

"06000053",
"06000436",
"06000673",
"06000827",
"06000916",
"06000942",
"06001149",
"06001181",
"06001343",
"06001386"
);

$it_repeat=array(
'06020577',
'06020555'
);

$cs_fourthyear=array(
'00000000',
'07000032',
'07000049',
'07000081',
'07000121',
'07000146',
'07000278',
'07000308',
'07000342',
'07000359',
'07000367',
'07000383',
'07000464',
'07000545',
'07000588',
'07000707',
'07000723',
'07000758',
'07000774',
'07000782',
'07000792',
'07000804',
'07000822',
'07000839',
'07000871',
'07000987',
'07000995',
'07001053',
'07001061',
'07001185',
'07001207',
'07001241',
'07001282',
'07001381',
'07001411',
'07001551'
);

$it_fourthyear=array(
'00000000',
'07020082',
'07020092',
'07020104',
'07020155',
'07020198',
'07020236',
'07020317',
'07020325',
'07020406',
'07020481',
'07020521',
'07020562',
'07020643',
'07020716',
'07020742',
'07020767'
);

$scheme=$_GET['scheme'];
switch($_GET['scheme']){
	case 'cs':
		$table='csstudent';
		$fourthyear=$cs_fourthyear;
		$repeat=$cs_repeat;
		break;
	case 'it':
		$table='itstudent';
		$fourthyear=$it_fourthyear;
		$repeat=$it_repeat;
		break;
}


$classes=array("P"=>2,"2L"=>3,"2U"=>3.25,"1"=>3.5);

$first	=array();
$secondU	=array();
$secondL	=array();
$pass		=array();
$fail		=array();

$query	="SELECT DISTINCT indexno FROM $table WHERE batch='$batch' ORDER BY indexno";
$result  = mysql_query($query, $GLOBALS['CONNECTION']);

while ($row = mysql_fetch_array($result)) {
	$indexno=$row['indexno'];
	$info="<td>";
	if(array_search($indexno, $fourthyear) ){
		$info="<td class=fourth>";
		if(!$all){
			continue;
		}
	}
	$student = new Student($scheme,$indexno,null);

	if($student->degEligi()!=1){
		continue;
	}

	//	$info="<td>".$indexno."</td><td>".$student->getTitle()."&nbsp;".$student->getName(true).$student->getCGPA().$student->printState($student->getState())."</td></tr>";
	$info.=$indexno."</td><td>".$student->getTitle()."&nbsp;".$student->getName(true)."|".$student->getCGPA()."|".$student->getDGPA()."</td></tr>";
	switch($student->getClass(false)){
		case 1:
			$first[$indexno]=$info;
			break;
		case '2U':
			$secondU[$indexno]=$info;
			break;
		case '2L':
			$secondL[$indexno]=$info;
			break;
		case 'P':
			$pass[$indexno]=$info;
			break;
		case -1:
			$fail[$indexno]=$info;
			break;
	}
}



foreach ($repeat as  $indexno) {

	$info="<td>";
	if(array_search($indexno, $fourthyear) ){
		$info="<td class=fourth>";
		if(!$all){
			continue;
		}
	}
	$student = new Student($scheme,$indexno,null);
	if($student->degEligi()!=1){
		continue;
	}

	$info.=$indexno."</td><td>".$student->getTitle()."&nbsp;".$student->getName(true)."</td></tr>";
	switch($student->getClass(false)){
		case 1:
			$first[$indexno]=$info;
			break;
		case '2U':
			$secondU[$indexno]=$info;
			break;
		case '2L':
			$secondL[$indexno]=$info;
			break;
		case 'P':
			$pass[$indexno]=$info;
			break;
		case -1:
			$fail[$indexno]=$info;
			break;
	}
}


asort($first);
asort($secondU);
asort($secondL);
asort($pass);
asort($fail);


?>
<style>
td {
	padding: 7px;
}

h1 {
	font-size: 18px;
}

h2 {
	font-size: 16px;
}

h3 {
	font-size: 14px;
	text-transform: uppercase;
	text-align: center;
	text-decoration: underline;
}

body {
	background: silver;
}

* {
	font-size: 12px;
}

.a4 {
	background: white;
	padding: 20mm;
	width: 170mm;
	/*width: 210mm;*/ /*height:297mm;*/
	margin-left: auto;
	margin-right: auto;
	/*border:1px solid black;*/
}

#ucsc_logo {
	width: 22mm;
}

#uoc_logo {
	width: 18mm;
}

.fourth {
	border: 1px solid black;
}
</style>
<body>
<div class='a4'>
<center><img src='images/UCSC-Logo.gif' id=ucsc_logo /> <img
	src='images/UOC-Logo.jpg' id=uoc_logo />
<h2>UNIVERSITY OF COLOMBO</h2>
<h2>UNIVERSITY OF COLOMBO SCHOOL OF COMPUTING</h2>
<h3>Bachelor of Information & Communication Technology -AY 2006/2007</h3>
<h1>RESULTS</h1>
(Released subject to confirmation by the Senate)</center>
<?php
$th="<tr><th>Serial No.</th><th>Registration No.</td><th>Name of the Awardee</th></tr>";
echo "<h3>First Class</h3>\n";
echo "<table>".$th;
$i=1;
foreach ($first as $key => $value) {
	echo "<tr><td>".($i++)."</td>".$value."\n";
}
echo "</table>";
echo "<h3>Second Class (Upper DIVISION)</h3>";
echo "<table >".$th;
$i=1;
foreach ($secondU as $key => $value) {
	echo "<tr><td>".($i++)."</td>".$value."\n";
}
echo "</table>";
echo "<h3>Second CLASS (Lower DIVISION)</h3>";
echo "<table >".$th;
$i=1;
foreach ($secondL as $key => $value) {
	echo "<tr><td>".($i++)."</td>".$value."\n";
}
echo "</table>";
echo "<h3>Pass</h3>";
echo "<table >".$th;
$i=1;
foreach ($pass as $key => $value) {
	echo "<tr><td>".($i++)."</td>".$value."\n";
}
echo "</table>";

if($all){
	echo "<h3>Fail</h3>";
	echo "<table >".$th;
	$i=1;
	foreach ($fail as $key => $value) {
		echo "<tr><td>".($i++)."</td>".$value."\n";
	}
	echo "</table>";
}

echo "<div style='height:20mm'></div>";
$effective='01<sup>st</sup> November 2010';
echo "<div align=center><b>Effective Date:".$effective."</b></div><br/><br/>";
echo "<table style='border-collapse:collapse' border=1>";
$first_count=sizeof($first);
$secondL_count=sizeof($secondL);
$secondU_count=sizeof($secondU);
$pass_count=sizeof($pass);
$fail_count=sizeof($fail);
echo "<tr><th>RESULT</th><th>TOTAL</th></tr>";
echo "<tr><td>First Class</th><td>".$first_count."</td></tr>";
echo "<tr><td>Second Class (Upper Division)</th><td>".$secondU_count."</td></tr>";
echo "<tr><td>Second Class (Lower Division)</th><td>".$secondL_count."</td></tr>";
echo "<tr><td>Pass</th><td>".$pass_count."</td></tr>";
if($all){
	echo "<tr><td>Pass</th><td>".$fail_count."</td></tr>";
	echo "<tr><th>TOTAL</th><th>".($first_count+$secondU_count+$secondL_count+$pass_count)."</th></tr>";
}else{
	echo "<tr><th>TOTAL</th><th>".($first_count+$secondU_count+$secondL_count+$pass_count)."</th></tr>";
}
echo "</table><br/><br/>";
?>
<table width=100% cellpadding=0 cellspacing=0>
	<tr>
		<td>Examination Branch<br />
		Univerisiy of Colombo SChool of Computing<br />
		<br />
		<?php echo date('jS \of F Y'); ?></td>
		<td style='text-align: top'><b>Vice Chancellor</b></td>

</table>

</div>
<body>
