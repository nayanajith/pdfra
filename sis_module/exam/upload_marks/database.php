<?php
/*
 * Database connection
 * @return:mysql_connection
 */
function openDB($DB){
	$con=mysql_connect("localhost","root","letmein") or die("Could not connect database".mysql_error());
	$selDB=mysql_select_DB($DB) or die("Could not select database".mysql_error());
	if(!$selDB) $con = FALSE;
	return $con;
}
?>