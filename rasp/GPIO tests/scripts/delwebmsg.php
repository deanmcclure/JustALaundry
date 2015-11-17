<html>
<body>
DELETED!
<?php 
//Add Message to DB
header("Location: $originpage");
    require_once 'data_query.php';
    $DelQuery = "DELETE FROM WebMessages WHERE ID='$_POST[ID]'";
	SQLQueryDo($DelQuery);
?>
</body>
</html>