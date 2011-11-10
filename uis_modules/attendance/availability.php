<h2>Availability of the Employees</h2>
<?php
$sql_id= "
	SELECT Event_UserID
	FROM in_out 
	WHERE YEAR(Event_DateTime_Str)=YEAR(NOW()) 
	AND MONTH(Event_DateTime_Str)=MONTH(NOW()) 
	AND DAY(Event_DateTime_Str)=DAY(NOW())
	ORDER BY Event_DateTime_Str ASC";

$sql_name="SELECT OtherName
            FROM employee
            WHERE EmployeeNo IN (%s)
				ORDER BY OtherName";


if($GLOBALS['DB_TYPE']=='mssql'){
	$sql_id="SELECT Event_UserID
            FROM TBL_History
            AND (DATEPART(yy, Event_DateTime_Str) = DATEPART(yy, GETDATE())) 
            AND (DATEPART(mm, Event_DateTime_Str) = DATEPART(mm, GETDATE()))
            AND (DATEPART(dd, Event_DateTime_Str) = DATEPART(dd, GETDATE()))
            ORDER BY Event_DateTime_Str DESC";

	$sql_name="SELECT OtherName
            FROM Employee
            WHERE EmployeeNo IN (%s)
				ORDER BY OtherName";
}
/*
 * SELECT DISTINCT emp.OtherName, io.Event_DateTime_Str
 FROM in_out io, employee emp
 WHERE io.Event_UserID=emp.EmployeeNo
 AND DATEPART(yy,Event_DateTime_Str)=DATEPART(yy,GETDATE())
 AND DATEPART(mm,Event_DateTime_Str)=DATEPART(mm,GETDATE())
 AND DATEPART(dd,Event_DateTime_Str)=DATEPART(dd,GETDATE())
 ORDER BY Event_DateTime_Str ASC
  
  
 SELECT DISTINCT emp.OtherName, io.Event_DateTime_Str
 FROM in_out io, employee emp
 WHERE io.Event_UserID=emp.EmployeeNo
 AND GETDATE(Event_DateTime_Str)=GETDATE()
 ORDER BY Event_DateTime_Str ASC
 */

opendb();

$res 	= null;
if($GLOBALS['DB_TYPE']=='mssql'){
	mssql_select_db("KEICONEW", $GLOBALS['CONNECTION']);
   $res 	= mssql_query($sql_id,$GLOBALS['CONNECTION']);
}else{
   $res 	= mysql_query($sql_id,$GLOBALS['CONNECTION']);
}

//List of ids available
$id_list=array();
//while($row=mssql_fetch_array($res)){
while($row=mysql_fetch_array($res)){
	$id_list[]="'".$row['Event_UserID']."'";
}

if(sizeof($id_list) == 0){
	echo "None arrieved yet...";
	return; 
}

$res 	= null;
if($GLOBALS['DB_TYPE']=='mssql'){
	mssql_select_db("UCSCAttendance",$GLOBALS['CONNECTION']);
   $res 	= mssql_query(sprintf($sql_name,implode(",",$id_list)),$GLOBALS['CONNECTION']);
}else{
   $res 	= mysql_query(sprintf($sql_name,implode(",",$id_list)),$GLOBALS['CONNECTION']);
}

closeDB();

echo "<ol>";
//while($row =mssql_fetch_array($res)){
while($row =mysql_fetch_array($res)){
	echo "<li>".$row['OtherName']."</li>";
}
echo "</ol>";

?>
