<html>
<body>
Added!
<?php 
//Add Message to DB
header("Location: $originpage");
    require_once 'data_query.php';
    $AddQuery = "INSERT INTO `WebMessages` (`ID`, `MachinePin`, `STATE`, `TWEET`, `ACTIVE`) VALUES (NULL, '$_POST[MachinePin]', '$_POST[STATE]', '$_POST[TWEET]', '0')";
	SQLQueryDo($AddQuery);
?>
</body>
</html>