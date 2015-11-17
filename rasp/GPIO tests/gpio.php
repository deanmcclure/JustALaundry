<html>
<head>
<title>GPIO Test Page</title>
</head>
<p>GPIO Test Page</p>
<form action="gpio.php" method="get">
<input type="submit" value="Turn On">
<input type="hidden" name="action" value="on">
</form>
<form action="gpio.php" method="get">
<input type="submit" value="Turn Off">
<input type="hidden" name="action" value="off">
</form>
</html>
<?php
$filename = "gpio.txt";
If (isset($_GET['action'])){
	If ($_GET['action'] == "on"){
		$fileHandle = fopen($filename, 'w') or die ("can't open file");
		fclose($fileHandle);
	} else If ($_GET['action'] == "off"){
		unlink($filename);
	}
}
?>
