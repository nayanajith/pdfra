<?php
$query="SELECT g.IndexNo,s.fullname,g.GPAT,
IF(g.GPAT>3.5,'First Class',IF(g.GPAT>3.25,'Second Class Upper',IF(g.GPAT>3,'Second Class',IF(g.GPAT>2,'Pass','Fail')))) AS class 
FROM itgpv AS g,itstudent AS s 
WHERE g.IndexNo=s.IndexNo AND g.IndexNo LIKE '06%' AND g.GPV4>0  
ORDER BY g.GPAT DESC";

opendb();
mysql_select_DB('courseadmin', $GLOBALS['CONNECTION']);
$result  = mysql_query($query, $GLOBALS['CONNECTION']);
echo "<h2>Fourth year pass list</h2>";
echo "<table  border=1 cellpadding=5 style='border-collapse:collapse;' >";
echo"    <thead>
        <tr>
            <th field='IndexNo'>
					IndexNo
            </th>
            <th field='IndexNo'>
					Full Name	
            </th>
            <th field='IndexNo'>
				GPA	
            </th>
            <th field='IndexNo'>
					Class
            </th>

       </tr>
    </thead>";

while( $row = mysql_fetch_array($result)){
	echo "<tr><td style='padding:5px;'>".$row['IndexNo']."</td><td>".$row['fullname']."</td><td>". $row['GPAT']."</td><td>". $row['class']."</td></tr>\n";	
}
echo "</table>";
closedb();
?>
