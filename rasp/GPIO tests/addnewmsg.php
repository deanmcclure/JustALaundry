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


<header>Add new message</header>

<form role="form" method='POST' action='scripts/addwebmsg.php'>
  <div class="form-group"  title="Add New Shirt Report">
    <label for="MachinePin">Machine GPIO Pin</label>
    <input class="form-control" name="MachinePin" placeholder="Enter GPIO Pin Number">
  </div>
  <div class="form-group">
    <label for="State">GPIO Trigger State (0 = Falling Edge, 1 = Rising Edge)</label>
    <input class="form-control" name="STATE" placeholder="Enter State to Trigger on">
  </div>
  <div class="form-group">
    <label for="Tweet">Tweet</label>
    <input class="form-control" name="TWEET" placeholder="Enter Tweet to send">
  </div>
  <button type="submit" class="btn btn-default">Add Message</button>
</form>





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
