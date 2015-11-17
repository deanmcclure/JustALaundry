<html  lang="en-US">
<meta charset="windows-1252">

<head>
<link rel="stylesheet" href="resources/bootstrap/css/bootstrap.css">

<style>
        body { font-size: 62.5%; }
        label, input { display:block; }
        input.text { margin-bottom:12px; width:95%; padding: .4em; }
        fieldset { padding:0; border:0; margin-top:25px; }
        h1 { font-size: 1.2em; margin: .6em 0; }
        div#users-contain { width: 350px; margin: 20px 0; }
        div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
        div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
        .ui-dialog .ui-state-error { padding: .3em; }
        .validateTips { border: 1px solid transparent; padding: 0.3em; }
</style>

<head>
</head>
<body>


<header>Active Hardware Alarms</header>
<table cellpadding="0" id="MSGTable" cellspacing="0" border="0" class="table table-striped table-bordered">
<?php 
 //Get DIP Messages
    require_once 'scripts/data_query.php';
    $DIPMsgQuery = "SELECT CONCAT_WS(' & ',GPIO_B.Description,GPIO_A.Description) AS 'Description', DIPMessages.DIPPin AS 'DIP', GPIO_A.STATE AS 'EN', DIPMessages.MachinePin AS 'Machine', DIPMessages.ACTIVE, DIPMessages.TWEET
                FROM DIPMessages 
				LEFT JOIN GPIO GPIO_A
				ON GPIO_A.GPIO = DIPMessages.DIPPin
				LEFT JOIN GPIO GPIO_B ON GPIO_B.GPIO = DIPMessages.MachinePin
				ORDER BY GPIO_B.Description ASC";
   ArrayToTable(SQLQueryToArray($DIPMsgQuery));
?>
</table>

<br>

<header>Active Web Alarms</header>
<table cellpadding="0" id="MSGTable" cellspacing="0" border="0" class="table table-striped table-bordered">
<?php 
 //Get Web Messages
    require_once 'scripts/data_query.php';
	$WEBMsgQuery = "SELECT WebMessages.ID, GPIO.Description, WebMessages.ACTIVE, WebMessages.TWEET
					FROM WebMessages 
					LEFT JOIN GPIO ON GPIO.GPIO = WebMessages.MachinePin
					ORDER BY WebMessages.Active DESC, WebMessages.ID ASC";
	$what = ArrayToTablewithDelete(SQLQueryToArray($WEBMsgQuery));
?>
</table>
<button type="button" class="btn btn-default btn-lg" >
  <span class="glyphicon glyphicon-plus"></span> <a href="addnewmsg.php">Add New Message</a>
</button>

<br><br>


<header>GPIO</header>
<table cellpadding="0" id="GPIOTable" cellspacing="0" border="0" class="table table-striped table-bordered">
<?php 
 //Get IO State
    require_once 'scripts/data_query.php';
    $GPIOState = "SELECT *
                FROM GPIO";
   ArrayToTable(SQLQueryToArray($GPIOState));
?>
</table>


</body>
</html>