<?php



function SQLQueryToArray($query) {

	$mysqlcSTR = "localhost";
	$mysqlUser = "laundry";
	$mysqlPass = "happy";
	$mysqlName = "laundry";
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

	if (isset($result))
	{
		$rows = null;
		while ($row = mysql_fetch_assoc($result)) 
		{
			$rows[] = (($row));	
		}
	}
	else
	{
		$rows[] = null;
	}
	mysql_close($connect);
	return($rows); 
}

function ArrayToTable($array) {

	//echo "<table>";
	echo "<thead>";
	echo "<tr>";
	//Get First row of data (as the first row has already been fetched)
	$keys = array_keys($array[0]);
	for ($i = 0; isset($keys[$i]); $i++) {
		echo "<th>";
		echo ($keys[$i]);
		echo "</th>";
	}echo "
	";
	echo "</tr>";
	//Get First row of data (as the first row has already been fetched)

	echo "</thead>";
	echo "<tbody>";
	for ($j = 0; isset($array[$j]); $j++) {
		echo "<tr>";
		for ($i = 0; isset($keys[$i]); $i++) {
			echo "<td>";
			echo $array[$j][$keys[$i]];
			echo "</td>";
		}
		echo "</tr>";
		echo "
			";
	}
	echo "</tr>";
	echo "</tbody>";
	//echo "</table>";
	//if (isset($keys[0])) {  print 'one'; return(1);} 
	//else {print 'none';return(0); }
	return(isset($keys[0]));
}

function ArrayToTablewithDelete($array) {

	//echo "<table>";
	echo "<thead>";
	echo "<tr>";
	//Get First row of data (as the first row has already been fetched)
	$keys = array_keys($array[0]);
	for ($i = 0; isset($keys[$i]); $i++) {
		echo "<th>";
		echo ($keys[$i]);
		echo "</th>";
	}echo "
	";
	echo "</tr>";
	//Get First row of data (as the first row has already been fetched)

	echo "</thead>";
	echo "<tbody>";
	for ($j = 0; isset($array[$j]); $j++) {
		echo "<tr>";
		echo "<form method='POST' action='scripts/delwebmsg.php'>";
		echo "<input type='hidden' name='ID' value='" . $array[$j]['ID'] . "'>";
		for ($i = 0; isset($keys[$i]); $i++) {
			echo "<td>";
			#echo "<td>";
			echo $array[$j][$keys[$i]];
			echo "</td>";
		}
		echo "<td> <button type='submit'  class='btn btn-default' >Delete Msg</button> </td>";
		echo "</form>";
		echo "</tr>";
		echo "
			";
	}
	echo "</tr>";
	echo "</tbody>";
	//echo "</table>";
	//if (isset($keys[0])) {  print 'one'; return(1);} 
	//else {print 'none';return(0); }
	return(isset($keys[0]));
}

function SQLQueryDo($query) {

	$mysqlcSTR = "localhost";
	$mysqlUser = "laundry";
	$mysqlPass = "happy";
	$mysqlName = "laundry";
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
	mysql_close($connect);
}

?>