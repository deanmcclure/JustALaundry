<?php
// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');
//$query - SQL Query to sent

// TEST variable query
// $query = "SELECT 	`Job Number`,
// 					Description 
// 			FROM jobs";



$mysqlcSTR = "localhost";
$mysqlUser = "root";
$mysqlPass = "password";
$mysqlName = "timekeeper";

//Stop if $query is not defined
if (!isset($query))
{
	echo "No Query - \$query not defined";
	return null;
}

//escape the character in the query

//Get SQL results
$connect = mysql_connect($mysqlcSTR, $mysqlUser, $mysqlPass);
mysql_select_db($mysqlName, $connect);
$result = mysql_query($query);
// while ($rows[] = mysql_fetch_assoc($result))
// $rows = []
if (!$result)
{
	die('Could not connect: ' . mysql_error());
}

while ($row = mysql_fetch_assoc($result)) {
	$rows[] = (($row));
}
print_r(json_encode($rows));
mysql_close($connect);

?>